<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('items')->orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.faqs.create-category');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        FaqCategory::create($validated);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ category created.');
    }

    public function editCategory(FaqCategory $faq)
    {
        return view('admin.faqs.edit-category', compact('faq'));
    }

    public function updateCategory(Request $request, FaqCategory $faq)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $faq->update($validated);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ category updated.');
    }

    public function destroyCategory(FaqCategory $faq)
    {
        $faq->items()->delete();
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ category deleted.');
    }

    public function items(FaqCategory $faq)
    {
        $items = $faq->items()->orderBy('sort_order')->get();
        return view('admin.faqs.items', compact('faq', 'items'));
    }

    public function createItem(FaqCategory $faq)
    {
        return view('admin.faqs.create-item', compact('faq'));
    }

    public function storeItem(Request $request, FaqCategory $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['faq_category_id'] = $faq->id;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        FaqItem::create($validated);
        return redirect()->route('admin.faqs.items', $faq)->with('success', 'FAQ item added.');
    }

    public function editItem(FaqCategory $faq, FaqItem $item)
    {
        if ($item->faq_category_id !== $faq->id) {
            abort(404);
        }
        return view('admin.faqs.edit-item', compact('faq', 'item'));
    }

    public function updateItem(Request $request, FaqCategory $faq, FaqItem $item)
    {
        if ($item->faq_category_id !== $faq->id) {
            abort(404);
        }
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $item->update($validated);
        return redirect()->route('admin.faqs.items', $faq)->with('success', 'FAQ item updated.');
    }

    public function destroyItem(FaqCategory $faq, FaqItem $item)
    {
        if ($item->faq_category_id !== $faq->id) {
            abort(404);
        }
        $item->delete();
        return redirect()->route('admin.faqs.items', $faq)->with('success', 'FAQ item deleted.');
    }
}
