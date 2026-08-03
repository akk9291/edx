<?php $__env->startSection('title', 'Product Details'); ?>
<?php $__env->startSection('page-title', 'Product Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <?php if($product->resolveMainImagePath()): ?>
                    <div class="mb-3">
                        <img src="<?php echo e($product->image_url); ?>"
                             alt="<?php echo e($product->name); ?>"
                             class="img-fluid"
                             style="max-width: 300px; border-radius: 8px;">
                    </div>
                <?php endif; ?>
                <table class="table">
                    <tr>
                        <th width="200">ID</th>
                        <td><?php echo e($product->id); ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo e($product->name); ?></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code><?php echo e($product->slug); ?></code></td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td><?php echo e($product->sku ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>MRP</th>
                        <td><?php echo e((float) $product->price > 0 ? number_format((float) $product->price, 2) : '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Sale price</th>
                        <td><?php echo e($product->sale_price !== null && (float) $product->sale_price > 0 ? number_format((float) $product->sale_price, 2) : '—'); ?></td>
                    </tr>
                    <?php if(filled($product->meta_title)): ?>
                    <tr>
                        <th>Meta title</th>
                        <td><?php echo e($product->meta_title); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(filled($product->meta_description)): ?>
                    <tr>
                        <th>Meta description</th>
                        <td><?php echo e(\Illuminate\Support\Str::limit($product->meta_description, 500)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(filled($product->meta_keywords)): ?>
                    <tr>
                        <th>Meta keywords</th>
                        <td><?php echo e($product->meta_keywords); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Category</th>
                        <td>
                            <?php if($product->category): ?>
                                <span class="badge bg-info"><?php echo e($product->category->name); ?></span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($product->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                            <?php if($product->is_featured): ?>
                                <span class="badge bg-primary ms-2">Featured</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if($product->short_description): ?>
                    <tr>
                        <th>Short Description</th>
                        <td><?php echo e($product->short_description); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($product->description): ?>
                    <tr>
                        <th>Description</th>
                        <td><?php echo e($product->description); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo e($product->created_at->format('F d, Y h:i A')); ?></td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td><?php echo e($product->updated_at->format('F d, Y h:i A')); ?></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Product
                    </a>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/products/show.blade.php ENDPATH**/ ?>