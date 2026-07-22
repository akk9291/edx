<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'guest_name',
        'guest_email',
        'rating',
        'comment',
        'is_approved',
        'parent_id',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ProductReview::class, 'parent_id');
    }

    public function getReviewerNameAttribute(): string
    {
        if ($this->user_id && $this->user) {
            return $this->user->name ?? 'User';
        }
        return $this->guest_name ?? 'Guest';
    }
}
