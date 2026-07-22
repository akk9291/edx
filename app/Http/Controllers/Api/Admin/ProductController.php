<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * List products (paginated)
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('sku', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Create product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'meta_keywords' => 'nullable|string|max:1000',
            'sku' => 'nullable|string|unique:products,sku',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'in_stock' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'product_type' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['price'] = array_key_exists('price', $validated) && $validated['price'] !== null ? (float) $validated['price'] : 0;
        if (! array_key_exists('sale_price', $validated) || $validated['sale_price'] === '' || $validated['sale_price'] === null) {
            $validated['sale_price'] = null;
        } else {
            $validated['sale_price'] = (float) $validated['sale_price'];
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load('category'),
        ], 201);
    }

    /**
     * Get product
     */
    public function show($id)
    {
        $product = Product::with(['category', 'inventories'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', \Illuminate\Validation\Rule::unique('products', 'slug')->ignore($id)],
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'sometimes|required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'meta_keywords' => 'nullable|string|max:1000',
            'sku' => ['nullable', 'string', \Illuminate\Validation\Rule::unique('products', 'sku')->ignore($id)],
            'stock_quantity' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'in_stock' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'product_type' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (array_key_exists('price', $validated)) {
            $validated['price'] = $validated['price'] !== null ? (float) $validated['price'] : 0;
        }
        if (array_key_exists('sale_price', $validated)) {
            $validated['sale_price'] = $validated['sale_price'] !== null && $validated['sale_price'] !== ''
                ? (float) $validated['sale_price']
                : null;
        }

        // Update slug if name changed
        if ($request->has('name') && $validated['name'] != $product->name && empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->fresh()->load('category'),
        ]);
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Toggle product active status
     */
    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated',
            'data' => $product,
        ]);
    }
}




