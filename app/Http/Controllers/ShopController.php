<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterColor;
use App\Models\MasterSize;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Show shop page with category filter, search, and filters
     */
    public function index(Request $request)
    {
        $categorySlug = $request->get('category');
        $search = $request->get('search');
        $sort = $request->get('sort', 'default');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $filterSize = $request->get('size');
        $filterColor = $request->get('color');
        $category = null;
        $products = Product::where('is_active', true)->with('category');

        // Category filter
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)
                ->with(['children.children', 'parent'])
                ->where('is_active', true)
                ->first();
                
            if ($category) {
                $categoryIds = $this->getCategoryIds($category);
                $products = $products->whereIn('category_id', $categoryIds);
            }
        }

        // Search filter
        if ($search) {
            $products = $products->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filter
        $minPriceVal = $minPrice !== null && $minPrice !== '' ? (float) $minPrice : null;
        $maxPriceVal = $maxPrice !== null && $maxPrice !== '' ? (float) $maxPrice : null;
        if ($minPriceVal !== null) {
            $products = $products->whereRaw('COALESCE(sale_price, price) >= ?', [$minPriceVal]);
        }
        if ($maxPriceVal !== null) {
            $products = $products->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPriceVal]);
        }

        // Size filter (products that have inventory with this size)
        if ($filterSize) {
            $products = $products->whereHas('inventories', function ($q) use ($filterSize) {
                $q->where('size', $filterSize);
            });
        }

        // Color filter (products that have inventory with this color)
        if ($filterColor) {
            $products = $products->whereHas('inventories', function ($q) use ($filterColor) {
                $q->whereRaw('LOWER(TRIM(color)) = ?', [strtolower(trim($filterColor))]);
            });
        }

        // Sort
        switch ($sort) {
            case 'price_low':
                $products = $products->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $products = $products->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products = $products->orderBy('name', 'desc');
                break;
            case 'newest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            default:
                $products = $products->orderBy('sort_order')->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(16)->withQueryString();

        $categories = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categoryProductCounts = [];
        foreach ($categories as $c) {
            $ids = $this->getCategoryIds($c);
            $categoryProductCounts[$c->id] = Product::whereIn('category_id', $ids)->where('is_active', true)->count();
        }

        $filterSizes = MasterSize::orderBy('sort_order')->orderBy('name')->get();
        $filterColors = MasterColor::orderBy('sort_order')->orderBy('name')->get();

        $priceRange = Product::where('is_active', true)
            ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price, MAX(COALESCE(sale_price, price)) as max_price')
            ->first();
        $priceMin = $priceRange && $priceRange->min_price !== null ? (float) $priceRange->min_price : 0;
        $priceMax = $priceRange && $priceRange->max_price !== null ? (float) $priceRange->max_price : 300;

        if ($request->ajax() || $request->wantsJson()) {
            return view('shop-products-partial', compact('products'));
        }

        return view('shop', compact('categories', 'category', 'products', 'categoryProductCounts', 'filterSizes', 'filterColors', 'priceMin', 'priceMax', 'filterSize', 'filterColor'));
    }

    /**
     * Show category page
     */
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['children.children', 'parent', 'mainCategory'])
            ->where('is_active', true)
            ->firstOrFail();

        // Get MainCategory for fallback content
        $mainCategory = $category->mainCategory;

        $categories = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get all products in this category and its subcategories
        $categoryIds = $this->getCategoryIds($category);
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with('category');

        // Search filter
        $search = $request->get('search');
        if ($search) {
            $products = $products->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filter
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        if ($minPrice) {
            $products = $products->where(function($query) use ($minPrice) {
                $query->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
            });
        }
        if ($maxPrice) {
            $products = $products->where(function($query) use ($maxPrice) {
                $query->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPrice]);
            });
        }

        // Sort
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_low':
                $products = $products->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $products = $products->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products = $products->orderBy('name', 'desc');
                break;
            case 'newest':
                $products = $products->orderBy('created_at', 'desc');
                break;
            default:
                $products = $products->orderBy('sort_order')->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(16)->withQueryString();

        // Get subcategories for category page
        $subCategories = $category->children()->where('is_active', true)->get();
        
        // Get featured products for "What's new" section (with main category for tabs)
        $featuredProducts = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with('category.mainCategory')
            ->limit(12)
            ->get();

        $mainCategories = \App\Models\MainCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('shop.category', compact('categories', 'category', 'mainCategory', 'products', 'subCategories', 'featuredProducts', 'mainCategories'));
    }

    /**
     * Show product detail page
     */
    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with(['category', 'category.parent', 'inventories'])
                ->first();
            
            if (!$product) {
                abort(404, 'Product not found');
            }
            
            // Check if product is active (optional - you might want to show inactive products to admins)
            // if (!$product->is_active) {
            //     abort(404, 'Product not available');
            // }

            // Get related products from the same category
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with('category')
                ->limit(4)
                ->get();

            // If no related products, get from featured products
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = Product::where('is_active', true)
                    ->where('is_featured', true)
                    ->where('id', '!=', $product->id)
                    ->with('category')
                    ->limit(4)
                    ->get();
            }

            // Get active coupons for discount codes
            $coupons = \App\Models\Coupon::where('is_active', true)
                ->where('valid_from', '<=', now())
                ->where('valid_until', '>=', now())
                ->limit(3)
                ->get();

            // Reviews: only approved, top-level (no replies in main list)
            $reviews = $product->reviews()->with('user')->get();
            $allApproved = $product->allApprovedReviews()->get();
            $reviewCount = $allApproved->count();
            $reviewStats = [
                'avg' => $reviewCount > 0 ? round($allApproved->avg('rating'), 1) : 0,
                'count' => $reviewCount,
                'distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            ];
            foreach ($allApproved as $r) {
                if (isset($reviewStats['distribution'][$r->rating])) {
                    $reviewStats['distribution'][$r->rating]++;
                }
            }

            // Get previous and next products
            $prevProduct = Product::where('id', '<', $product->id)
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->first();
            
            $nextProduct = Product::where('id', '>', $product->id)
                ->where('is_active', true)
                ->orderBy('id', 'asc')
                ->first();

            return view('product.show', compact('product', 'relatedProducts', 'coupons', 'prevProduct', 'nextProduct', 'reviews', 'reviewStats'));
        } catch (\Exception $e) {
            \Log::error('Product show error: ' . $e->getMessage());
            abort(404, 'Product not found');
        }
    }

    /**
     * Get all category IDs including children
     */
    private function getCategoryIds($category)
    {
        $ids = [$category->id];
        
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            foreach ($child->children as $grandchild) {
                $ids[] = $grandchild->id;
            }
        }
        
        return $ids;
    }
}
