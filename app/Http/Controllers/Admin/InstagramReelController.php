<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramReel;
use Illuminate\Http\Request;

class InstagramReelController extends Controller
{
    public function index()
    {
        $reels = InstagramReel::ordered()->get();

        return view('admin.instagram-reels.index', compact('reels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:512'],
        ]);

        $url = trim($validated['url']);
        if (InstagramReel::urlToEmbedUrl($url) === null) {
            return redirect()->route('admin.instagram-reels.index')
                ->with('error', 'Invalid link. Use a full Instagram URL: instagram.com/reel/… , /reels/… , /p/… or /tv/…')
                ->withInput();
        }

        $max = (int) InstagramReel::max('sort_order');

        InstagramReel::create([
            'url' => $url,
            'sort_order' => $max + 1,
        ]);

        return redirect()->route('admin.instagram-reels.index')
            ->with('success', 'Reel link added.');
    }

    public function destroy(InstagramReel $instagram_reel)
    {
        $instagram_reel->delete();

        return redirect()->route('admin.instagram-reels.index')
            ->with('success', 'Removed.');
    }

    public function updateSort(Request $request)
    {
        $validated = $request->validate([
            'sort' => 'required|array',
            'sort.*' => 'integer|min:0|max:99999',
        ]);

        foreach ($validated['sort'] as $id => $sortOrder) {
            InstagramReel::whereKey((int) $id)->update(['sort_order' => (int) $sortOrder]);
        }

        return redirect()->route('admin.instagram-reels.index')
            ->with('success', 'Order saved.');
    }
}
