@extends('admin.layout')

@section('title', 'Inventory: ' . $product->name)
@section('page-title', 'Inventory: ' . $product->name)

@section('content')
<style>
    /* Theme match: purple (sidebar & stock cards) */
    .inventory-add-card .card-header .nav-pills .nav-link { background: rgba(255,255,255,0.25); color: #fff; }
    .inventory-add-card .card-header .nav-pills .nav-link:hover { background: rgba(255,255,255,0.35); color: #fff; }
    .inventory-add-card .card-header .nav-pills .nav-link.active { background: #7c3aed; color: #fff; border: none; }
    .inventory-submit-btn { background: #7c3aed !important; border-color: #7c3aed !important; }
    .inventory-submit-btn:hover { background: #6d28d9 !important; border-color: #6d28d9 !important; }
</style>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Inventory
        </a>
    </div>
</div>

{{-- Product Details Card --}}
@php
    $productImage = $product->image
        ? (str_starts_with($product->image, 'assets/') || str_starts_with($product->image, '/assets/') ? asset($product->image) : storage_asset($product->image))
        : asset('assets/images/product/perch-bottal.webp');
@endphp
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header py-2 px-3" style="background: #f8fafc; color: #2d3748;">
                <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Product Details</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <div class="col">
                        <h6 class="fw-bold mb-1" style="color: #2d3748;">{{ $product->name }}</h6>
                        <div class="small text-muted mb-1">SKU: <span class="text-dark">{{ $product->sku ?? '—' }}</span></div>
                        @if($product->category)
                            <div class="small mb-1"><span class="badge bg-light text-dark">{{ $product->category->name }}</span></div>
                        @endif
                        @if($product->short_description || $product->description)
                            <p class="small text-muted mb-0 mb-md-0" style="max-width: 500px;">{{ Str::limit(strip_tags($product->short_description ?: $product->description), 120) }}</p>
                        @endif
                    </div>
                    <div class="col-md-auto mt-3 mt-md-0 text-md-end">
                        <div class="small mb-1">
                            @if($product->sale_price && (float)$product->sale_price > 0)
                                <span class="text-decoration-line-through text-muted">₹{{ number_format($product->price ?? 0, 2) }}</span>
                                <span class="text-danger fw-semibold ms-1">₹{{ number_format($product->sale_price, 2) }}</span>
                            @else
                                <span class="fw-semibold">₹{{ number_format($product->price ?? 0, 2) }}</span>
                            @endif
                        </div>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark">Featured</span>
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $totalStock = $product->inventories->sum('quantity');
    $inventories = $product->inventories()->orderBy('color')->orderBy('size')->get();
@endphp

{{-- Total Stock --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
            <div class="card-body text-white py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-90">Total Stock</div>
                        <h3 class="mb-0 fw-bold">{{ $totalStock }} <span class="fw-normal small">items in stock</span></h3>
                    </div>
                    <div style="font-size: 2.5rem; opacity: 0.3;"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stock by Color & Size (cards) --}}
@if($inventories->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <h5 class="fw-bold mb-3" style="color: #2d3748;">Stock by Color & Size</h5>
        <div class="row g-3">
            @foreach($inventories as $inv)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);">
                    <div class="card-body text-white py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-light text-dark me-1">{{ $inv->color ?: '—' }}</span>
                                <span class="badge bg-light text-dark">{{ $inv->size ?: '—' }}</span>
                                <div class="mt-2 small opacity-90">{{ $inv->quantity }} entry · Current available stock</div>
                            </div>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@php
    $inventoryColors = $inventories->pluck('color')->filter()->map(fn($c) => trim($c))->unique()->values()->toArray();
    $inventorySizes = $inventories->pluck('size')->filter()->map(fn($s) => trim($s))->unique()->values()->toArray();
    $colorOptions = array_values(array_unique(array_merge($inventoryColors, $masterColors ?? [])));
    $sizeOptions = array_values(array_unique(array_merge($inventorySizes, $masterSizes ?? [])));
    sort($colorOptions);
    sort($sizeOptions);
@endphp

{{-- Add Inventory --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm inventory-add-card">
            <div class="card-header py-3 text-white border-0 d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                <div>
                    <h5 class="mb-0 fw-bold">Add Inventory</h5>
                    <small class="opacity-90">Select color, size, and enter the initial stock quantity. Upload image for this color (optional).</small>
                </div>
                <ul class="nav nav-pills nav-fill gap-1 mb-0" id="addInventoryTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active inventory-tab-btn" id="single-tab" data-bs-toggle="tab" data-bs-target="#single-pane" type="button" role="tab">Single</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link inventory-tab-btn" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk-pane" type="button" role="tab">Bulk</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="addInventoryTabContent">
                    <div class="tab-pane fade show active" id="single-pane" role="tabpanel">
                        <form action="{{ route('admin.inventory.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Color (Optional)</label>
                                    <input type="text" name="color" class="form-control" list="colorOptions" placeholder="e.g., Red, Blue, Black, etc." value="{{ old('color') }}">
                                    <datalist id="colorOptions">
                                        @foreach($colorOptions as $c)
                                            <option value="{{ $c }}"></option>
                                        @endforeach
                                    </datalist>
                                    <small class="text-muted">Type color name or choose from list.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Size / Variant (Optional)</label>
                                    <input type="text" name="size" class="form-control" list="sizeOptions" placeholder="e.g., 64GB, 128GB, L, XL, etc." value="{{ old('size') }}">
                                    <datalist id="sizeOptions">
                                        @foreach($sizeOptions as $s)
                                            <option value="{{ $s }}"></option>
                                        @endforeach
                                    </datalist>
                                    <small class="text-muted">Type size/variant or choose from list.</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Initial Stock <span class="text-danger">*</span></label>
                                    <input type="number" name="initial_quantity" class="form-control" min="0" value="{{ old('initial_quantity') }}" placeholder="Enter quantity" required>
                                    <small class="text-muted">Total stock to add (reduces as orders come in).</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Price (₹) (Optional)</label>
                                    <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" placeholder="₹">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Sale Price (₹) (Optional)</label>
                                    <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="{{ old('sale_price') }}" placeholder="₹">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Images for this variant (Optional)</label>
                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                    <small class="text-muted">You can select multiple images. All will be saved for this color/size.</small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary inventory-submit-btn">
                                        <i class="bi bi-plus-lg me-1"></i>Add Inventory
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="bulk-pane" role="tabpanel">
                        <form action="{{ route('admin.inventory.bulk.store', $product->id) }}" method="POST" id="bulk-inventory-form" enctype="multipart/form-data">
                            @csrf
                            <p class="text-muted small mb-3">Add multiple inventory entries at once. Same color+size will add to existing stock. Use "Add row" to add more; optional image per row.</p>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-sm" id="bulk-inventory-table">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Size / Variant</th>
                                            <th>Quantity *</th>
                                            <th>Price (₹)</th>
                                            <th>Sale Price (₹)</th>
                                            <th>Images (Optional)</th>
                                            <th style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bulk-row">
                                            <td><input type="text" name="items[0][color]" class="form-control form-control-sm" list="colorOptionsBulk" placeholder="Red, Blue..."></td>
                                            <td><input type="text" name="items[0][size]" class="form-control form-control-sm" list="sizeOptionsBulk" placeholder="L, XL, 64GB..."></td>
                                            <td><input type="number" name="items[0][quantity]" class="form-control form-control-sm" min="0" placeholder="0"></td>
                                            <td><input type="number" name="items[0][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>
                                            <td><input type="number" name="items[0][sale_price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>
                                            <td><input type="file" name="items[0][images][]" class="form-control form-control-sm" accept="image/*" multiple title="Optional images for this variant"></td>
                                            <td><button type="button" class="btn btn-sm btn-outline-danger bulk-row-delete" title="Remove row"><i class="bi bi-trash"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <datalist id="colorOptionsBulk">
                                @foreach($colorOptions as $c)
                                    <option value="{{ $c }}"></option>
                                @endforeach
                            </datalist>
                            <datalist id="sizeOptionsBulk">
                                @foreach($sizeOptions as $s)
                                    <option value="{{ $s }}"></option>
                                @endforeach
                            </datalist>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="add-bulk-row"><i class="bi bi-plus me-1"></i>Add row</button>
                            <button type="submit" class="btn btn-primary inventory-submit-btn">
                                <i class="bi bi-plus-lg me-1"></i>Bulk Add Inventory
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Inventory Details --}}
<div class="row">
    <div class="col-12">
        <h5 class="fw-bold mb-3" style="color: #2d3748;">Inventory Details</h5>
        @if($inventories->count() > 0)
            <div class="row g-3">
                @foreach($inventories as $inv)
                <div class="col-md-6 col-lg-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary">{{ $inv->color ?: '—' }}</span>
                                <span class="badge bg-secondary">{{ $inv->size ?: '—' }}</span>
                            </div>
                            @php
                                $invImages = !empty($inv->images) ? $inv->images : ($inv->image ? [$inv->image] : []);
                            @endphp
                            @if(count($invImages) > 0)
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @foreach($invImages as $imgPath)
                                        <img src="{{ storage_asset($imgPath) }}" alt="" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @endif
                            <div class="small mb-1"><strong>Initial Stock:</strong> {{ $inv->initial_quantity }}</div>
                            <div class="small mb-1 text-danger"><strong>Sold:</strong> {{ $inv->sold_quantity }}</div>
                            <div class="small mb-2"><span class="badge bg-success">Current: {{ $inv->quantity }}</span> <span class="text-muted">(Initial − Sold)</span></div>
                            @if($inv->price !== null || $inv->sale_price !== null)
                                <div class="small mb-1"><strong>Price:</strong> ₹{{ number_format($inv->price ?? 0, 2) }}</div>
                                @if($inv->sale_price !== null)
                                    <div class="small text-danger mb-2"><strong>Sale Price:</strong> ₹{{ number_format($inv->sale_price, 2) }}</div>
                                @endif
                            @endif
                            <div class="small text-muted mb-2">Available stock for {{ $inv->color ?: 'N/A' }} - {{ $inv->size ?: 'N/A' }}</div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $inv->id }}"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.inventory.destroy', $inv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this inventory entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $inv->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.inventory.update', $inv->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Color</label>
                                        <input type="text" name="color" class="form-control" value="{{ old('color', $inv->color) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Size</label>
                                        <input type="text" name="size" class="form-control" value="{{ old('size', $inv->size) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Current Quantity *</label>
                                        <input type="number" name="quantity" class="form-control" min="0" value="{{ old('quantity', $inv->quantity) }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Price (₹)</label>
                                        <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $inv->price) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Sale Price (₹)</label>
                                        <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="{{ old('sale_price', $inv->sale_price) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Images (color/variant)</label>
                                        @php
                                            $editImages = !empty($inv->images) ? $inv->images : ($inv->image ? [$inv->image] : []);
                                        @endphp
                                        @if(count($editImages) > 0)
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                @foreach($editImages as $imgPath)
                                                    <img src="{{ storage_asset($imgPath) }}" alt="" style="max-height: 60px; width: auto;" class="rounded border">
                                                @endforeach
                                            </div>
                                            <label class="small d-block mb-1"><input type="checkbox" name="remove_image" value="1"> Remove all images</label>
                                        @endif
                                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                        <small class="text-muted">Select multiple to add more images.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="text-muted small mt-2">Showing 1 to {{ $inventories->count() }} of {{ $inventories->count() }} entries.</p>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No inventory entries yet. Use the form above to add stock by color/size.
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    var table = document.getElementById('bulk-inventory-table');
    var tbody = table && table.querySelector('tbody');
    var addBtn = document.getElementById('add-bulk-row');
    var colorList = 'colorOptionsBulk';
    var sizeList = 'sizeOptionsBulk';
    if (!tbody || !addBtn) return;

    function reindexRows() {
        var rows = tbody.querySelectorAll('tr.bulk-row');
        rows.forEach(function(tr, idx) {
            var inputs = tr.querySelectorAll('input');
            inputs.forEach(function(inp) {
                var n = inp.getAttribute('name');
                if (n && n.indexOf('items[') === 0) {
                    inp.setAttribute('name', n.replace(/items\[\d+\]/, 'items[' + idx + ']'));
                }
            });
        });
    }

    tbody.addEventListener('click', function(e) {
        var btn = e.target.closest('button.bulk-row-delete');
        if (!btn) return;
        var tr = btn.closest('tr');
        if (tr && tr.classList.contains('bulk-row')) {
            var rows = tbody.querySelectorAll('tr.bulk-row');
            if (rows.length <= 1) return;
            tr.remove();
            reindexRows();
        }
    });

    addBtn.addEventListener('click', function() {
        var rows = tbody.querySelectorAll('tr.bulk-row');
        var idx = rows.length;
        var tr = document.createElement('tr');
        tr.className = 'bulk-row';
        tr.innerHTML =
            '<td><input type="text" name="items[' + idx + '][color]" class="form-control form-control-sm" list="' + colorList + '" placeholder="Red, Blue..."></td>' +
            '<td><input type="text" name="items[' + idx + '][size]" class="form-control form-control-sm" list="' + sizeList + '" placeholder="L, XL, 64GB..."></td>' +
            '<td><input type="number" name="items[' + idx + '][quantity]" class="form-control form-control-sm" min="0" placeholder="0"></td>' +
            '<td><input type="number" name="items[' + idx + '][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>' +
            '<td><input type="number" name="items[' + idx + '][sale_price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="₹"></td>' +
            '<td><input type="file" name="items[' + idx + '][images][]" class="form-control form-control-sm" accept="image/*" multiple title="Optional images for this variant"></td>' +
            '<td><button type="button" class="btn btn-sm btn-outline-danger bulk-row-delete" title="Remove row"><i class="bi bi-trash"></i></button></td>';
        tbody.appendChild(tr);
    });
})();
</script>
@endpush
@endsection
