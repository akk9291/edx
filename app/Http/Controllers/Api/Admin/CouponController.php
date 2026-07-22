<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * List coupons
     */
    public function index(Request $request)
    {
        $query = Coupon::withCount('usages');

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('code', 'LIKE', '%' . $search . '%');
            });
        }

        $coupons = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $coupons,
        ]);
    }

    /**
     * Create coupon
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:coupons,code',
            'description' => 'nullable|string',
            'main_category_ids' => 'nullable|array',
            'main_category_ids.*' => 'exists:main_categories,id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'nullable|boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'minimum_order_amount' => 'nullable|numeric|min:0',
        ]);

        $coupon = Coupon::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully',
            'data' => $coupon,
        ], 201);
    }

    /**
     * Get coupon
     */
    public function show($id)
    {
        $coupon = Coupon::with('usages')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $coupon,
        ]);
    }

    /**
     * Update coupon
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => ['sometimes', 'required', 'string', \Illuminate\Validation\Rule::unique('coupons', 'code')->ignore($id)],
            'description' => 'nullable|string',
            'main_category_ids' => 'nullable|array',
            'main_category_ids.*' => 'exists:main_categories,id',
            'discount_type' => 'sometimes|required|in:percentage,fixed',
            'discount_value' => 'sometimes|required|numeric|min:0',
            'valid_from' => 'sometimes|required|date',
            'valid_until' => 'sometimes|required|date|after:valid_from',
            'is_active' => 'nullable|boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'minimum_order_amount' => 'nullable|numeric|min:0',
        ]);

        $coupon->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Coupon updated successfully',
            'data' => $coupon->fresh(),
        ]);
    }

    /**
     * Delete coupon
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        // Check if coupon has usages
        if ($coupon->usages()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete coupon with usage history',
            ], 400);
        }

        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully',
        ]);
    }
}




