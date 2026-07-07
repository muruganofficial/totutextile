<?php

namespace App\Livewire\Shop;

use App\Models\Address;
use App\Models\Coupon;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.shop')]
class Cart extends Component
{
    public array $cart = [];
    public float $subtotal = 0.00;
    public float $tax = 0.00;
    public float $discount = 0.00;
    public float $shipping = 0.00;
    public float $total = 0.00;

    // Coupon fields
    public string $couponCode = '';
    public string $appliedCoupon = '';
    public string $couponMessage = '';

    // Checkout fields
    public string $paymentMethod = 'COD'; // COD, Wallet
    public string $address_line1 = '';
    public string $city = '';
    public string $state = '';
    public string $postal_code = '';
    public string $notes = '';

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0.00;
        $this->tax = 0.00;

        foreach ($this->cart as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            // Fetch product to get exact tax rate
            $product = \App\Models\Product::find($item['product_id']);
            $taxRate = $product ? $product->gst_rate : 18.00;
            $itemTax = ($itemSubtotal * $taxRate) / 100;

            $this->subtotal += $itemSubtotal;
            $this->tax += $itemTax;
        }

        // Apply coupon discount if any
        $this->discount = 0.00;
        if ($this->appliedCoupon) {
            $coupon = Coupon::where('code', $this->appliedCoupon)->first();
            if ($coupon && $coupon->isValidForAmount($this->subtotal)) {
                $this->discount = $coupon->calculateDiscount($this->subtotal);
            }
        }

        // Free shipping above ₹2000
        $netSubtotal = $this->subtotal - $this->discount;
        $this->shipping = $netSubtotal > 2000 || $netSubtotal <= 0 ? 0.00 : 150.00;

        $this->total = $this->subtotal + $this->tax + $this->shipping - $this->discount;
        if ($this->total < 0) $this->total = 0.00;
    }

    public function updateQuantity(string $key, int $qty)
    {
        if ($qty < 1) return;

        $this->cart[$key]['quantity'] = $qty;
        session()->put('cart', $this->cart);
        $this->calculateTotals();
    }

    public function removeFromCart(string $key)
    {
        unset($this->cart[$key]);
        session()->put('cart', $this->cart);
        $this->calculateTotals();
        $this->dispatch('toast', message: 'Item removed from cart.', type: 'info');
    }

    public function applyCoupon()
    {
        if (empty($this->couponCode)) {
            $this->couponMessage = 'Please enter a coupon code.';
            return;
        }

        $coupon = Coupon::where('code', $this->couponCode)->first();

        if (!$coupon) {
            $this->couponMessage = 'Invalid coupon code.';
            return;
        }

        if (!$coupon->isValidForAmount($this->subtotal)) {
            $this->couponMessage = 'Coupon expired or minimum spend amount of ₹' . $coupon->min_spend . ' not met.';
            return;
        }

        $this->appliedCoupon = $this->couponCode;
        $this->couponMessage = 'Coupon applied successfully!';
        $this->calculateTotals();
        $this->dispatch('toast', message: 'Coupon applied!', type: 'success');
    }

    public function placeOrder(OrderService $orderService)
    {
        if (!Auth::check()) {
            return $this->redirect('/login', navigate: true);
        }

        if (empty($this->cart)) {
            $this->dispatch('toast', message: 'Your shopping cart is empty.', type: 'error');
            return;
        }

        $this->validate([
            'address_line1' => 'required|string|min:10',
            'city' => 'required|string|min:2',
            'state' => 'required|string|min:2',
            'postal_code' => 'required|digits:6',
        ]);

        try {
            $user = Auth::user();

            // Create address first
            $address = Address::create([
                'user_id' => $user->id,
                'label' => 'Shipping',
                'address_line1' => $this->address_line1,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'is_default_shipping' => true,
            ]);

            // Execute checkout service
            $order = $orderService->checkout(
                $user,
                $this->cart,
                $this->paymentMethod,
                $this->appliedCoupon ?: null,
                $address->id,
                $this->notes
            );

            // Clear session cart
            session()->forget('cart');
            $this->cart = [];

            $this->dispatch('toast', message: 'Order placed successfully!', type: 'success');
            return $this->redirect('/dashboard', navigate: true);

        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $addresses = Auth::check() ? Auth::user()->addresses : collect([]);
        $walletBalance = Auth::check() && Auth::user()->wallet ? Auth::user()->wallet->balance : 0.00;

        return view('livewire.shop.cart', [
            'addresses' => $addresses,
            'walletBalance' => $walletBalance
        ]);
    }
}
