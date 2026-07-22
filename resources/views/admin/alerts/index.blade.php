@extends('admin.layout')

@section('title', 'Alerts')
@section('page-title', 'Alerts & Notifications')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">System Alerts</h4>
            <p class="text-muted mb-0">Monitor important alerts and notifications</p>
        </div>
    </div>
</div>

<!-- Low Stock Alerts -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Low Stock Products ({{ $lowStockCount }})
                </h5>
            </div>
            <div class="card-body">
                @php
                    $lowStockProducts = \App\Models\Product::where('stock_quantity', '<', 10)
                        ->where('is_active', true)
                        ->orderBy('stock_quantity', 'asc')
                        ->get();
                @endphp
                
                @if($lowStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td>
                                            <a href="{{{ route('admin.products.show', $product) }}}">{{ $product->name }}</a>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $product->stock_quantity ?? 0 }}</span>
                                        </td>
                                        <td>{{ currency($product->sale_price ?? $product->price ?? 0) }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{{ route('admin.products.edit', $product) }}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>All products have sufficient stock!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Pending Orders Alerts -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Pending Orders ({{ $pendingOrdersCount }})
                </h5>
            </div>
            <div class="card-body">
                @php
                    $pendingOrders = \App\Models\Order::where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp
                
                @if($pendingOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{{ route('admin.orders.show', $order) }}}">{{ $order->order_number ?? 'N/A' }}</a>
                                        </td>
                                        <td>{{ $order->customer_name ?? 'Guest' }}</td>
                                        <td>{{ currency($order->total_amount ?? $order->total ?? 0) }}</td>
                                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{{ route('admin.orders.show', $order) }}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>No pending orders!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Out of Stock Products -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>
                    Out of Stock Products
                </h5>
            </div>
            <div class="card-body">
                @php
                    $outOfStockProducts = \App\Models\Product::where('stock_quantity', '<=', 0)
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                @endphp
                
                @if($outOfStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outOfStockProducts as $product)
                                    <tr>
                                        <td>
                                            <a href="{{{ route('admin.products.show', $product) }}}">{{ $product->name }}</a>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        </td>
                                        <td>{{ currency($product->sale_price ?? $product->price ?? 0) }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{{ route('admin.products.edit', $product) }}}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>No out of stock products!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


