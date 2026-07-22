<?php

namespace App\Support;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class CatalogFilterOptions
{
    /**
     * Bearing catalog categories that appear in the storefront sidebar, with product counts.
     * When $request is passed, counts reflect search / bore / rows filters (not category).
     */
    public static function categories(?Request $request = null): Collection
    {
        $bearingsMainId = MainCategory::bearingsCatalogId();

        $catalogCategoryIds = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id');

        $pillowCategoryIds = \App\Models\PillowBlock::where('is_active', true)
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id');

        $catalogCategoryIds = $catalogCategoryIds->merge($pillowCategoryIds)->unique();

        $hasListingFilters = $request !== null && (
            $request->filled('search')
            || $request->filled('bore')
            || $request->filled('rows')
        );

        $categories = Category::query()
            ->where('is_active', true)
            ->whereIn('id', $catalogCategoryIds)
            ->when($bearingsMainId, function ($q) use ($bearingsMainId) {
                $q->where('main_category_id', $bearingsMainId);
            })
            ->withCount([
                'products as catalog_product_count' => function ($q) use ($request, $hasListingFilters) {
                    $q->edxBearingsCatalog()->where('is_active', true);
                    if ($hasListingFilters) {
                        self::applyListingFilters($q, $request, ['category']);
                    }
                },
            ])
            ->orderBy('name')
            ->get();

        foreach ($categories as $cat) {
            if ($cat->slug === 'pillow-block') {
                $pbQuery = \App\Models\PillowBlock::where('is_active', true);
                if ($request && $request->filled('search')) {
                    $search = trim((string) $request->search);
                    $pbQuery->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%')
                            ->orWhere('sku', 'like', '%'.$search.'%');
                    });
                }
                $cat->catalog_product_count = $pbQuery->count();
            }
        }

        return $categories;
    }

    /**
     * Distinct overview-style spec values for sidebar chips (labels are HTML-stripped).
     *
     * @return array{rows: list<string>}
     */
    public static function facets(): array
    {
        $rows = [];

        foreach (Product::edxBearingsCatalog()->where('is_active', true)->pluck('specifications') as $raw) {
            $s = is_array($raw) ? $raw : (json_decode((string) $raw, true) ?: []);
            if (! is_array($s)) {
                continue;
            }
            $row = isset($s['number_of_rows']) ? trim(strip_tags((string) $s['number_of_rows'])) : '';
            if ($row !== '') {
                $rows[$row] = true;
            }
        }

        $rowKeys = array_keys($rows);
        natcasesort($rowKeys);

        return [
            'rows' => array_slice(array_values($rowKeys), 0, 12),
        ];
    }

    public static function parseSpecNumeric(mixed $specifications, string $key): ?float
    {
        if (is_string($specifications)) {
            $specifications = json_decode($specifications, true);
        }
        if (! is_array($specifications) || ! array_key_exists($key, $specifications)) {
            return null;
        }
        $raw = $specifications[$key];
        if ($raw === null || $raw === '') {
            return null;
        }
        $s = strtolower(trim(strip_tags((string) $raw)));
        if (preg_match('/-?\d+(?:[.,]\d+)?/', $s, $m)) {
            return (float) str_replace(',', '.', $m[0]);
        }

        return null;
    }

    /**
     * Narrow a bearings-catalog product query using sidebar / URL filters.
     *
     * @param  list<string>  $except  Query keys to skip (e.g. category when counting per-category).
     */
    public static function applyListingFilters(Builder $query, Request $request, array $except = []): void
    {
        if (! in_array('category', $except, true) && $request->filled('category')) {
            $bearingsMainId = MainCategory::bearingsCatalogId();
            $categoryQuery = Category::query()
                ->where('slug', $request->category)
                ->where('is_active', true);
            if ($bearingsMainId !== null) {
                $categoryQuery->where('main_category_id', $bearingsMainId);
            }
            $category = $categoryQuery->first();
            if ($category) {
                $query->where('category_id', $category->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if (! in_array('search', $except, true) && $request->filled('search')) {
            $search = trim((string) $request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search, $request, $except) {
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                    // Only match category names when not already filtered to one category.
                    if (! in_array('category', $except, true) && ! $request->filled('category')) {
                        $q->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%'.$search.'%');
                        });
                    }
                });
            }
        }

        if (! in_array('bore', $except, true) && $request->filled('bore')) {
            $bounds = match ($request->get('bore')) {
                '0-20' => [0.0, 20.0],
                '20-50' => [20.0, 50.0],
                '50-100' => [50.0, 100.0],
                '100+' => [100.0, null],
                default => null,
            };
            if ($bounds !== null) {
                [$min, $max] = $bounds;
                $ids = Product::edxBearingsCatalog()
                    ->where('is_active', true)
                    ->pluck('specifications', 'id')
                    ->filter(function ($specs, $id) use ($min, $max) {
                        $n = self::parseSpecNumeric($specs, 'bore_diameter');
                        if ($n === null) {
                            return false;
                        }
                        if ($max === null) {
                            return $n >= $min;
                        }

                        return $n >= $min && $n < $max;
                    })
                    ->keys()
                    ->values()
                    ->all();
                if ($ids === []) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereIn('id', $ids);
                }
            }
        }

        if (! in_array('rows', $except, true) && $request->filled('rows')) {
            $want = trim(strip_tags((string) $request->get('rows')));
            if ($want !== '') {
                $ids = Product::edxBearingsCatalog()
                    ->where('is_active', true)
                    ->pluck('specifications', 'id')
                    ->filter(function ($specs) use ($want) {
                        if (is_string($specs)) {
                            $specs = json_decode($specs, true);
                        }
                        if (! is_array($specs)) {
                            return false;
                        }
                        $r = isset($specs['number_of_rows']) ? trim(strip_tags((string) $specs['number_of_rows'])) : '';

                        return $r !== '' && strcasecmp($r, $want) === 0;
                    })
                    ->keys()
                    ->values()
                    ->all();
                if ($ids === []) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereIn('id', $ids);
                }
            }
        }
    }
}
