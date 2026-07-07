<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryService
{
    /**
     * Transfer stock between warehouses.
     */
    public function transferStock(int $sourceId, int $targetId, int $productId, int $qty, ?string $notes = null): StockTransfer
    {
        return DB::transaction(function () use ($sourceId, $targetId, $productId, $qty, $notes) {
            // Validate source stock
            $sourceStock = Stock::where('warehouse_id', $sourceId)
                ->where('product_id', $productId)
                ->first();

            if (!$sourceStock || $sourceStock->quantity < $qty) {
                $pName = Product::find($productId)?->name ?? 'Unknown Product';
                $wName = Warehouse::find($sourceId)?->name ?? 'Source Warehouse';
                throw new \Exception("Insufficient stock for '{$pName}' in warehouse '{$wName}'. Requested: {$qty}, Available: " . ($sourceStock ? $sourceStock->quantity : 0));
            }

            // Deduct from source
            $sourceStock->decrement('quantity', $qty);

            // Add to target
            $targetStock = Stock::firstOrCreate(
                ['warehouse_id' => $targetId, 'product_id' => $productId],
                ['low_stock_threshold' => 10]
            );
            $targetStock->increment('quantity', $qty);

            // Create Stock Transfer record
            $transfer = StockTransfer::create([
                'source_warehouse_id' => $sourceId,
                'target_warehouse_id' => $targetId,
                'status' => 'Completed',
                'notes' => $notes ?? "Transferred {$qty} units of Product #{$productId}.",
            ]);

            return $transfer;
        });
    }

    /**
     * Adjust stock for physical stock takes or damaged products.
     */
    public function adjustStock(int $warehouseId, int $productId, int $qtyAdjustment, string $reason): Stock
    {
        return DB::transaction(function () use ($warehouseId, $productId, $qtyAdjustment, $reason) {
            $stock = Stock::firstOrCreate(
                ['warehouse_id' => $warehouseId, 'product_id' => $productId],
                ['quantity' => 0, 'low_stock_threshold' => 10]
            );

            $newQuantity = $stock->quantity + $qtyAdjustment;
            if ($newQuantity < 0) {
                throw new \Exception("Cannot adjust stock. Resulting stock quantity would be negative ({$newQuantity}).");
            }

            $stock->update(['quantity' => $newQuantity]);

            activity()
                ->performedOn($stock)
                ->withProperties(['adjustment' => $qtyAdjustment, 'reason' => $reason])
                ->log("Stock adjusted in Warehouse #{$warehouseId} for Product #{$productId}. Reason: {$reason}.");

            return $stock;
        });
    }

    /**
     * Retrieve all items running low on stock.
     */
    public function getLowStockAlerts(): \Illuminate\Support\Collection
    {
        return Stock::with(['warehouse', 'product'])
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->get()
            ->map(function ($stock) {
                return [
                    'warehouse_name' => $stock->warehouse->name,
                    'product_name' => $stock->product->name,
                    'sku' => $stock->product->sku,
                    'quantity' => $stock->quantity,
                    'threshold' => $stock->low_stock_threshold,
                ];
            });
    }
}
