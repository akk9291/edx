<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List products with pagination
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('category');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by main category (through category)
        if ($request->has('main_category_id')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('main_category_id', $request->main_category_id);
            });
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // Filter by new arrivals
        if ($request->has('new_arrival')) {
            $query->where('is_new_arrival', $request->boolean('new_arrival'));
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('sale_price')
                            ->where('price', '>=', $request->min_price);
                    });
            });
        }

        if ($request->has('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('sale_price')
                            ->where('price', '<=', $request->max_price);
                    });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Quick search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        if (empty($query)) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%'.$query.'%')
                    ->orWhere('description', 'LIKE', '%'.$query.'%')
                    ->orWhere('short_description', 'LIKE', '%'.$query.'%')
                    ->orWhere('sku', 'LIKE', '%'.$query.'%');
            })
            ->with('category')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get product by ID (for wishlist/add-to-wishlist)
     */
    public function showById(Request $request, $id)
    {
        $product = Product::where('id', (int) $id)
            ->where('is_active', true)
            ->with('category')
            ->first();

        if (! $product) {
            return response()->json(['success' => false, 'data' => null, 'message' => 'Product not found'], 404);
        }

        $toFullUrl = fn ($path) => Product::publicUrlForPath(is_string($path) ? $path : null);
        $primaryImage = $product->image ?? null;
        if (! $primaryImage && $product->images && is_array($product->images) && count($product->images) > 0) {
            $primaryImage = $product->images[0];
        }
        $images = $product->images && is_array($product->images) ? $product->images : [];
        $thumbImages = array_map($toFullUrl, array_merge([$primaryImage], array_filter($images, fn ($i) => $i !== $primaryImage)));

        return response()->json([
            'success' => true,
            'data' => [
                'id' => (string) $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format((float) $product->price, 2, '.', ''),
                'originPrice' => $product->sale_price ? number_format((float) $product->price, 2, '.', '') : null,
                'sale' => (bool) ($product->sale_price && $product->sale_price < $product->price),
                'new' => (bool) $product->is_new_arrival,
                'thumbImage' => $thumbImages,
                'sold' => 0,
                'quantity' => (int) ($product->stock_quantity ?? 100),
                'sizes' => $product->sizes && is_array($product->sizes) ? $product->sizes : [],
                'variation' => [],
                'action' => 'quick shop',
            ],
        ]);
    }

    /**
     * Get product by slug (used by Quick View and product page).
     * Returns full image URLs so live and local both show correct images.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'inventories'])
            ->firstOrFail();

        $data = $product->toArray();

        // Resolve image paths (public/assets/* vs storage/app/public/*)
        $data['image'] = Product::publicUrlForPath($data['image'] ?? null);
        if (! empty($data['images']) && is_array($data['images'])) {
            $data['images'] = array_values(array_map(
                fn ($p) => Product::publicUrlForPath(is_string($p) ? $p : null),
                $data['images']
            ));
        }
        if (! empty($data['color_images']) && is_array($data['color_images'])) {
            $resolved = [];
            foreach ($data['color_images'] as $key => $path) {
                $resolved[$key] = Product::publicUrlForPath(is_string($path) ? $path : null);
            }
            $data['color_images'] = $resolved;
        }
        if (! empty($data['inventories'])) {
            foreach ($data['inventories'] as $i => $inv) {
                if (! empty($inv['image'])) {
                    $data['inventories'][$i]['image'] = Product::publicUrlForPath($inv['image']);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
