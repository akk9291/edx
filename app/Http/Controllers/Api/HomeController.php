<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Get home page data
     */
    public function index()
    {
        $categories = MainCategory::with(['activeCategories' => function($query) {
            $query->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $newArrivals = Product::where('is_active', true)
            ->where('is_new_arrival', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'featured_products' => $featuredProducts,
                'new_arrivals' => $newArrivals,
            ],
        ]);
    }

    /**
     * Get active hero banners
     */
    public function heroBanners()
    {
        $banners = HeroBanner::active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banners,
        ]);
    }
}




