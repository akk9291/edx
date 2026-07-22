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
            'hero_image' => 'nullable|image|max:5120',
            'hero_text' => 'nullable|string|max:255',
            'hero_button_text' => 'nullable|string|max:100',
            'banner_images' => 'nullable|array|max:3',
            'banner_images.*' => 'nullable|image|max:2048',
            'banner_texts' => 'nullable|array|max:3',
            'banner_texts.*' => 'nullable|string|max:255',
            'bottom_banner_image' => 'nullable|image|max:5120',
            'bottom_banner_text' => 'nullable|string|max:255',
            'testimonial_text' => 'nullable|string|max:1000',
            'additional_banner_image' => 'nullable|image|max:5120',
            'additional_banner_text' => 'nullable|string|max:255',
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

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('categories/hero', 'public');
        }

        // Handle banner images
        $bannerImagePaths = [];
        if ($request->hasFile('banner_images')) {
            foreach ($request->file('banner_images') as $file) {
                if ($file) {
                    $bannerImagePaths[] = $file->store('categories/banners', 'public');
                }
            }
        }
        if (! empty($bannerImagePaths)) {
            $validated['banner_images'] = $bannerImagePaths;
        }

        // Handle banner texts
        if ($request->has('banner_texts')) {
            $validated['banner_texts'] = array_values(array_filter($request->input('banner_texts', [])));
        }

        // Handle bottom banner image
        if ($request->hasFile('bottom_banner_image')) {
            $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('categories/bottom-banner', 'public');
        }

        // Handle additional banner image
        if ($request->hasFile('additional_banner_image')) {
            $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('categories/additional-banner', 'public');
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
            'hero_image' => 'nullable|image|max:5120',
            'remove_hero_image' => 'nullable|boolean',
            'hero_text' => 'nullable|string|max:255',
            'hero_button_text' => 'nullable|string|max:100',
            'banner_images' => 'nullable|array|max:3',
            'banner_images.*' => 'nullable|image|max:2048',
            'remove_banner_image' => 'nullable|array',
            'banner_texts' => 'nullable|array|max:3',
            'banner_texts.*' => 'nullable|string|max:255',
            'bottom_banner_image' => 'nullable|image|max:5120',
            'remove_bottom_banner_image' => 'nullable|boolean',
            'bottom_banner_text' => 'nullable|string|max:255',
            'testimonial_text' => 'nullable|string|max:1000',
            'additional_banner_image' => 'nullable|image|max:5120',
            'remove_additional_banner_image' => 'nullable|boolean',
            'additional_banner_text' => 'nullable|string|max:255',
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

        // Handle image removal
        if ($request->filled('remove_image') && $request->remove_image == '1') {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        // Handle hero image
        if ($request->filled('remove_hero_image') && $request->remove_hero_image == '1') {
            if ($category->hero_image) {
                Storage::disk('public')->delete($category->hero_image);
            }
            $validated['hero_image'] = null;
        } elseif ($request->hasFile('hero_image')) {
            if ($category->hero_image) {
                Storage::disk('public')->delete($category->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('categories/hero', 'public');
        }

        // Handle banner images
        $existingBannerImages = is_array($category->banner_images) ? $category->banner_images : [];
        $removeBannerImages = $request->input('remove_banner_image', []);

        if ($request->hasFile('banner_images')) {
            $newBannerPaths = [];
            foreach ($request->file('banner_images') as $index => $file) {
                if ($file) {
                    // Delete old image if exists at this index
                    if (isset($existingBannerImages[$index])) {
                        Storage::disk('public')->delete($existingBannerImages[$index]);
                    }
                    $newBannerPaths[$index] = $file->store('categories/banners', 'public');
                } elseif (isset($existingBannerImages[$index]) && ! isset($removeBannerImages[$index])) {
                    // Keep existing image if not removed
                    $newBannerPaths[$index] = $existingBannerImages[$index];
                }
            }
            // Remove images marked for deletion
            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && isset($existingBannerImages[$index])) {
                    Storage::disk('public')->delete($existingBannerImages[$index]);
                    unset($newBannerPaths[$index]);
                }
            }
            $validated['banner_images'] = ! empty($newBannerPaths) ? array_values($newBannerPaths) : null;
        } else {
            // Handle removal only
            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && isset($existingBannerImages[$index])) {
                    Storage::disk('public')->delete($existingBannerImages[$index]);
                    unset($existingBannerImages[$index]);
                }
            }
            $validated['banner_images'] = ! empty($existingBannerImages) ? array_values($existingBannerImages) : null;
        }

        // Handle banner texts
        if ($request->has('banner_texts')) {
            $validated['banner_texts'] = array_values(array_filter($request->input('banner_texts', [])));
        }

        // Handle bottom banner image
        if ($request->filled('remove_bottom_banner_image') && $request->remove_bottom_banner_image == '1') {
            if ($category->bottom_banner_image) {
                Storage::disk('public')->delete($category->bottom_banner_image);
            }
            $validated['bottom_banner_image'] = null;
        } elseif ($request->hasFile('bottom_banner_image')) {
            if ($category->bottom_banner_image) {
                Storage::disk('public')->delete($category->bottom_banner_image);
            }
            $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('categories/bottom-banner', 'public');
        }

        // Handle additional banner image
        if ($request->filled('remove_additional_banner_image') && $request->remove_additional_banner_image == '1') {
            if ($category->additional_banner_image) {
                Storage::disk('public')->delete($category->additional_banner_image);
            }
            $validated['additional_banner_image'] = null;
        } elseif ($request->hasFile('additional_banner_image')) {
            if ($category->additional_banner_image) {
                Storage::disk('public')->delete($category->additional_banner_image);
            }
            $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('categories/additional-banner', 'public');
        }

        // Remove remove flags from validated
        unset($validated['remove_image'], $validated['remove_hero_image'], $validated['remove_bottom_banner_image'], $validated['remove_additional_banner_image'], $validated['remove_banner_image']);

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
