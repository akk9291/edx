<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4 mb-4">
    <!-- Total Products Card -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 5px solid #4e73df !important;">
            <div class="card-body py-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.08em;">Total Products</div>
                        <div class="h2 mb-0 fw-bold" style="color: #2d3748;"><?php echo e($totalProducts); ?></div>
                        <div class="text-muted small mt-2">Active: <?php echo e($activeProducts); ?> | Featured: <?php echo e($featuredProducts); ?></div>
                    </div>
                    <div class="text-gray-300" style="font-size: 2.25rem; color: #dddfeb;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Categories Card -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 5px solid #1cc88a !important;">
            <div class="card-body py-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.08em;">Total Categories</div>
                        <div class="h2 mb-0 fw-bold" style="color: #2d3748;"><?php echo e($totalCategories); ?></div>
                        <div class="text-muted small mt-2">Organized catalog</div>
                    </div>
                    <div class="text-gray-300" style="font-size: 2.25rem; color: #dddfeb;">
                        <i class="bi bi-folder2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Quotations Card -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 5px solid #36b9cc !important;">
            <div class="card-body py-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.08em;">Total Quotations</div>
                        <div class="h2 mb-0 fw-bold" style="color: #2d3748;"><?php echo e($totalQuotations); ?></div>
                        <div class="text-muted small mt-2">Total query requests</div>
                    </div>
                    <div class="text-gray-300" style="font-size: 2.25rem; color: #dddfeb;">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Quotations Card -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 5px solid #f6c23e !important;">
            <div class="card-body py-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.08em;">Pending Requests</div>
                        <div class="h2 mb-0 fw-bold" style="color: #2d3748;"><?php echo e($pendingQuotations); ?></div>
                        <div class="text-muted small mt-2">Awaiting your review</div>
                    </div>
                    <div class="text-gray-300" style="font-size: 2.25rem; color: #dddfeb;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Quotations table -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="m-0 fw-bold text-secondary">Recent Quotation Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="padding-left: 25px;">Reference</th>
                                <th>Contact Person</th>
                                <th>Company</th>
                                <th>Date / Time</th>
                                <th>Status</th>
                                <th class="text-end" style="padding-right: 25px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentQuotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-semibold text-primary" style="padding-left: 25px;">
                                        <?php echo e($qr->reference); ?>

                                    </td>
                                    <td>
                                        <div><?php echo e($qr->contact_name); ?></div>
                                        <div class="text-muted small"><?php echo e($qr->email); ?></div>
                                    </td>
                                    <td><?php echo e($qr->company_name ?: 'N/A'); ?></td>
                                    <td><?php echo e($qr->created_at->format('M d, Y h:i A')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($qr->status_badge_class); ?> rounded-pill">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $qr->status))); ?>

                                        </span>
                                    </td>
                                    <td class="text-end" style="padding-right: 25px;">
                                        <a href="<?php echo e(route('admin.quota-requests.show', $qr)); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox text-gray-300" style="font-size: 2.5rem;"></i>
                                        <p class="mt-2 mb-0">No quotation requests found yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>