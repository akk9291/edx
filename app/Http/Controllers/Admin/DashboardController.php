<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Reports hub – all report downloads in one place.
     */
    public function reportsIndex()
    {
        return view('admin.reports.index');
    }

    /**
     * Get chart data for a specific date range
     */
    public function getChartData(Request $request)
    {
        $request->validate([
            'days' => 'nullable|integer|min:1|max:365',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = null;
        $endDate = now()->endOfDay();

        if ($request->has('start_date') && $request->has('end_date')) {
            // Custom date range
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $days = $startDate->diffInDays($endDate) + 1;
        } elseif ($request->has('days')) {
            // Fixed days (7, 15, 30)
            $days = (int) $request->days;
            $startDate = now()->subDays($days - 1)->startOfDay();
        } else {
            // Default to 7 days
            $days = 7;
            $startDate = now()->subDays($days - 1)->startOfDay();
        }

        // Generate date range
        $chartData = collect();
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $chartData->push([
                'date' => $currentDate->format('M d'),
                'date_full' => $currentDate->format('Y-m-d'),
                'revenue' => Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $currentDate)
                    ->sum(DB::raw('COALESCE(total_amount, total, 0)')) ?? 0,
                'orders' => Order::whereDate('created_at', $currentDate)->count(),
            ]);
            $currentDate->addDay();
        }

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'range' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'days' => $days,
            ],
        ]);
    }

    /**
     * Download Inventory Report (CSV)
     */
    public function downloadInventoryReport(Request $request)
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        $filename = 'inventory_report_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Product ID',
                'Product Name',
                'SKU',
                'Category',
                'Price',
                'Sale Price',
                'Stock Quantity',
                'Low Stock Alert',
                'Status',
                'Created At',
            ]);

            // Data rows
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku ?? 'N/A',
                    $product->category->name ?? 'N/A',
                    $product->price ?? 0,
                    $product->sale_price ?? $product->price ?? 0,
                    $product->stock_quantity ?? 0,
                    ($product->stock_quantity ?? 0) < 10 ? 'Yes' : 'No',
                    $product->is_active ? 'Active' : 'Inactive',
                    $product->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Orders Report (CSV)
     */
    public function downloadOrdersReport(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->get('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $orders = Order::with('user')
            ->when($startDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'orders_report_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Order ID',
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Total Amount',
                'Subtotal',
                'Tax',
                'Shipping',
                'Status',
                'Payment Status',
                'Payment Method',
                'Created At',
            ]);

            // Data rows
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->order_number ?? 'N/A',
                    $order->customer_name ?? ($order->user->name ?? 'Guest'),
                    $order->customer_email ?? ($order->user->email ?? 'N/A'),
                    $order->total_amount ?? $order->total ?? 0,
                    $order->subtotal ?? 0,
                    $order->tax ?? 0,
                    $order->shipping ?? 0,
                    ucfirst($order->status ?? 'Pending'),
                    ucfirst($order->payment_status ?? 'Pending'),
                    $order->payment_method ?? 'N/A',
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Revenue Report (CSV)
     */
    public function downloadRevenueReport(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->get('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        // Daily revenue breakdown
        $dailyRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(COALESCE(total_amount, total, 0)) as revenue'),
                DB::raw('SUM(COALESCE(subtotal, 0)) as subtotal'),
                DB::raw('SUM(COALESCE(tax, 0)) as tax'),
                DB::raw('SUM(COALESCE(shipping, 0)) as shipping')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $filename = 'revenue_report_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($dailyRevenue, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Summary header
            fputcsv($file, ['Revenue Report']);
            fputcsv($file, ['Period: '.$startDate->format('Y-m-d').' to '.$endDate->format('Y-m-d')]);
            fputcsv($file, ['Generated: '.now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []); // Empty row

            // Headers
            fputcsv($file, [
                'Date',
                'Order Count',
                'Revenue',
                'Subtotal',
                'Tax',
                'Shipping',
            ]);

            // Data rows
            foreach ($dailyRevenue as $day) {
                fputcsv($file, [
                    $day->date,
                    $day->order_count,
                    number_format($day->revenue ?? 0, 2),
                    number_format($day->subtotal ?? 0, 2),
                    number_format($day->tax ?? 0, 2),
                    number_format($day->shipping ?? 0, 2),
                ]);
            }

            // Summary row
            fputcsv($file, []); // Empty row
            fputcsv($file, [
                'TOTAL',
                $dailyRevenue->sum('order_count'),
                number_format($dailyRevenue->sum('revenue'), 2),
                number_format($dailyRevenue->sum('subtotal'), 2),
                number_format($dailyRevenue->sum('tax'), 2),
                number_format($dailyRevenue->sum('shipping'), 2),
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Customers Report (CSV)
     */
    public function downloadCustomersReport(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->get('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $customers = User::where(function ($query) {
            $query->where('is_admin', false)->orWhereNull('is_admin');
        })
            ->when($startDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withCount(['orders' => function ($query) {
                $query->where('payment_status', 'paid');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate total spent for each customer
        foreach ($customers as $customer) {
            $customer->total_spent = Order::where('user_id', $customer->id)
                ->where('payment_status', 'paid')
                ->sum(DB::raw('COALESCE(total_amount, total, 0)')) ?? 0;
        }

        $filename = 'customers_report_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Customer ID',
                'Name',
                'Email',
                'Phone',
                'Total Orders',
                'Total Spent',
                'Average Order Value',
                'Registered At',
                'Last Order Date',
            ]);

            // Data rows
            foreach ($customers as $customer) {
                $lastOrder = Order::where('user_id', $customer->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $totalSpent = $customer->total_spent ?? 0;
                $orderCount = $customer->orders_count ?? 0;
                $avgOrderValue = $orderCount > 0 ? ($totalSpent / $orderCount) : 0;

                fputcsv($file, [
                    $customer->id,
                    $customer->name ?? 'N/A',
                    $customer->email ?? 'N/A',
                    $customer->phone ?? 'N/A',
                    $orderCount,
                    number_format($totalSpent, 2),
                    number_format($avgOrderValue, 2),
                    $customer->created_at->format('Y-m-d H:i:s'),
                    $lastOrder ? $lastOrder->created_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download SKUs Report (CSV) – all products with SKU, stock, etc.
     */
    public function downloadSkusReport(Request $request)
    {
        $products = Product::with('category')
            ->orderBy('sku')
            ->get();

        $filename = 'skus_report_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, [
                'SKU',
                'Product ID',
                'Product Name',
                'Category',
                'Price',
                'Sale Price',
                'Stock',
                'Low Stock',
                'Status',
                'Created At',
            ]);
            foreach ($products as $p) {
                fputcsv($file, [
                    $p->sku ?? 'N/A',
                    $p->id,
                    $p->name ?? 'N/A',
                    $p->category->name ?? 'N/A',
                    $p->price ?? 0,
                    $p->sale_price ?? $p->price ?? 0,
                    $p->stock_quantity ?? 0,
                    ($p->stock_quantity ?? 0) < 10 ? 'Yes' : 'No',
                    $p->is_active ? 'Active' : 'Inactive',
                    $p->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
