<?php $__env->startSection('title', 'Pillow Blocks'); ?>
<?php $__env->startSection('page-title', 'Pillow Block Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Pillow Blocks</h4>
                <p class="text-muted mb-0">Manage your pillow block bearing units</p>
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
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.pillow-block.export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'all']))); ?>">Export All (.xlsx)</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.pillow-block.export', array_merge($exportQuery, ['format' => 'csv', 'scope' => 'all']))); ?>">Export All (.csv)</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.pillow-block.export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'active']))); ?>">Export Active Only</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.pillow-block.export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'inactive']))); ?>">Export Inactive Only</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('admin.pillow-block.export', array_merge($exportQuery, ['format' => 'xlsx', 'scope' => 'featured']))); ?>">Export Featured Only</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="exportSelectedXlsx">Export Selected (.xlsx)</a></li>
                        <li><a class="dropdown-item" href="#" id="exportSelectedCsv">Export Selected (.csv)</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pillowImportModal">
                    <i class="bi bi-upload me-2"></i>Import Pillow Blocks
                </button>
                <button type="button" class="btn btn-danger d-none" id="deleteSelectedBtn">
                    <i class="bi bi-trash me-2"></i>Delete Selected
                </button>
                <a href="<?php echo e(route('admin.pillow-block.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Pillow Block
                </a>
            </div>
        </div>

        <form id="bulkDeleteForm" action="<?php echo e(route('admin.pillow-block.bulkDestroy')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div id="bulkDeleteIdsContainer"></div>
        </form>

        <?php if(session('import_errors')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Import notes / errors:</strong>
                <ul class="mb-0 small" style="max-height: 200px; overflow-y: auto;">
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
                <form method="GET" action="<?php echo e(route('admin.pillow-block.index')); ?>" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Search by name, SKU, bearing or housing number..." 
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
                                <a href="<?php echo e(route('admin.pillow-block.index')); ?>" class="btn btn-outline-secondary">
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
        Found <strong><?php echo e($pillowBlocks->total()); ?></strong> pillow block(s) matching your search criteria.
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
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 40px; padding-left: 20px;">
                                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                </th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name / SKU</th>
                                <th>Category</th>
                                <th>Bearing Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $placeholder = asset('assets/images/product/perch-bottal.webp'); ?>
                            <?php $__empty_1 = true; $__currentLoopData = $pillowBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td style="padding-left: 20px;">
                                        <input type="checkbox" class="form-check-input select-row" data-id="<?php echo e($pb->id); ?>">
                                    </td>
                                    <td><?php echo e($pb->id); ?></td>
                                    <td>
                                        <img src="<?php echo e($pb->image_url); ?>" 
                                             alt="<?php echo e($pb->name); ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; background: #f0f0f0;"
                                             onerror="this.onerror=null; this.src='<?php echo e($placeholder); ?>';">
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($pb->bearing_number); ?></div>
                                        <small class="text-muted">SKU: <?php echo e($pb->sku); ?></small>
                                    </td>
                                    <td>
                                        <?php if($pb->category): ?>
                                            <span class="badge bg-info"><?php echo e($pb->category->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="text-secondary fw-semibold"><?php echo e($pb->bearing_number ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <?php if($pb->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                        <?php if($pb->is_featured): ?>
                                            <span class="badge bg-primary">Featured</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.pillow-block.show', $pb)); ?>" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.pillow-block.edit', $pb)); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.pillow-block.destroy', $pb)); ?>" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this pillow block?');">
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
                                    <td colspan="8" class="text-center py-4">
                                        <p class="text-muted mb-0">No pillow blocks found.</p>
                                        <a href="<?php echo e(route('admin.pillow-block.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                            Create First Pillow Block
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($pillowBlocks->hasPages()): ?>
                <div class="card-footer-pagination">
                    <?php echo e($pillowBlocks->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Database Mode View -->
        <div class="card d-none" id="databaseModeView">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Database Mode - Inline Bulk Editor</h5>
                    <button type="button" class="btn btn-success" id="saveDatabaseChanges">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-striped table-sm mb-0" id="databaseTable" style="min-width: 2500px; font-size: 0.8rem;">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th style="width: 200px;">Name</th>
                                <th style="width: 150px;">SKU</th>
                                <th style="width: 100px;">Price</th>
                                <th style="width: 100px;">Sale Price</th>
                                <th style="width: 80px;">Active</th>
                                <th style="width: 80px;">Featured</th>
                                <th style="width: 80px;">New Arrival</th>
                                <th style="width: 80px;">Category ID</th>
                                <th style="width: 80px;">Sort Order</th>
                                <!-- Specs -->
                                <th style="width: 120px;">Bearing Number</th>
                                <th style="width: 300px;">Specifications</th>
                                <th style="width: 100px;">SKF</th>
                                <th style="width: 100px;">FAG</th>
                                <th style="width: 100px;">NTN</th>
                                <th style="width: 100px;">Timken</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pillowBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr data-pb-id="<?php echo e($pb->id); ?>">
                                    <td><?php echo e($pb->id); ?></td>
                                    <td contenteditable="true" class="editable fw-semibold" data-field="name"><?php echo e($pb->name); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sku"><?php echo e($pb->sku); ?></td>
                                    <td contenteditable="true" class="editable" data-field="price"><?php echo e($pb->price); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sale_price"><?php echo e($pb->sale_price); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_active"><?php echo e($pb->is_active ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_featured"><?php echo e($pb->is_featured ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="is_new_arrival"><?php echo e($pb->is_new_arrival ? '1' : '0'); ?></td>
                                    <td contenteditable="true" class="editable" data-field="category_id"><?php echo e($pb->category_id); ?></td>
                                    <td contenteditable="true" class="editable" data-field="sort_order"><?php echo e($pb->sort_order); ?></td>
                                    <!-- Specs -->
                                    <td contenteditable="true" class="editable" data-field="bearing_number"><?php echo e($pb->bearing_number); ?></td>
                                    <td contenteditable="true" class="editable" data-field="specifications"><?php
                                        $formatted = [];
                                        if (is_array($pb->specifications)) {
                                            foreach ($pb->specifications as $spec) {
                                                $t = trim($spec['title'] ?? '');
                                                $d = trim($spec['dimension'] ?? '');
                                                $v = trim($spec['value'] ?? '');
                                                if ($t !== '' || $d !== '' || $v !== '') {
                                                    $formatted[] = "{$t}|{$d}|{$v}";
                                                }
                                            }
                                        }
                                        echo implode(';', $formatted);
                                    ?></td>
                                    <td contenteditable="true" class="editable" data-field="equiv_skf"><?php echo e($pb->equiv_skf); ?></td>
                                    <td contenteditable="true" class="editable" data-field="equiv_fag"><?php echo e($pb->equiv_fag); ?></td>
                                    <td contenteditable="true" class="editable" data-field="equiv_ntn"><?php echo e($pb->equiv_ntn); ?></td>
                                    <td contenteditable="true" class="editable" data-field="equiv_timken"><?php echo e($pb->equiv_timken); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="30" class="text-center py-4">No pillow blocks found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($pillowBlocks->hasPages()): ?>
                <div class="card-footer-pagination">
                    <?php echo e($pillowBlocks->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="pillowImportModal" tabindex="-1" aria-labelledby="pillowImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="pillowImportModalLabel">Import Pillow Block Catalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.pillow-block.import')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        The uploaded sheet must exactly match the client's Excel layout with 2 header rows. Any duplicates can be skipped or updated based on your choice below.
                    </div>
                    <div class="mb-3">
                        <label for="import_file" class="form-label fw-semibold">File (.csv, .xlsx, .xls — max 20 MB)</label>
                        <input type="file" class="form-control" name="import_file" id="import_file" accept=".csv,.txt,.xlsx,.xls" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">If Bearing Number already exists:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="duplicate_action" id="dup_skip" value="skip" checked>
                                <label class="form-check-label" for="dup_skip">Skip Duplicate</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="duplicate_action" id="dup_update" value="update">
                                <label class="form-check-label" for="dup_update">Update Existing Row</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('admin.pillow-block.import.sample')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Download Sample Template
                        </a>
                        <span class="text-muted small">Matches the official client sheet format.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i>Run Import
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

    // Toggle Mode
    toggleButton.addEventListener('click', function() {
        isDatabaseMode = !isDatabaseMode;
        if (isDatabaseMode) {
            normalView.classList.add('d-none');
            databaseModeView.classList.remove('d-none');
            toggleButton.innerHTML = '<i class="bi bi-table me-2"></i>Normal View';
            toggleButton.classList.replace('btn-outline-dark', 'btn-dark');
        } else {
            normalView.classList.remove('d-none');
            databaseModeView.classList.add('d-none');
            toggleButton.innerHTML = '<i class="bi bi-database me-2"></i>Database Mode';
            toggleButton.classList.replace('btn-dark', 'btn-outline-dark');
        }
    });

    // Bulk Save Changes
    saveButton.addEventListener('click', function() {
        const updates = [];
        const rows = document.querySelectorAll('#databaseTable tbody tr[data-pb-id]');
        
        rows.forEach(row => {
            if (row.querySelector('.editable.bg-warning')) { // Only save modified rows
                const id = row.getAttribute('data-pb-id');
                const editableCells = row.querySelectorAll('.editable');
                const pbData = { id: id };
                
                editableCells.forEach(cell => {
                    const field = cell.getAttribute('data-field');
                    let value = cell.textContent.trim();
                    
                    if (['is_active', 'is_featured', 'is_new_arrival'].includes(field)) {
                        value = value === '1' || value.toLowerCase() === 'true' || value.toLowerCase() === 'yes';
                    } else if (['price', 'sale_price', 'category_id', 'sort_order', 'shaft_diameter', 'center_height', 'overall_length', 'hole_distance', 'base_width', 'bolt_hole_length', 'bolt_hole_width', 'base_thickness', 'overall_height', 'inner_ring_width', 'set_screw_distance', 'weight', 'j7', 'h7', 'h8', 'h9'].includes(field)) {
                        value = value === '' ? null : parseFloat(value);
                    }
                    
                    pbData[field] = value;
                });
                
                updates.push(pbData);
            }
        });

        if (updates.length > 0) {
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="bi bi-spinner me-2"></i>Saving...';
            
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const token = csrfMeta ? csrfMeta.getAttribute('content') : '<?php echo e(csrf_token()); ?>';
            
            fetch('<?php echo e(route('admin.pillow-block.bulkUpdate')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ pillow_blocks: updates })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Changes saved successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Save failed.');
            })
            .finally(() => {
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="bi bi-save me-2"></i>Save Changes';
            });
        } else {
            alert('No changes detected.');
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

            if (confirm(`Are you sure you want to delete ${ids.length} selected pillow block(s)?`)) {
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

    // Export Selected Handler
    function exportSelected(format) {
        const ids = [];
        rowCheckboxes.forEach(cb => {
            if (cb.checked) {
                ids.push(cb.getAttribute('data-id'));
            }
        });
        
        if (ids.length === 0) {
            alert('Please select at least one pillow block to export.');
            return;
        }

        const url = '<?php echo e(route('admin.pillow-block.export')); ?>?format=' + format + '&scope=selected&selected_ids=' + ids.join(',');
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

    const perPageSelect = document.getElementById('perPageSelect');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/pillow-block/index.blade.php ENDPATH**/ ?>