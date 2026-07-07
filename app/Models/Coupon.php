<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_spend',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
    ];

    /**
     * Check if the coupon is valid for a given order amount.
     */
    public function isValidForAmount(float $amount): bool
    {
        if ($this->status !== 'Active') {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return $amount >= $this->min_spend;
    }

    /**
     * Calculate the discount amount.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            return round(($subtotal * $this->value) / 100, 2);
        }

        return min($this->value, $subtotal);
    }
}
