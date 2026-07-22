@extends('admin.layout')

@section('title', 'View Coupon')
@section('page-title', 'Coupon Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">{{ $coupon->name }}</h4>
                <p class="text-muted mb-0">Coupon details and usage statistics</p>
            </div>
            <div>
                <a href="{{{ route('admin.coupons.edit', $coupon) }}}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
                <a href="{{{ route('admin.coupons.index') }}}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Coupon Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Name:</th>
                        <td>{{ $coupon->name }}</td>
                    </tr>
                    <tr>
                        <th>Code:</th>
                        <td><code class="fw-bold">{{ $coupon->code }}</code></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $coupon->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Discount Type:</th>
                        <td>
                            @if($coupon->discount_type == 'percentage')
                                <span class="badge bg-info">Percentage</span>
                            @else
                                <span class="badge bg-primary">Fixed</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Discount Value:</th>
                        <td>
                            @if($coupon->discount_type == 'percentage')
                                {{ $coupon->discount_value }}%
                            @else
                                {{ currency($coupon->discount_value) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Minimum Order:</th>
                        <td>
                            @if($coupon->minimum_order_amount)
                                {{ currency($coupon->minimum_order_amount) }}
                            @else
                                <span class="text-muted">No minimum</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Usage Limit:</th>
                        <td>
                            @if($coupon->usage_limit)
                                {{ $coupon->usage_limit }}
                            @else
                                <span class="text-muted">Unlimited</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Valid From:</th>
                        <td>{{ $coupon->valid_from ? $coupon->valid_from->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Valid Until:</th>
                        <td>{{ $coupon->valid_until ? $coupon->valid_until->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @php
                                $now = now();
                                $validFrom = $coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from) : null;
                                $validTo = $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until) : null;
                                
                                $isActive = $coupon->is_active ?? true;
                                if ($validFrom && $now->lt($validFrom)) {
                                    $isActive = false;
                                }
                                if ($validTo && $now->gt($validTo)) {
                                    $isActive = false;
                                }
                                $usedCount = $coupon->usages->count() ?? $coupon->used_count ?? 0;
                                if ($coupon->usage_limit && $usedCount >= $coupon->usage_limit) {
                                    $isActive = false;
                                }
                            @endphp
                            
                            @if($isActive)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Usage Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Total Usage</h6>
                    <h3 class="text-primary">{{ $coupon->usages->count() ?? $coupon->used_count ?? 0 }}</h3>
                    @if($coupon->usage_limit)
                        <p class="text-muted small">of {{ $coupon->usage_limit }} limit</p>
                    @endif
                </div>

                @if($coupon->usages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>User</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coupon->usages->take(10) as $usage)
                                    <tr>
                                        <td>
                                            @if($usage->order)
                                                <a href="{{{ route('admin.orders.show', $usage->order) }}}">{{ $usage->order->order_number ?? 'N/A' }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $usage->user->name ?? 'Guest' }}</td>
                                        <td>{{ $usage->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No usage recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


