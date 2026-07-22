<?php $__env->startSection('title', 'Categories'); ?>
<?php $__env->startSection('page-title', 'Category Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Categories</h4>
                <p class="text-muted mb-0">
                    <?php if(! empty($bearingCatalogOnly)): ?>
                        Bearing catalogue only (main category <strong>Bearings</strong>).
                    <?php else: ?>
                        All categories in the database.
                    <?php endif; ?>
                </p>
                <div class="small mt-2 d-flex flex-wrap gap-2 align-items-center">
                    <?php if(! empty($bearingCatalogOnly)): ?>
                        <a href="<?php echo e(route('admin.categories.index', ['show_all' => 1])); ?>" class="text-primary">Show all categories</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-primary">Bearing categories only</a>
                    <?php endif; ?>
                    <span class="text-muted">·</span>
                    <?php if(empty($subOnly)): ?>
                        <a href="<?php echo e(route('admin.categories.index', array_merge(['sub_only' => 1], ! empty($showAll) ? ['show_all' => 1] : []))); ?>" class="text-primary">Sub-categories only</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.categories.index', ! empty($showAll) ? ['show_all' => 1] : [])); ?>" class="text-primary">Show top-level + sub</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Category
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Children</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($category->id); ?></td>
                                    <td>
                                        <?php if($category->image): ?>
                                            <?php $catImgUrl = storage_asset($category->image); ?>
                                            <div class="position-relative" style="width: 60px; height: 60px;">
                                                <img src="<?php echo e($catImgUrl); ?>" 
                                                     alt="<?php echo e($category->name); ?>" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                                     onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                <div class="d-none bg-light d-flex align-items-center justify-content-center position-absolute top-0 start-0" 
                                                     style="width: 60px; height: 60px; border-radius: 8px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 8px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($category->name); ?></div>
                                        <?php if($category->description): ?>
                                            <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($category->description, 50)); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><code><?php echo e($category->slug); ?></code></td>
                                    <td>
                                        <?php if($category->parent): ?>
                                            <span class="badge bg-info"><?php echo e($category->parent->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($category->children->count() > 0): ?>
                                            <span class="badge bg-secondary"><?php echo e($category->children->count()); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($category->sort_order); ?></td>
                                    <td>
                                        <?php if($category->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.categories.show', $category)); ?>" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                                    <td colspan="9" class="text-center py-4">
                                        <p class="text-muted mb-2">No categories match this filter.</p>
                                        <?php if(! empty($bearingCatalogOnly)): ?>
                                            <a href="<?php echo e(route('admin.categories.index', ['show_all' => 1])); ?>" class="btn btn-sm btn-outline-primary me-2">Show all categories</a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                            Add category
                                        </a>
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

<!-- Category Tree View -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Category Tree</h5>
            </div>
            <div class="card-body">
                <div class="category-tree">
                    <?php
                        $mainCategories = $categories->whereNull('parent_id');
                    ?>
                    <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tree-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <?php if($mainCategory->image): ?>
                                    <span class="position-relative d-inline-block" style="width: 40px; height: 40px;">
                                        <img src="<?php echo e(storage_asset($mainCategory->image)); ?>" 
                                             alt="<?php echo e($mainCategory->name); ?>" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; margin-right: 10px;"
                                             onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                        <span class="d-none position-absolute top-0 start-0 bg-light rounded" style="width:40px;height:40px;"><i class="bi bi-image text-muted"></i></span>
                                    </span>
                                <?php else: ?>
                                    <i class="bi bi-folder-fill text-warning me-2"></i>
                                <?php endif; ?>
                                <strong><?php echo e($mainCategory->name); ?></strong>
                                <?php if(!$mainCategory->is_active): ?>
                                    <span class="badge bg-danger ms-2">Inactive</span>
                                <?php endif; ?>
                            </div>
                            <?php if($mainCategory->children->count() > 0): ?>
                                <div class="ms-4">
                                    <?php $__currentLoopData = $mainCategory->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="tree-item mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <?php if($subCategory->image): ?>
                                                    <span class="position-relative d-inline-block" style="width: 35px; height: 35px;">
                                                        <img src="<?php echo e(storage_asset($subCategory->image)); ?>" 
                                                             alt="<?php echo e($subCategory->name); ?>" 
                                                             style="width: 35px; height: 35px; object-fit: cover; border-radius: 5px; margin-right: 8px;"
                                                             onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                        <span class="d-none position-absolute top-0 start-0"><i class="bi bi-image text-muted"></i></span>
                                                    </span>
                                                <?php else: ?>
                                                    <i class="bi bi-folder text-info me-2"></i>
                                                <?php endif; ?>
                                                <span><?php echo e($subCategory->name); ?></span>
                                                <?php if(!$subCategory->is_active): ?>
                                                    <span class="badge bg-danger ms-2">Inactive</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($subCategory->children->count() > 0): ?>
                                                <div class="ms-4">
                                    <?php $__currentLoopData = $subCategory->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center mb-1">
                                            <?php if($product->image): ?>
                                                <span class="position-relative d-inline-block" style="width: 30px; height: 30px;">
                                                    <img src="<?php echo e(storage_asset($product->image)); ?>" 
                                                         alt="<?php echo e($product->name); ?>" 
                                                         style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; margin-right: 8px;"
                                                         onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                    <span class="d-none position-absolute top-0 start-0"><i class="bi bi-image text-muted"></i></span>
                                                </span>
                                            <?php else: ?>
                                                <i class="bi bi-file-earmark text-secondary me-2"></i>
                                            <?php endif; ?>
                                            <small><?php echo e($product->name); ?></small>
                                            <?php if(!$product->is_active): ?>
                                                <span class="badge bg-danger ms-2">Inactive</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>