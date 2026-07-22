@extends('admin.layout')

@section('title', 'Payments History')
@section('page-title', 'Payments History')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Payment History</h4>
                <p class="text-muted mb-0">View all successful payments</p>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h5 class="text-success">Total Revenue</h5>
                <h3 class="mb-0">{{ currency($payments->sum('total_amount') ?? $payments->sum('total') ?? 0) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h5 class="text-info">Total Payments</h5>
                <h3 class="mb-0">{{ $payments->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h5 class="text-primary">This Month</h5>
                <h3 class="mb-0">{{ currency(\App\Models\Order::where('payment_status', 'paid')->whereMonth('created_at', now()->month)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(total_amount, total, 0)')) ?? 0) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h5 class="text-warning">Today</h5>
                <h3 class="mb-0">{{ currency(\App\Models\Order::where('payment_status', 'paid')->whereDate('created_at', today())->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(total_amount, total, 0)')) ?? 0) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Payment ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <a href="{{{ route('admin.orders.show', $payment) }}}">{{ $payment->order_number ?? 'N/A' }}</a>
                                        </td>
                                        <td>{{ $payment->customer_name ?? 'Guest' }}</td>
                                        <td>
                                            @if($payment->payment_method == 'razorpay')
                                                <span class="badge bg-primary">Razorpay</span>
                                            @elseif($payment->payment_method == 'cod')
                                                <span class="badge bg-warning">COD</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">{{ currency($payment->total_amount ?? $payment->total ?? 0) }}</td>
                                        <td>
                                            @if($payment->razorpay_payment_id)
                                                <code class="small">{{ substr($payment->razorpay_payment_id, 0, 20) }}...</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if($payment->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($payment->payment_status ?? 'Pending') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{{ route('admin.orders.show', $payment) }}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($payments->hasPages())
                        <div class="mt-4">
                            {{ $payments->links() }}
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No payment records found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

