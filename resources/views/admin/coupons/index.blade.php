@extends('admin.layout')

@section('title', 'Coupons')
@section('page-title', 'Coupon Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Coupons</h4>
                <p class="text-muted mb-0">Manage discount coupons and promotional codes</p>
            </div>
            <a href="{{{ route('admin.coupons.create') }}}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create New Coupon
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($coupons->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Discount</th>
                                    <th>Min Order</th>
                                    <th>Usage Limit</th>
                                    <th>Used</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td>
                                            <code class="fw-bold">{{ $coupon->code }}</code>
                                        </td>
                                        <td>
                                            @if($coupon->discount_type == 'percentage')
                                                <span class="badge bg-info">Percentage</span>
                                            @else
                                                <span class="badge bg-primary">Fixed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->discount_type == 'percentage')
                                                {{ $coupon->discount_value }}%
                                            @else
                                                {{ currency($coupon->discount_value) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->minimum_order_amount)
                                                {{ currency($coupon->minimum_order_amount) }}
                                            @else
                                                <span class="text-muted">No minimum</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->usage_limit)
                                                {{ $coupon->usage_limit }}
                                            @else
                                                <span class="text-muted">Unlimited</span>
                                            @endif
                                        </td>
                                        <td>{{ $coupon->usages->count() ?? $coupon->used_count ?? 0 }}</td>
                                        <td>{{ $coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from)->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('M d, Y') : 'N/A' }}</td>
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
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{{ route('admin.coupons.show', $coupon) }}}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{{ route('admin.coupons.edit', $coupon) }}}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{{ route('admin.coupons.destroy', $coupon) }}}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No coupons found. 
                        <a href="{{{ route('admin.coupons.create') }}}">Create your first coupon</a>.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

