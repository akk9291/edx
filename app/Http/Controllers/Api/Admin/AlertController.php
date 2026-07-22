<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Get alerts
     */
    public function index()
    {
        $alerts = [];

        // Low stock alerts
        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('is_active', true)
            ->count();
        
        if ($lowStockProducts > 0) {
            $alerts[] = [
                'type' => 'low_stock',
                'severity' => 'warning',
                'message' => "{$lowStockProducts} products have low stock",
                'count' => $lowStockProducts,
            ];
        }

        // Out of stock alerts
        $outOfStockProducts = Product::where('stock', '<=', 0)
            ->where('is_active', true)
            ->count();
        
        if ($outOfStockProducts > 0) {
            $alerts[] = [
                'type' => 'out_of_stock',
                'severity' => 'danger',
                'message' => "{$outOfStockProducts} products are out of stock",
                'count' => $outOfStockProducts,
            ];
        }

        // Pending orders
        $pendingOrders = Order::where('status', 'pending')->count();
        
        if ($pendingOrders > 0) {
            $alerts[] = [
                'type' => 'pending_orders',
                'severity' => 'info',
                'message' => "{$pendingOrders} orders are pending",
                'count' => $pendingOrders,
            ];
        }

        // Failed payments
        $failedPayments = Order::where('payment_status', 'failed')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        if ($failedPayments > 0) {
            $alerts[] = [
                'type' => 'failed_payments',
                'severity' => 'warning',
                'message' => "{$failedPayments} payments failed in last 7 days",
                'count' => $failedPayments,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $alerts,
        ]);
    }
}




