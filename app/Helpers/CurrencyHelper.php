<?php

if (!function_exists('currency')) {
    /**
     * Format amount with currency symbol
     */
    function currency($amount, $decimals = 2)
    {
        $symbol = \App\Models\Setting::get('currency_symbol', '₹');
        return $symbol . number_format($amount, $decimals);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     */
    function currency_symbol()
    {
        return \App\Models\Setting::get('currency_symbol', '₹');
    }
}
