<?php $__env->startSection('title', 'Quotations'); ?>
<?php $__env->startSection('page-title', 'Quotations'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Quotation requests</h4>
        <p class="text-muted mb-0">Requests submitted from the website quota list</p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <form method="GET" action="<?php echo e(route('admin.quota-requests.index')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filter-status" class="form-label small text-muted mb-1">Status</label>
                        <select name="status" id="filter-status" class="form-select form-select-sm">
                            <option value="all" <?php echo e(($status ?? '') === 'all' || ($status ?? '') === '' ? 'selected' : ''); ?>>All</option>
                            <option value="pending" <?php echo e(($status ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="in_review" <?php echo e(($status ?? '') === 'in_review' ? 'selected' : ''); ?>>In review</option>
                            <option value="quoted" <?php echo e(($status ?? '') === 'quoted' ? 'selected' : ''); ?>>Quoted</option>
                            <option value="closed" <?php echo e(($status ?? '') === 'closed' ? 'selected' : ''); ?>>Closed</option>
                            <option value="cancelled" <?php echo e(($status ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="search" class="form-label small text-muted mb-1">Search</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" value="<?php echo e($search ?? ''); ?>" placeholder="Reference, name, email…">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Lines</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $quotaRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($req->reference); ?></strong></td>
                                <td><?php echo e($req->contact_name); ?></td>
                                <td><?php echo e($req->email); ?></td>
                                <td><?php echo e($req->items_count); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($req->status_badge_class); ?>"><?php echo e(str_replace('_', ' ', $req->status)); ?></span>
                                </td>
                                <td><?php echo e($req->created_at->format('M d, Y H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.quota-requests.show', $req)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">No quota requests yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($quotaRequests->hasPages()): ?>
            <div class="card-footer card-footer-pagination">
                <?php echo e($quotaRequests->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/quota-requests/index.blade.php ENDPATH**/ ?>