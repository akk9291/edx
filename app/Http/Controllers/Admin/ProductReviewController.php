<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * List all product reviews for admin.
     */
    public function index(Request $request)
    {
        $reviews = ProductReview::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Delete a product review (admin only).
     */
    public function destroy(Request $request, ProductReview $review)
    {
        $review->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        if (request()->has('from') && request('from') === 'admin') {
            return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
        }
        $product = $review->product;
        return redirect()
            ->route('product.show', $product->slug)
            ->with('success', 'Review deleted.');
    }
}
