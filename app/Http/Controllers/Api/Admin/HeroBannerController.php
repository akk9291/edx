<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    /**
     * List hero banners
     */
    public function index()
    {
        $banners = HeroBanner::orderBy('priority')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $banners,
        ]);
    }

    /**
     * Create hero banner
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'priority' => 'nullable|integer|min:0',
            'deeplink' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'banner_image' => 'required|image|max:5120', // 5MB max
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('hero-banners', 'public');
        }

        $banner = HeroBanner::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero banner created successfully',
            'data' => $banner,
        ], 201);
    }

    /**
     * Get hero banner
     */
    public function show($id)
    {
        $banner = HeroBanner::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $banner,
        ]);
    }

    /**
     * Update hero banner
     */
    public function update(Request $request, $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'priority' => 'nullable|integer|min:0',
            'deeplink' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'banner_image' => 'sometimes|required|image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($banner->banner_image) {
                Storage::disk('public')->delete($banner->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('hero-banners', 'public');
        }

        $banner->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero banner updated successfully',
            'data' => $banner->fresh(),
        ]);
    }

    /**
     * Delete hero banner
     */
    public function destroy($id)
    {
        $banner = HeroBanner::findOrFail($id);

        // Delete image
        if ($banner->banner_image) {
            Storage::disk('public')->delete($banner->banner_image);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero banner deleted successfully',
        ]);
    }
}




