<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function items()
    {
        return $this->hasMany(FaqItem::class)->orderBy('sort_order');
    }

    public function activeItems()
    {
        return $this->hasMany(FaqItem::class)->where('is_active', true)->orderBy('sort_order');
    }
}
