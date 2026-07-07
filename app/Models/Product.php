<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'vendor_id',
        'fabric_type',
        'name',
        'slug',
        'description',
        'care_instructions',
        'sku',
        'barcode',
        'cost_price',
        'selling_price',
        'gst_rate',
        'status',
        'attributes',
        'collections',
        'is_featured',
        'is_trending',
        'is_best_seller',
        'is_new_arrival',
        'is_flash_sale',
        'is_offer_product',
    ];

    protected $casts = [
        'attributes' => 'array',
        'collections' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_flash_sale' => 'boolean',
        'is_offer_product' => 'boolean',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'gst_rate' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Get the total stock across all warehouses.
     */
    public function getTotalStockAttribute(): int
    {
        return $this->stocks()->sum('quantity');
    }
}
