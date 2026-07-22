<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subtitle',
        'priority',
        'deeplink',
        'button_text',
        'banner_image',
        'is_active',
    ];

    protected $casts = [
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get active banners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by priority
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'asc')->orderBy('created_at', 'desc');
    }
}


