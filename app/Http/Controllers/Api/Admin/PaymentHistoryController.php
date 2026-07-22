<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentHistoryController extends Controller
{
    /**
     * List payment history
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])
            ->whereNotNull('payment_status')
            ->whereIn('payment_status', ['paid', 'failed']);

        // Filters
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', '%' . $search . '%')
                  ->orWhere('razorpay_payment_id', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', '%' . $search . '%')
                               ->orWhere('email', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    /**
     * Get payment details
     */
    public function show($id)
    {
        $payment = Order::with(['user', 'items.product', 'coupon'])
            ->where('id', $id)
            ->whereNotNull('payment_status')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * Get payment statistics
     */
    public function statistics(Request $request)
    {
        $query = Order::whereNotNull('payment_status');

        // Date range filter
        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $totalPaid = (clone $query)->where('payment_status', 'paid')->sum('total_amount');
        $totalFailed = (clone $query)->where('payment_status', 'failed')->sum('total_amount');
        $totalPending = Order::where('payment_status', 'pending')
            ->when($request->has('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->sum('total_amount');

        $paidCount = (clone $query)->where('payment_status', 'paid')->count();
        $failedCount = (clone $query)->where('payment_status', 'failed')->count();
        $pendingCount = Order::where('payment_status', 'pending')
            ->when($request->has('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->count();

        // Payment method breakdown
        $byMethod = (clone $query)
            ->select('payment_method', DB::raw('SUM(total_amount) as amount'), DB::raw('COUNT(*) as count'))
            ->where('payment_status', 'paid')
            ->groupBy('payment_method')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_paid' => $totalPaid,
                'total_failed' => $totalFailed,
                'total_pending' => $totalPending,
                'paid_count' => $paidCount,
                'failed_count' => $failedCount,
                'pending_count' => $pendingCount,
                'by_method' => $byMethod,
            ],
        ]);
    }

    /**
     * Get payment analytics
     */
    public function analytics(Request $request)
    {
        $days = $request->get('days', 30);
        $fromDate = now()->subDays($days);

        // Daily payment analytics
        $dailyPayments = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $fromDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as amount'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment status breakdown
        $statusBreakdown = Order::where('created_at', '>=', $fromDate)
            ->select(
                'payment_status',
                DB::raw('SUM(total_amount) as amount'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'daily_payments' => $dailyPayments,
                'status_breakdown' => $statusBreakdown,
                'period' => [
                    'from' => $fromDate->toDateString(),
                    'to' => now()->toDateString(),
                    'days' => $days,
                ],
            ],
        ]);
    }

    /**
     * Export payment history
     */
    public function export(Request $request)
    {
        // TODO: Implement CSV/Excel export
        return response()->json([
            'success' => true,
            'message' => 'Export functionality will be implemented',
        ]);
    }
}




