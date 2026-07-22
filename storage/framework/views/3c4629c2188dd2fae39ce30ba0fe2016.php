<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="card border-0 shadow-sm text-center py-5 px-4">
            <div class="card-body">
                <div class="mb-4 text-muted" style="font-size: 3rem;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <h2 class="fw-bold mb-3" style="color: #2d3748;">Coming soon</h2>
                <p class="text-muted mb-4 mb-md-5 lead">
                    The analytics dashboard is not available yet. Use the menu to manage categories, products, and quotations.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-primary">Categories</a>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-primary">Products</a>
                    <a href="<?php echo e(route('admin.quota-requests.index')); ?>" class="btn btn-outline-primary">Quotations</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>