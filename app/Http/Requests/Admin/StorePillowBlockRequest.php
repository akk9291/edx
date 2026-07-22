<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePillowBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:50000',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:pillow_blocks,sku',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:51200',
            'pdf_catalogue' => 'nullable|file|mimes:pdf|max:10240',
            'equiv_skf' => 'nullable|string|max:255',
            'equiv_fag' => 'nullable|string|max:255',
            'equiv_ntn' => 'nullable|string|max:255',
            'equiv_timken' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'meta_keywords' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'in_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',

            // Specifications
            'bearing_number' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
            'specifications.*.title' => 'nullable|string|max:255',
            'specifications.*.dimension' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:255',
        ];
    }
}
