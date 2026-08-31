<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * By default only categories under the bearing main category; ?show_all=1 lists everything.
     * ?sub_only=1 limits to rows that have a parent (sub-categories).
     */
    public function index()
    {
        $showAll = request()->boolean('show_all');

        $query = Category::with(['parent', 'children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');

        if (! $showAll) {
            $query->forBearingsCatalog();
        }

        if (request()->boolean('sub_only')) {
            $query->whereNotNull('parent_id');
        }

        $categories = $query->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'subOnly' => request()->boolean('sub_only'),
            'showAll' => $showAll,
            'bearingCatalogOnly' => ! $showAll && MainCategory::bearingsCatalogId() !== null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->forBearingsCatalog()
            ->orderBy('name')
            ->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($q) {
                    $q->whereNull('parent_id')->where('is_active', true);
                    $bid = MainCategory::bearingsCatalogId();
                    if ($bid) {
                        $q->where('main_category_id', $bid);
                    }
                }),
            ],
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $bearingsId = MainCategory::bearingsCatalogId();
        if ($bearingsId) {
            if (! empty($validated['parent_id'])) {
                $parent = Category::find($validated['parent_id']);
                $validated['main_category_id'] = $parent?->main_category_id ?? $bearingsId;
            } else {
                $validated['main_category_id'] = $bearingsId;
            }
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children']);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->where('id', '!=', $category->id)
            ->forBearingsCatalog()
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'nullable|boolean',
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($q) use ($category) {
                    $q->whereNull('parent_id')
                        ->where('is_active', true)
                        ->where('id', '!=', $category->id);
                    $bid = MainCategory::bearingsCatalogId();
                    if ($bid) {
                        $q->where('main_category_id', $bid);
                    }
                }),
            ],
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Prevent setting itself as parent
        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Category cannot be its own parent.'])->withInput();
        }

        // Prevent circular parent: chosen parent must not be a descendant of this category
        if ($validated['parent_id']) {
            $parent = Category::find($validated['parent_id']);
            if ($parent && $this->isDescendant($category, $parent)) {
                return back()->withErrors(['parent_id' => 'Cannot set a descendant as parent.'])->withInput();
            }
        }

        $bearingsId = MainCategory::bearingsCatalogId();
        if ($bearingsId) {
            if (! empty($validated['parent_id'])) {
                $p = Category::find($validated['parent_id']);
                $validated['main_category_id'] = $p?->main_category_id ?? $bearingsId;
            } else {
                $validated['main_category_id'] = $bearingsId;
            }
        }

        // Update slug if name changed
        if ($validated['name'] != $category->name) {
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug.'-'.$counter;
                $counter++;
            }
        }

        // Handle image upload / removal
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        } elseif ($request->filled('remove_image') && $request->remove_image == '1') {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        }

        unset($validated['remove_image']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with sub-categories. Please delete sub-categories first.');
        }

        // Delete image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Check if a category is a descendant of another
     */
    private function isDescendant($ancestor, $category)
    {
        if ($category->parent_id == $ancestor->id) {
            return true;
        }

        if ($category->parent) {
            return $this->isDescendant($ancestor, $category->parent);
        }

        return false;
    }
}
