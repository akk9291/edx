<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Get reports
     */
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->toDateString());

        // Sales report
        $salesReport = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Product sales report
        $productSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit(20)
            ->get();

        // Customer report
        $customerReport = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_amount) as total_spent')
            )
            ->where('orders.payment_status', 'paid')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        // Summary
        $totalOrders = Order::whereBetween('created_at', [$fromDate, $toDate])->count();
        $totalRevenue = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        $totalCustomers = User::where('is_admin', false)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'from' => $fromDate,
                    'to' => $toDate,
                ],
                'summary' => [
                    'total_orders' => $totalOrders,
                    'total_revenue' => $totalRevenue,
                    'total_customers' => $totalCustomers,
                ],
                'sales_report' => $salesReport,
                'product_sales' => $productSales,
                'customer_report' => $customerReport,
            ],
        ]);
    }

    /**
     * Download reports
     */
    public function download(Request $request)
    {
        // TODO: Implement CSV/Excel export
        return response()->json([
            'success' => true,
            'message' => 'Report download functionality will be implemented',
        ]);
    }
}




