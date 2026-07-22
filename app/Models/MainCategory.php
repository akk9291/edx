<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'hero_image',
        'hero_text',
        'hero_button_text',
        'banner_images',
        'banner_texts',
        'bottom_banner_image',
        'bottom_banner_text',
        'testimonial_text',
        'additional_banner_image',
        'additional_banner_text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'banner_images' => 'array',
        'banner_texts' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get categories under this main category
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'main_category_id');
    }

    /**
     * Get active categories
     */
    public function activeCategories()
    {
        return $this->hasMany(Category::class, 'main_category_id')->where('is_active', true);
    }

    /**
     * Main category id for the EDX bearing shop (slug: bearings).
     */
    public static function bearingsCatalogId(): ?int
    {
        return self::where('slug', 'bearings')->value('id');
    }
}
