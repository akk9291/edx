<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Validate coupon code
     */
    public function validate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_amount' => 'nullable|numeric|min:0',
            'main_category_ids' => 'nullable|array',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code',
            ], 400);
        }

        $orderAmount = $request->order_amount ?? 0;
        $mainCategoryIds = $request->main_category_ids ?? [];

        $isValid = $coupon->isValid($orderAmount, $mainCategoryIds, $request->user()?->id);

        if (!$isValid) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not valid for this order',
            ], 400);
        }

        $discountAmount = $coupon->calculateDiscount($orderAmount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon is valid',
            'data' => [
                'coupon' => $coupon,
                'discount_amount' => $discountAmount,
                'final_amount' => $orderAmount - $discountAmount,
            ],
        ]);
    }
}




