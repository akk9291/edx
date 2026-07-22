<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Get settings (public)
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
     * Get UI settings (public)
     */
    public function uiSettings()
    {
        $uiSettings = [
            'theme' => Setting::get('theme', 'light'),
            'currency' => Setting::get('currency', 'INR'),
            'currency_symbol' => Setting::get('currency_symbol', '₹'),
            'free_shipping_threshold' => Setting::get('free_shipping_threshold', 500),
            'shipping_charge' => Setting::get('shipping_charge', 50),
            'min_order_amount' => Setting::get('min_order_amount', 0),
        ];

        return response()->json([
            'success' => true,
            'data' => $uiSettings,
        ]);
    }
}




