<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List categories
     */
    public function index(Request $request)
    {
        $query = Category::where('is_active', true);

        // Filter by main category
        if ($request->has('main_category_id')) {
            $query->where('main_category_id', $request->main_category_id);
        }

        // Filter by parent category
        if ($request->has('parent_id')) {
            if ($request->parent_id === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        $categories = $query->with(['mainCategory', 'parent', 'children'])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}




