<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * List categories
     */
    public function index(Request $request)
    {
        $query = Category::with(['mainCategory', 'parent', 'children']);

        if ($request->has('main_category_id')) {
            $query->where('main_category_id', $request->main_category_id);
        }

        if ($request->has('parent_id')) {
            if ($request->parent_id === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('slug', 'LIKE', '%' . $search . '%');
            });
        }

        $categories = $query->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Create category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'main_category_id' => 'nullable|exists:main_categories,id',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category->load(['mainCategory', 'parent']),
        ], 201);
    }

    /**
     * Get category
     */
    public function show($id)
    {
        $category = Category::with(['mainCategory', 'parent', 'children'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    /**
     * Update category
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', \Illuminate\Validation\Rule::unique('categories', 'slug')->ignore($id)],
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'main_category_id' => 'nullable|exists:main_categories,id',
            'parent_id' => ['nullable', 'exists:categories,id', function ($attribute, $value, $fail) use ($id) {
                if ($value == $id) {
                    $fail('Category cannot be its own parent.');
                }
            }],
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Update slug if name changed
        if ($request->has('name') && $validated['name'] != $category->name && empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category->fresh()->load(['mainCategory', 'parent', 'children']),
        ]);
    }

    /**
     * Delete category
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if has products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with products. Please delete or move products first.',
            ], 400);
        }

        // Check if has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with sub-categories. Please delete or move sub-categories first.',
            ], 400);
        }

        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ]);
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated',
            'data' => $category,
        ]);
    }
}




