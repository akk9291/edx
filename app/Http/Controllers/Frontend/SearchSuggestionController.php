<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\PillowBlock;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchSuggestionController extends Controller
{
    /**
     * Return live search autocomplete suggestions for bearings and pillow blocks.
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));

        if (mb_strlen($query) < 1) {
            return response()->json([
                'query' => $query,
                'categories' => [],
                'products' => [],
                'total' => 0,
            ]);
        }

        $term = '%' . $query . '%';

        // 1. Matching Categories
        $bearingsMainId = MainCategory::bearingsCatalogId();
        $categories = Category::query()
            ->where('is_active', true)
            ->when($bearingsMainId, function ($q) use ($bearingsMainId) {
                $q->where('main_category_id', $bearingsMainId);
            })
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('slug', 'like', $term);
            })
            ->limit(3)
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'url' => route('frontend.range', ['category' => $cat->slug]),
                ];
            });

        // 2. Standard Bearings
        $products = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->where(function ($q) use ($term) {
                $q->where('sku', 'like', $term)
                    ->orWhere('name', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('specifications', 'like', $term)
                    ->orWhereHas('category', function ($cq) use ($term) {
                        $cq->where('name', 'like', $term);
                    });
            })
            ->with('category')
            ->orderByRaw("CASE 
                WHEN sku LIKE ? THEN 1 
                WHEN sku LIKE ? THEN 2 
                WHEN name LIKE ? THEN 3 
                ELSE 4 
            END", [$query . '%', $term, $term])
            ->limit(8)
            ->get();

        // 3. Pillow Blocks
        $pillowBlocks = PillowBlock::where('is_active', true)
            ->where(function ($q) use ($term) {
                $q->where('sku', 'like', $term)
                    ->orWhere('name', 'like', $term)
                    ->orWhere('bearing_number', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('specifications', 'like', $term)
                    ->orWhereHas('category', function ($cq) use ($term) {
                        $cq->where('name', 'like', $term);
                    });
            })
            ->with('category')
            ->orderByRaw("CASE 
                WHEN sku LIKE ? THEN 1 
                WHEN sku LIKE ? THEN 2 
                WHEN name LIKE ? THEN 3 
                ELSE 4 
            END", [$query . '%', $term, $term])
            ->limit(6)
            ->get();

        $items = collect();

        foreach ($products as $p) {
            $specs = $p->specifications;
            if (is_string($specs)) {
                $specs = json_decode($specs, true) ?: [];
            } elseif (! is_array($specs)) {
                $specs = [];
            }
            $dimensions = [];
            if (!empty($specs['bore_diameter'])) {
                $dimensions[] = 'd: ' . $specs['bore_diameter'];
            }
            if (!empty($specs['outside_diameter'])) {
                $dimensions[] = 'D: ' . $specs['outside_diameter'];
            }
            if (!empty($specs['width'])) {
                $dimensions[] = 'B: ' . $specs['width'];
            }

            $items->push([
                'id' => $p->id,
                'type' => 'product',
                'sku' => $p->sku,
                'name' => $p->name,
                'display_name' => $p->display_name,
                'slug' => $p->slug,
                'category' => $p->category->name ?? 'Ball Bearing',
                'image_url' => $p->image_url,
                'dimensions' => implode(' • ', $dimensions),
                'url' => route('frontend.product', $p->slug),
            ]);
        }

        foreach ($pillowBlocks as $pb) {
            $specs = $pb->specifications;
            if (is_string($specs)) {
                $specs = json_decode($specs, true) ?: [];
            } elseif (! is_array($specs)) {
                $specs = [];
            }
            $dimensions = [];
            if (!empty($specs['shaft_diameter'])) {
                $dimensions[] = 'Shaft: ' . $specs['shaft_diameter'];
            } elseif (!empty($pb->bearing_number)) {
                $dimensions[] = 'Bearing: ' . $pb->bearing_number;
            }

            $items->push([
                'id' => $pb->id,
                'type' => 'pillow_block',
                'sku' => $pb->sku,
                'name' => $pb->name,
                'display_name' => $pb->display_name,
                'slug' => $pb->slug,
                'category' => $pb->category->name ?? 'Pillow Block',
                'image_url' => $pb->image_url,
                'dimensions' => implode(' • ', $dimensions),
                'url' => route('frontend.product', $pb->slug),
            ]);
        }

        $limitedItems = $items->take(8)->values();

        return response()->json([
            'query' => $query,
            'categories' => $categories,
            'products' => $limitedItems,
            'total' => $limitedItems->count(),
        ]);
    }
}
