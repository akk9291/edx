<?php $__env->startSection('title', 'Products'); ?>
<?php $__env->startSection('page-title', 'Product Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Products</h4>
                <p class="text-muted mb-0">Manage your bearing catalog products</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <?php
                    $exportQuery = request()->only(['search', 'status', 'category_id']);
                ?>
                <button type="button" class="btn btn-outline-dark" id="toggleDatabaseMode">
                    <i class="bi bi-database me-2"></i>Database Mode
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download me-2"></i>Export Options
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'all']))); ?>">Export All (.xlsx)</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'csv', 'scope' => 'all']))); ?>">Export All (.csv)</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'active']))); ?>">Export Active Only</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'inactive']))); ?>">Export Inactive Only</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.products.bearing-export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'featured']))); ?>">Export Featured Only</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="exportSelectedXlsx">Export Selected (.xlsx)</a></li>
                        <li><a class="dropdown-item" href="#" id="exportSelectedCsv">Export Selected (.csv)</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bearingImportModal">
                    <i class="bi bi-upload me-2"></i>Import bearings (CSV / Excel)
                </button>
                <button type="button" class="btn btn-danger d-none" id="deleteSelectedBtn">
                    <i class="bi bi-trash me-2"></i>Delete Selected
                </button>
                <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
            </div>
        </div>

        <form id="bulkDeleteForm" action="<?php echo e(route('admin.products.bulkDestroy')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div id="bulkDeleteIdsContainer"></div>
        </form>

        <?php if(session('import_errors')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Import notes</strong>
                <ul class="mb-0 small">
                    <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Search and Filter Form -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Search by name, SKU..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            <?php if(request()->hasAny(['search', 'status', 'category_id'])): ?>
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(request()->hasAny(['search', 'status', 'category_id'])): ?>
    <div class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i>
        Found <strong><?php echo e($products->total()); ?></strong> product(s) matching your search criteria.
        <?php if(request('search')): ?>
            <br><small>Searching for: "<strong><?php echo e(request('search')); ?></strong>"</small>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <!-- Normal View -->
        <div class="card" id="normalView">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Show</span>
                    <select class="form-select form-select-sm" id="perPageSelect" style="width: auto;">
                        <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                        <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                        <option value="all" <?php echo e(request('per_page') == 'all' ? 'selected' : ''); ?>>All</option>
                    </select>
                    <span class="text-muted small">entries</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 40px; padding-left: 20px;">
                                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                </th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $productPlaceholder = asset('assets/images/product/perch-bottal.webp'); ?>
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $imageUrl = $product->image_url; ?>
                                <tr>
                                    <td style="padding-left: 20px;">
                                        <input type="checkbox" class="form-check-input select-row" data-id="<?php echo e($product->id); ?>">
                                    </td>
                                    <td><?php echo e($product->id); ?></td>
                                    <td>
                                        <img src="<?php echo e($imageUrl); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; background: #f0f0f0;"
                                             onerror="this.onerror=null; this.src='<?php echo e($productPlaceholder); ?>';">
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($product->name); ?></div>
                                        <?php if($product->sku): ?>
                                            <small class="text-muted">SKU: <?php echo e($product->sku); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product->category): ?>
                                            <span class="badge bg-info"><?php echo e($product->category->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                        <?php if($product->is_featured): ?>
                                            <span class="badge bg-primary">Featured</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted mb-0">No products found.</p>
                                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                            Create First Product
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($products->hasPages()): ?>
                <div class="card-footer-pagination">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr data-product-id="<?php echo e($product->id); ?>">
                                    <td><?php echo e($product->id); ?></td>
                                    <td contenteditable="true" class="editable" data-field="name"><?php echo e($product->name); ?></td>
                                    <td contenteditable="true" class="editable" data-field="slug"><?php echo e($product->slug); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sku"><?php echo e($product->sku); ?></td>
                                    <td contenteditable="true" class="editable" data-field="price"><?php echo e($product->price); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sale_price"><?php echo e($product->sale_price); ?></td>
                                    <td contenteditable="true" class="editable" data-field="stock_quantity"><?php echo e($product->stock_quantity); ?></td>
                                    <td contenteditable="true" class="editable" data-field="in_stock"><?php echo e($product->in_stock ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_active"><?php echo e($product->is_active ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_featured"><?php echo e($product->is_featured ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_new_arrival"><?php echo e($product->is_new_arrival ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="category_id"><?php echo e($product->category_id); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sort_order"><?php echo e($product->sort_order); ?></td>
                                    <td contenteditable="true" class="editable" data-field="description"><?php echo e(Str::limit($product->description ?? '', 100)); ?></td>
                                    <td contenteditable="true" class="editable" data-field="short_description"><?php echo e(Str::limit($product->short_description ?? '', 50)); ?></td>
                                    <td contenteditable="true" class="editable" data-field="meta_title"><?php echo e($product->meta_title); ?></td>
                                    <td contenteditable="true" class="editable" data-field="meta_description"><?php echo e(Str::limit($product->meta_description ?? '', 50)); ?></td>
                                    <td contenteditable="true" class="editable" data-field="meta_keywords"><?php echo e($product->meta_keywords); ?></td>
                                    <td contenteditable="true" class="editable" data-field="product_type"><?php echo e($product->product_type); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="19" class="text-center py-4">
                                        <p class="text-muted mb-0">No products found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($products->hasPages()): ?>
                <div class="card-footer-pagination">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
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
            <form method="POST" action="<?php echo e(route('admin.products.bearing-import')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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
                    <div class="mb-3">
                        <label class="form-label fw-semibold">If Bearing Number already exists:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="duplicate_action" id="dup_skip_prod" value="skip" checked>
                                <label class="form-check-label" for="dup_skip_prod">Skip Duplicate</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="duplicate_action" id="dup_update_prod" value="update">
                                <label class="form-check-label" for="dup_update_prod">Update Existing Row</label>
                            </div>
                        </div>
                    </div>
                    <p class="mb-2">
                        <a href="<?php echo e(route('admin.products.bearing-import.sample')); ?>" class="btn btn-sm btn-outline-secondary">
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
            
            fetch('<?php echo e(route('admin.products.bulkUpdate')); ?>', {
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

    // Select All Checkbox
    const selectAll = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.select-row');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

    function updateDeleteSelectedButtonVisibility() {
        if (!deleteSelectedBtn) return;
        let checkedCount = 0;
        rowCheckboxes.forEach(cb => {
            if (cb.checked) checkedCount++;
        });
        if (checkedCount > 0) {
            deleteSelectedBtn.classList.remove('d-none');
            deleteSelectedBtn.innerHTML = `<i class="bi bi-trash me-2"></i>Delete Selected (${checkedCount})`;
        } else {
            deleteSelectedBtn.classList.add('d-none');
        }
    }
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateDeleteSelectedButtonVisibility();
        });
    }

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateDeleteSelectedButtonVisibility);
    });

    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            const ids = [];
            rowCheckboxes.forEach(cb => {
                if (cb.checked) {
                    ids.push(cb.getAttribute('data-id'));
                }
            });

            if (ids.length === 0) return;

            if (confirm(`Are you sure you want to delete ${ids.length} selected product(s)?`)) {
                const container = document.getElementById('bulkDeleteIdsContainer');
                container.innerHTML = '';
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    container.appendChild(input);
                });
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    }

    const perPageSelect = document.getElementById('perPageSelect');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        });
    }
    // Export Selected Handler
    function exportSelected(format) {
        const ids = [];
        rowCheckboxes.forEach(cb => {
            if (cb.checked) {
                ids.push(cb.getAttribute('data-id'));
            }
        });
        
        if (ids.length === 0) {
            alert('Please select at least one product to export.');
            return;
        }

        const url = '<?php echo e(route('admin.products.bearing-export')); ?>?format=' + format + '&scope=selected&selected_ids=' + ids.join(',');
        window.location.href = url;
    }

    document.getElementById('exportSelectedXlsx').addEventListener('click', function(e) {
        e.preventDefault();
        exportSelected('xlsx');
    });

    document.getElementById('exportSelectedCsv').addEventListener('click', function(e) {
        e.preventDefault();
        exportSelected('csv');
    });
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/products/index.blade.php ENDPATH**/ ?>