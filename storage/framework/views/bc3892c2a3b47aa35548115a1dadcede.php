<?php $__env->startSection('title', 'Pillow Block Details'); ?>
<?php $__env->startSection('page-title', 'Pillow Block Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Basic Details Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-info-circle me-2"></i>Pillow Block Information</h5>
            </div>
            <div class="card-body">
                <?php if($pillowBlock->resolveMainImagePath()): ?>
                    <div class="mb-3 text-center">
                        <img src="<?php echo e($pillowBlock->image_url); ?>"
                             alt="<?php echo e($pillowBlock->name); ?>"
                             class="img-fluid rounded"
                             style="max-height: 250px; border: 1px solid #ddd; padding: 5px; background-color: #fff;">
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width="180">ID</th>
                        <td><?php echo e($pillowBlock->id); ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong><?php echo e($pillowBlock->name); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code><?php echo e($pillowBlock->slug); ?></code></td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td><?php echo e($pillowBlock->sku ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td><?php echo e($pillowBlock->brand ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>MRP</th>
                        <td><?php echo e((float) $pillowBlock->price > 0 ? number_format((float) $pillowBlock->price, 2) . ' RON' : 'Price on request'); ?></td>
                    </tr>
                    <tr>
                        <th>Sale price</th>
                        <td><?php echo e($pillowBlock->sale_price !== null && (float) $pillowBlock->sale_price > 0 ? number_format((float) $pillowBlock->sale_price, 2) . ' RON' : '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>
                            <?php if($pillowBlock->category): ?>
                                <span class="badge bg-info"><?php echo e($pillowBlock->category->name); ?></span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($pillowBlock->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                            <?php if($pillowBlock->is_featured): ?>
                                <span class="badge bg-primary ms-1">Featured</span>
                            <?php endif; ?>
                            <?php if($pillowBlock->is_new_arrival): ?>
                                <span class="badge bg-warning text-dark ms-1">New Arrival</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if($pillowBlock->short_description): ?>
                    <tr>
                        <th>Short Description</th>
                        <td><?php echo e($pillowBlock->short_description); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Specifications Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-gear-fill me-2"></i>Pillow Block Specifications</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width="220">Bearing Number</th>
                        <td><?php echo e($pillowBlock->bearing_number ?? '—'); ?></td>
                    </tr>
                    <?php
                        $specs = $pillowBlock->specifications ?? [];
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <th>
                                <?php echo e($spec['title'] ?? 'Specification'); ?>

                                <?php if(!empty($spec['dimension'])): ?>
                                    (<?php echo e($spec['dimension']); ?>)
                                <?php endif; ?>
                            </th>
                            <td><?php echo e($spec['value'] ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2" class="text-muted text-center py-2">No additional specifications defined.</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th colspan="2" class="table-secondary text-center fw-bold">Equivalents</th>
                    </tr>
                    <tr>
                        <th>SKF</th>
                        <td><?php echo e($pillowBlock->equiv_skf ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>FAG</th>
                        <td><?php echo e($pillowBlock->equiv_fag ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>NTN</th>
                        <td><?php echo e($pillowBlock->equiv_ntn ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Timken</th>
                        <td><?php echo e($pillowBlock->equiv_timken ?? '—'); ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Description & Media Links -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if($pillowBlock->description): ?>
                    <h6 class="fw-bold mb-2">Detailed Description:</h6>
                    <div class="p-3 bg-light rounded border mb-4">
                        <?php echo $pillowBlock->description; ?>

                    </div>
                <?php endif; ?>

                <?php if($pillowBlock->video || $pillowBlock->pdf_catalogue || count($pillowBlock->images) > 0): ?>
                    <h6 class="fw-bold mb-3">Media Attachments:</h6>
                    <div class="row">
                        <!-- Video -->
                        <?php if($pillowBlock->video): ?>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small fw-semibold">Product Video</p>
                                <video src="<?php echo e(storage_asset($pillowBlock->video)); ?>" controls class="img-fluid rounded border bg-black" style="max-height: 200px; width: 100%;"></video>
                            </div>
                        <?php endif; ?>

                        <!-- PDF -->
                        <?php if($pillowBlock->pdf_catalogue): ?>
                            <div class="col-md-4 mb-3 d-flex flex-col justify-content-center align-items-start">
                                <p class="mb-1 text-muted small fw-semibold">Catalogue Sheet</p>
                                <a href="<?php echo e(storage_asset($pillowBlock->pdf_catalogue)); ?>" target="_blank" class="btn btn-outline-danger d-inline-flex align-items-center p-3 rounded">
                                    <i class="bi bi-file-earmark-pdf-fill fs-2 me-2"></i>
                                    <div>
                                        <div class="fw-bold text-start">Download PDF Catalog</div>
                                        <div class="small text-muted text-start">Open in new tab</div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Gallery -->
                        <?php if(count($pillowBlock->images) > 0): ?>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small fw-semibold">Gallery Images</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $pillowBlock->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(storage_asset($img->image_path)); ?>" target="_blank">
                                            <img src="<?php echo e(storage_asset($img->image_path)); ?>" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex gap-2 border-top pt-3 mt-4">
                    <a href="<?php echo e(route('admin.pillow-block.edit', $pillowBlock)); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Pillow Block
                    </a>
                    <a href="<?php echo e(route('admin.pillow-block.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/pillow-block/show.blade.php ENDPATH**/ ?>