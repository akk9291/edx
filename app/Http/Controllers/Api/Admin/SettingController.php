<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Get settings
     */
    public function index()
    {
        $settings = Setting::allAsArray();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => Setting::allAsArray(),
        ]);
    }

    /**
     * Update UI settings
     */
    public function updateUiSettings(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'nullable|string|in:light,dark',
            'currency' => 'nullable|string|size:3',
            'currency_symbol' => 'nullable|string|max:10',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'UI settings updated successfully',
            'data' => Setting::allAsArray(),
        ]);
    }
}




