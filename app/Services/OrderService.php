<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\LoyaltyPoints;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\VendorEarning;
use App\Models\WalletTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    protected ProductRepositoryInterface $productRepo;
    protected OrderRepositoryInterface $orderRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Process checkout and place order.
     */
    public function checkout(User $customer, array $cartItems, string $paymentMethod, ?string $couponCode = null, ?int $addressId = null, ?string $notes = null): Order
    {
        return DB::transaction(function () use ($customer, $cartItems, $paymentMethod, $couponCode, $addressId, $notes) {
            // 1. Calculate Prices & Validate Stock
            $subtotal = 0.00;
            $taxAmount = 0.00;
            $itemsToCreate = [];

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = $item['quantity'];

                // Validate stock (sum across all warehouses)
                $totalStock = $product->total_stock;
                if ($totalStock < $qty) {
                    throw new \Exception("Product '{$product->name}' is out of stock or does not have requested quantity.");
                }

                $itemSubtotal = $product->selling_price * $qty;
                // GST Calculation: selling price includes GST, or GST is added? Let's assume it is added.
                $itemTax = round(($itemSubtotal * $product->gst_rate) / 100, 2);

                $subtotal += $itemSubtotal;
                $taxAmount += $itemTax;

                $itemsToCreate[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'price' => $product->selling_price,
                    'tax' => $itemTax,
                    'total' => $itemSubtotal + $itemTax
                ];
            }

            // 2. Coupon Discount Calculation
            $discount = 0.00;
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon && $coupon->isValidForAmount($subtotal)) {
                    $discount = $coupon->calculateDiscount($subtotal);
                }
            }

            // 3. Shipping Calculation
            // Free shipping on orders above ₹2000, otherwise ₹150 flat rate
            $shipping = ($subtotal - $discount) > 2000 ? 0.00 : 150.00;

            // Total Amount
            $total = $subtotal + $taxAmount + $shipping - $discount;
            if ($total < 0) $total = 0.00;

            // 4. Wallet Deduction if Payment Method is Wallet
            if ($paymentMethod === 'Wallet') {
                $wallet = $customer->wallet;
                if (!$wallet || $wallet->balance < $total) {
                    throw new \Exception("Insufficient wallet balance. Total amount: ₹{$total}, Wallet balance: ₹" . ($wallet ? $wallet->balance : 0.00));
                }

                // Deduct balance
                $wallet->decrement('balance', $total);

                // Log Wallet Transaction
                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'Debit',
                    'amount' => $total,
                    'description' => 'Payment for order check-out.',
                ]);
            }

            // 5. Create Order
            $order = Order::create([
                'customer_id' => $customer->id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $taxAmount,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'Pending',
                'payment_status' => $paymentMethod === 'Wallet' ? 'Paid' : 'Unpaid',
                'payment_method' => $paymentMethod,
                'shipping_address_id' => $addressId,
                'notes' => $notes,
            ]);

            // 6. Create Order Items & Deduct Inventory Stock
            foreach ($itemsToCreate as $itemData) {
                $product = $itemData['product'];
                $qty = $itemData['quantity'];

                // Create Order Item record
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $itemData['price'],
                    'tax' => $itemData['tax'],
                    'total' => $itemData['total']
                ]);

                // Deduct stock from the first warehouse that has sufficient stock
                $this->deductStock($product->id, $qty);

                // 7. Calculate Vendor Earnings if the product belongs to a Vendor
                if ($product->vendor_id) {
                    $vendor = $product->vendor;
                    $itemGross = $itemData['total']; // including GST tax
                    $commissionRate = $vendor->commission_percentage;
                    $commission = round(($itemGross * $commissionRate) / 100, 2);
                    $netEarnings = $itemGross - $commission;

                    VendorEarning::create([
                        'vendor_id' => $vendor->id,
                        'order_id' => $order->id,
                        'gross_amount' => $itemGross,
                        'net_earnings' => $netEarnings,
                        'commission_deducted' => $commission,
                        'status' => 'Pending',
                    ]);
                }
            }

            // 8. Reward Loyalty Points (1 point per ₹100 of selling price, excluding taxes/shipping)
            $earnedPoints = floor($subtotal / 100);
            if ($earnedPoints > 0) {
                $loyalty = LoyaltyPoints::firstOrCreate(['user_id' => $customer->id]);
                $loyalty->increment('points_balance', $earnedPoints);
            }

            // 9. Write audit log
            activity()
                ->performedOn($order)
                ->causedBy($customer)
                ->withProperties(['total' => $total, 'payment_method' => $paymentMethod])
                ->log("Order {$order->order_number} successfully placed.");

            return $order;
        });
    }

    /**
     * Deduct inventory stock from warehouse(s).
     */
    protected function deductStock(int $productId, int $qty): void
    {
        $stocks = Stock::where('product_id', $productId)
            ->where('quantity', '>', 0)
            ->orderBy('quantity', 'desc')
            ->get();

        $remainingQty = $qty;

        foreach ($stocks as $stock) {
            if ($remainingQty <= 0) break;

            if ($stock->quantity >= $remainingQty) {
                $stock->decrement('quantity', $remainingQty);
                $remainingQty = 0;
            } else {
                $remainingQty -= $stock->quantity;
                $stock->update(['quantity' => 0]);
            }
        }

        if ($remainingQty > 0) {
            // If we still have remaining quantity (e.g. race conditions), force decrement a warehouse to go negative or trigger alert
            $firstStock = Stock::where('product_id', $productId)->first();
            if ($firstStock) {
                $firstStock->decrement('quantity', $remainingQty);
            }
        }
    }
}
