@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Product Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Products</h4>
                <p class="text-muted mb-0">Manage your bearing catalog products</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @php
                    $exportQuery = request()->only(['search', 'status']);
                @endphp
                <button type="button" class="btn btn-outline-dark" id="toggleDatabaseMode">
                    <i class="bi bi-database me-2"></i>Database Mode
                </button>
                <div class="btn-group">
                    <a href="{{ route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'csv'])) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-download me-2"></i>Export CSV
                    </a>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Export format</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'csv'])) }}">CSV (.csv)</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'xlsx'])) }}">Excel (.xlsx)</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bearingImportModal">
                    <i class="bi bi-upload me-2"></i>Import bearings (CSV / Excel)
                </button>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
            </div>
        </div>

        @if(session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Import notes</strong>
                <ul class="mb-0 small">
                    @foreach(session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Search and Filter Form -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Search by name, SKU, or category..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(request()->hasAny(['search', 'status']))
    <div class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i>
        Found <strong>{{ $products->total() }}</strong> product(s) matching your search criteria.
        @if(request('search'))
            <br><small>Searching for: "<strong>{{ request('search') }}</strong>"</small>
        @endif
    </div>
@endif

<div class="row">
    <div class="col-12">
        <!-- Normal View -->
        <div class="card" id="normalView">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $productPlaceholder = asset('assets/images/product/perch-bottal.webp'); @endphp
                            @forelse($products as $product)
                                @php $imageUrl = $product->image_url; @endphp
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; background: #f0f0f0;"
                                             onerror="this.onerror=null; this.src='{{ $productPlaceholder }}';">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $product->name }}</div>
                                        @if($product->sku)
                                            <small class="text-muted">SKU: {{ $product->sku }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted mb-0">No products found.</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary mt-2">
                                            Create First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($products->hasPages())
                <div class="card-footer-pagination">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Database Mode View -->
        <div class="card d-none" id="databaseModeView">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Database Mode - All Fields</h5>
                    <button type="button" class="btn btn-success" id="saveDatabaseChanges">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-striped table-sm" id="databaseTable">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Sale Price</th>
                                <th>Stock Qty</th>
                                <th>In Stock</th>
                                <th>Active</th>
                                <th>Featured</th>
                                <th>New Arrival</th>
                                <th>Category ID</th>
                                <th>Sort Order</th>
                                <th>Description</th>
                                <th>Short Desc</th>
                                <th>Meta Title</th>
                                <th>Meta Desc</th>
                                <th>Meta Keywords</th>
                                <th>Product Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr data-product-id="{{ $product->id }}">
                                    <td>{{ $product->id }}</td>
                                    <td contenteditable="true" class="editable" data-field="name">{{ $product->name }}</td>
                                    <td contenteditable="true" class="editable" data-field="slug">{{ $product->slug }}</td>
                                    <td contenteditable="true" class="editable" data-field="sku">{{ $product->sku }}</td>
                                    <td contenteditable="true" class="editable" data-field="price">{{ $product->price }}</td>
                                    <td contenteditable="true" class="editable" data-field="sale_price">{{ $product->sale_price }}</td>
                                    <td contenteditable="true" class="editable" data-field="stock_quantity">{{ $product->stock_quantity }}</td>
                                    <td contenteditable="true" class="editable" data-field="in_stock">{{ $product->in_stock ? '1' : '0' }}</td>
                                    <td contenteditable="true" class="editable" data-field="is_active">{{ $product->is_active ? '1' : '0' }}</td>
                                    <td contenteditable="true" class="editable" data-field="is_featured">{{ $product->is_featured ? '1' : '0' }}</td>
                                    <td contenteditable="true" class="editable" data-field="is_new_arrival">{{ $product->is_new_arrival ? '1' : '0' }}</td>
                                    <td contenteditable="true" class="editable" data-field="category_id">{{ $product->category_id }}</td>
                                    <td contenteditable="true" class="editable" data-field="sort_order">{{ $product->sort_order }}</td>
                                    <td contenteditable="true" class="editable" data-field="description">{{ Str::limit($product->description ?? '', 100) }}</td>
                                    <td contenteditable="true" class="editable" data-field="short_description">{{ Str::limit($product->short_description ?? '', 50) }}</td>
                                    <td contenteditable="true" class="editable" data-field="meta_title">{{ $product->meta_title }}</td>
                                    <td contenteditable="true" class="editable" data-field="meta_description">{{ Str::limit($product->meta_description ?? '', 50) }}</td>
                                    <td contenteditable="true" class="editable" data-field="meta_keywords">{{ $product->meta_keywords }}</td>
                                    <td contenteditable="true" class="editable" data-field="product_type">{{ $product->product_type }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="19" class="text-center py-4">
                                        <p class="text-muted mb-0">No products found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($products->hasPages())
                <div class="card-footer-pagination">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="bearingImportModal" tabindex="-1" aria-labelledby="bearingImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bearingImportModalLabel">Import bearing catalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.products.bearing-import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Upload exports in the same shape as WordPress <strong>DGBB</strong>, <strong>SRB</strong>, or <strong>CRB</strong> files
                        (pipe-separated <code>Image URL</code>s, <code>bearing_no</code> as SKU, <code>Bearing Category</code> / <code>bearing_category</code> must match a seeded bearing category).
                        You may append <strong>SEO &amp; pricing</strong> columns: <code>meta_title</code>, <code>meta_description</code>, <code>meta_keywords</code>, <code>mrp</code> (list price), <code>sale_price</code> — see sample CSV header.
                    </p>
                    <div class="mb-3">
                        <label for="import_file" class="form-label">File (.csv, .txt, .xlsx, .xls — max 20&nbsp;MB)</label>
                        <input type="file" class="form-control" name="import_file" id="import_file" accept=".csv,.txt,.xlsx,.xls" required>
                    </div>
                    <p class="mb-2">
                        <a href="{{ route('admin.products.bearing-import.sample') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Download sample CSV (DGBB-style)
                        </a>
                        <span class="text-muted small ms-2">Includes header + 2 example rows (meta, MRP, sale price).</span>
                    </p>
                    <details class="small text-muted mt-3">
                        <summary class="fw-semibold text-secondary mb-2">Expected columns (reference)</summary>
                        <p class="mb-2"><strong>DGBB / SRB-style</strong> (first row headers): <code>ID</code>, <code>Title</code>, <code>Post Type</code>, <code>Image URL</code> (optional, multiple URLs with <code>|</code>), <code>Bearing Category</code>, <code>bearing_no</code>, <code>bore_diameter</code>, <code>outside_diameter</code>, <code>width</code>, <code>basic_dynamic_load_rating</code>, <code>basic_static_load_rating</code>, <code>limiting_speed_grease</code>, <code>limiting_speed_oil</code>, <code>number_of_rows</code>, <code>radial_internal_clearance</code>, <code>tolerance_class_for_dimensions</code>, <code>cage</code>, <code>bore_type</code>, equivalents <code>skf</code>, <code>fag</code>, <code>ntn</code>, <code>timken</code>, suffix fields, <code>bearing_category</code>, and optionally <code>bearing_description</code>, <code>product_net_weight</code>. <strong>Optional (SEO &amp; pricing):</strong> <code>meta_title</code>, <code>meta_description</code>, <code>meta_keywords</code>, <code>mrp</code> (stored as product MRP / list price; aliases <code>MRP</code>, <code>regular_price</code>), <code>sale_price</code> (aliases <code>Sale Price</code>). Leave cells empty to keep existing values on re-import.</p>
                        <p class="mb-0"><strong>CRB-style</strong>: same bearing columns; uses a single <code>limiting_speed</code> column (mapped to both grease and oil in specs). Category from <code>bearing_category</code> / title context.</p>
                    </details>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i>Run import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleDatabaseMode');
    const normalView = document.getElementById('normalView');
    const databaseModeView = document.getElementById('databaseModeView');
    const saveButton = document.getElementById('saveDatabaseChanges');
    let isDatabaseMode = false;

    // Toggle between normal and database mode
    toggleButton.addEventListener('click', function() {
        isDatabaseMode = !isDatabaseMode;
        
        if (isDatabaseMode) {
            normalView.classList.add('d-none');
            databaseModeView.classList.remove('d-none');
            toggleButton.innerHTML = '<i class="bi bi-table me-2"></i>Normal View';
            toggleButton.classList.remove('btn-outline-dark');
            toggleButton.classList.add('btn-dark');
        } else {
            normalView.classList.remove('d-none');
            databaseModeView.classList.add('d-none');
            toggleButton.innerHTML = '<i class="bi bi-database me-2"></i>Database Mode';
            toggleButton.classList.remove('btn-dark');
            toggleButton.classList.add('btn-outline-dark');
        }
    });

    // Save database changes
    saveButton.addEventListener('click', function() {
        const updates = [];
        const rows = document.querySelectorAll('#databaseTable tbody tr[data-product-id]');
        
        rows.forEach(row => {
            const productId = row.getAttribute('data-product-id');
            const editableCells = row.querySelectorAll('.editable');
            const productData = { id: productId };
            
            editableCells.forEach(cell => {
                const field = cell.getAttribute('data-field');
                let value = cell.textContent.trim();
                
                // Convert boolean fields
                if (['in_stock', 'is_active', 'is_featured', 'is_new_arrival'].includes(field)) {
                    value = value === '1' || value === 'true' || value.toLowerCase() === 'yes';
                }
                
                // Convert numeric fields
                if (['price', 'sale_price', 'stock_quantity', 'category_id', 'sort_order'].includes(field)) {
                    value = value === '' ? null : parseFloat(value);
                }
                
                productData[field] = value;
            });
            
            updates.push(productData);
        });

        // Send updates to server
        if (updates.length > 0) {
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="bi bi-spinner me-2"></i>Saving...';
            
            // Get CSRF token from meta tag or hidden input
            const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
            const csrfInput = document.querySelector('input[name="_token"]');
            const csrfToken = csrfMetaTag ? csrfMetaTag.getAttribute('content') : (csrfInput ? csrfInput.value : '');
            
            const headers = {
                'Content-Type': 'application/json'
            };
            
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            
            fetch('{{ route('admin.products.bulkUpdate') }}', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ products: updates })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Changes saved successfully!');
                    location.reload();
                } else {
                    alert('Error saving changes: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving changes. Please try again.');
            })
            .finally(() => {
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="bi bi-save me-2"></i>Save Changes';
            });
        }
    });

    // Highlight changed cells
    const editableCells = document.querySelectorAll('.editable');
    editableCells.forEach(cell => {
        cell.addEventListener('input', function() {
            this.classList.add('bg-warning');
        });
    });
});
</script>
@endsection

