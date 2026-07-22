<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
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
        'parent_id',
        'main_category_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
     * Get the main category.
     */
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    /**
     * Limit to categories under the EDX bearing main category (slug: bearings).
     */
    public function scopeForBearingsCatalog(Builder $query): Builder
    {
        $id = MainCategory::bearingsCatalogId();
        if ($id === null) {
            return $query;
        }

        return $query->where('main_category_id', $id);
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Check if category has children.
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the full path of the category.
     */
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }
}
