<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Store a new review (logged-in users only).
     */
    public function store(Request $request, Product $product)
    {
        if (!$request->user()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in to leave a review.')
                ->with('url.intended', route('product.show', $product->slug) . '#form-review');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'rating' => (int) $validated['rating'],
            'comment' => $request->filled('comment') ? trim($request->comment) : null,
            'is_approved' => true,
        ]);

        return redirect()
            ->route('product.show', $product->slug)
            ->with('success', 'Thank you! Your review has been submitted.');
    }
}
