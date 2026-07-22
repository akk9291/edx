<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'main_category_ids',
        'discount_type',
        'discount_value',
        'valid_from',
        'valid_until',
        'is_active',
        'usage_limit',
        'used_count',
        'minimum_order_amount',
    ];

    protected $casts = [
        'main_category_ids' => 'array',
        'discount_value' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'minimum_order_amount' => 'decimal:2',
    ];

    /**
     * Get coupon usages
     */
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Get orders using this coupon
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if coupon is valid
     */
    public function isValid($orderAmount = 0, $mainCategoryIds = [], $userId = null)
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check date validity
        $now = Carbon::now();
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check minimum order amount
        if ($this->minimum_order_amount !== null && $orderAmount < $this->minimum_order_amount) {
            return false;
        }

        // Check category restrictions
        if ($this->main_category_ids !== null && !empty($this->main_category_ids)) {
            if (empty($mainCategoryIds) || empty(array_intersect($this->main_category_ids, $mainCategoryIds))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($amount)
    {
        if (!$this->isValid($amount)) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($amount * $this->discount_value) / 100;
            // Ensure discount doesn't exceed the order amount
            return min($discount, $amount);
        } else {
            // Fixed discount
            return min($this->discount_value, $amount);
        }
    }
}




