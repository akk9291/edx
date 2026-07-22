<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function index()
    {
        // Total orders
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'delivered')->count();

        // Revenue statistics
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');
        $monthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Product statistics
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        // User statistics
        $totalCustomers = User::where('is_admin', false)->count();
        $totalAdmins = User::where('is_admin', true)->count();

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Category statistics
        $totalCategories = Category::count();

        return response()->json([
            'success' => true,
            'data' => [
                'orders' => [
                    'total' => $totalOrders,
                    'pending' => $pendingOrders,
                    'processing' => $processingOrders,
                    'completed' => $completedOrders,
                ],
                'revenue' => [
                    'total' => $totalRevenue,
                    'today' => $todayRevenue,
                    'month' => $monthRevenue,
                ],
                'products' => [
                    'total' => $totalProducts,
                    'active' => $activeProducts,
                    'low_stock' => $lowStockProducts,
                ],
                'users' => [
                    'total_customers' => $totalCustomers,
                    'total_admins' => $totalAdmins,
                ],
                'categories' => [
                    'total' => $totalCategories,
                ],
                'recent_orders' => $recentOrders,
            ],
        ]);
    }
}




