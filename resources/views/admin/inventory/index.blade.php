@extends('admin.layout')

@section('title', 'Inventory')
@section('page-title', 'Inventory Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Product Inventory</h4>
                <p class="text-muted mb-0">Manage stock levels for all products (latest first)</p>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <form action="{{ route('admin.inventory.index') }}" method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <div class="input-group" style="max-width: 320px;">
                <input type="text" name="q" class="form-control" placeholder="Search by product name or SKU..." value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            @if(request('q'))
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $placeholderImg = asset('assets/images/product/perch-bottal.webp');
                                    $getProductImageUrl = function($product) {
                                        if ($product->image) {
                                            $path = $product->image;
                                            if (str_starts_with($path, 'http') || str_starts_with($path, '//')) return $path;
                                            if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) return asset($path);
                                            return storage_asset($path);
                                        }
                                        if (is_array($product->images) && count($product->images) > 0) {
                                            $first = $product->images[0];
                                            if (is_string($first)) {
                                                if (str_starts_with($first, 'assets/') || str_starts_with($first, '/assets/')) return asset($first);
                                                return storage_asset($first);
                                            }
                                        }
                                        return null;
                                    };
                                @endphp
                                @foreach($products as $product)
                                    @php $imgUrl = $getProductImageUrl($product) ?? $placeholderImg; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $imgUrl }}" 
                                                     alt="{{ $product->name }}" 
                                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px; background: #f0f0f0;"
                                                     onerror="this.onerror=null; this.src='{{ $placeholderImg }}';">
                                                <div>
                                                    <a href="{{{ route('admin.products.show', $product) }}}" class="fw-semibold">{{ $product->name }}</a>
                                                    @if($product->sku)
                                                        <div class="text-muted small">{{ $product->sku }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $stock = $product->stock_quantity ?? 0;
                                            @endphp
                                            @if($stock <= 0)
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @elseif($stock < 10)
                                                <span class="badge bg-warning">{{ $stock }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $stock }}</span>
                                            @endif
                                        </td>
                                        <td>{{ currency($product->sale_price ?? $product->price ?? 0) }}</td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.inventory.product', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-box-seam"></i> Manage Inventory
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No products found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


