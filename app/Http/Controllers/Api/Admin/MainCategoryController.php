<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MainCategoryController extends Controller
{
    /**
     * List main categories
     */
    public function index(Request $request)
    {
        $query = MainCategory::with('categories');

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
     * Create main category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:main_categories,slug',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (MainCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = MainCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Main category created successfully',
            'data' => $category,
        ], 201);
    }

    /**
     * Get main category
     */
    public function show($id)
    {
        $category = MainCategory::with('categories')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    /**
     * Update main category
     */
    public function update(Request $request, $id)
    {
        $category = MainCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', \Illuminate\Validation\Rule::unique('main_categories', 'slug')->ignore($id)],
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Update slug if name changed
        if ($request->has('name') && $validated['name'] != $category->name && empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (MainCategory::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
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
            'message' => 'Main category updated successfully',
            'data' => $category->fresh()->load('categories'),
        ]);
    }

    /**
     * Delete main category
     */
    public function destroy($id)
    {
        $category = MainCategory::findOrFail($id);

        // Check if has categories
        if ($category->categories()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete main category with sub-categories. Please delete or move sub-categories first.',
            ], 400);
        }

        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Main category deleted successfully',
        ]);
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $category = MainCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Main category status updated',
            'data' => $category,
        ]);
    }
}




