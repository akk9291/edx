<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('priority')->orderBy('created_at', 'desc')->get();
        return view('admin.hero-banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.hero-banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'priority' => 'nullable|integer|min:0',
            'deeplink' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'banner_image' => 'required|image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['priority'] = (int) ($validated['priority'] ?? 0);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('hero-banners', 'public');
        }

        HeroBanner::create($validated);

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner created successfully.');
    }

    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero-banners.edit', compact('heroBanner'));
    }

    public function update(Request $request, HeroBanner $heroBanner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'priority' => 'nullable|integer|min:0',
            'deeplink' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'banner_image' => 'sometimes|nullable|image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['priority'] = (int) ($validated['priority'] ?? 0);

        if ($request->hasFile('banner_image')) {
            if ($heroBanner->banner_image) {
                Storage::disk('public')->delete($heroBanner->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('hero-banners', 'public');
        }

        $heroBanner->update($validated);

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner updated successfully.');
    }

    public function destroy(HeroBanner $heroBanner)
    {
        if ($heroBanner->banner_image) {
            Storage::disk('public')->delete($heroBanner->banner_image);
        }
        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner deleted successfully.');
    }
}
