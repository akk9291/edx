<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
        'size',
        'color',
        'customization_json',
        'customization_image',
        'custom_unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'custom_unit_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get unit price (variant price when color/size set, else product price)
     */
    public function getUnitPriceAttribute()
    {
        if ($this->custom_unit_price !== null && $this->custom_unit_price !== '') {
            return (float) $this->custom_unit_price;
        }

        $product = $this->product;
        if (!$product) {
            return 0;
        }
        if (($this->color !== null && $this->color !== '') || ($this->size !== null && $this->size !== '')) {
            $inventory = \App\Models\Inventory::where('product_id', $product->id)
                ->where('color', $this->color ?? '')
                ->where('size', $this->size ?? '')
                ->first();
            if ($inventory) {
                $price = $inventory->sale_price ?? $inventory->price ?? null;
                if ($price !== null && (float) $price > 0) {
                    return (float) $price;
                }
            }
        }
        return (float) ($product->sale_price ?? $product->price ?? 0);
    }

    /**
     * Get subtotal (quantity * unit price) – uses variant price when color/size set
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}




