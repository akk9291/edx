@extends('admin.layout')

@section('title', 'Reports')
@section('page-title', 'Reports & Downloads')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Download Reports</h4>
        <p class="text-muted mb-0">Export orders, customers, revenue, and SKUs as CSV.</p>
    </div>
</div>

<div class="row g-4">
    {{-- SKUs --}}
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="bi bi-upc-scan text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">SKUs</h5>
                        <small class="text-muted">Product SKU list</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-3">All product SKUs with name, category, price, and stock.</p>
                <a href="{{ route('admin.dashboard.reports.skus') }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-download me-1"></i> Download CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="bi bi-bag-check text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Orders</h5>
                        <small class="text-muted">Optional date range</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-3">Order list with customer, total, status, and payment.</p>
                <form method="GET" action="{{ route('admin.dashboard.reports.orders') }}" class="report-form">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="date" name="start_date" class="form-control form-control-sm" placeholder="Start">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" class="form-control form-control-sm" placeholder="End">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Revenue --}}
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-currency-dollar text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Revenue</h5>
                        <small class="text-muted">Optional date range</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-3">Daily revenue breakdown (orders, subtotal, tax, shipping).</p>
                <form method="GET" action="{{ route('admin.dashboard.reports.revenue') }}" class="report-form">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="date" name="start_date" class="form-control form-control-sm" placeholder="Start">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" class="form-control form-control-sm" placeholder="End">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Customers --}}
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="bi bi-people text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Customers</h5>
                        <small class="text-muted">Optional date range</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-3">Customers with order count, total spent, and last order.</p>
                <form method="GET" action="{{ route('admin.dashboard.reports.customers') }}" class="report-form">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="date" name="start_date" class="form-control form-control-sm" placeholder="Start">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" class="form-control form-control-sm" placeholder="End">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Reports are generated as CSV. Use Excel or Google Sheets to open. Date range is optional for Orders, Revenue, and Customers; leave blank for all time (Revenue defaults to current month).
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
