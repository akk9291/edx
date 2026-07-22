<?php $__env->startSection('title', 'Create Pillow Block'); ?>
<?php $__env->startSection('page-title', 'Create New Pillow Block'); ?>

<?php $__env->startSection('content'); ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pillow Block Information</h5>
            </div>
            <div class="card-body">
                <form id="pillow-create-form" action="<?php echo e(route('admin.pillow-block.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="name" 
                                   name="name" 
                                   value="<?php echo e(old('name')); ?>" 
                                   required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category_id" 
                                    name="category_id">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Brand -->
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="brand" 
                                   name="brand" 
                                   value="<?php echo e(old('brand')); ?>">
                            <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- SKU -->
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="sku" 
                                   name="sku" 
                                   value="<?php echo e(old('sku')); ?>">
                            <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Leave empty to auto-generate</small>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="3" 
                                  placeholder="Brief summary (shown in product cards and below price)"><?php echo e(old('short_description')); ?></textarea>
                        <small class="text-muted">Brief teaser text, max 500 characters. Shown in product listings and below price.</small>
                        <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Pricing Section -->
                    <div class="card border mb-3 bg-light">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">Pricing</h6>
                            <p class="small text-muted mb-3">Leave both empty or zero for <strong>Price on request</strong>. <strong>MRP</strong> is the list price; <strong>Sale price</strong> is optional promotional pricing.</p>
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="price" class="form-label">MRP</label>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="price"
                                           name="price"
                                           value="<?php echo e(old('price', '')); ?>"
                                           placeholder="0.00">
                                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="sale_price" class="form-label">Sale price</label>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="sale_price"
                                           name="sale_price"
                                           value="<?php echo e(old('sale_price', '')); ?>"
                                           placeholder="Optional">
                                    <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="card border mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">SEO</h6>
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta title</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="meta_title"
                                       name="meta_title"
                                       value="<?php echo e(old('meta_title')); ?>"
                                       maxlength="255">
                                <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta description</label>
                                <textarea class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="meta_description"
                                          name="meta_description"
                                          rows="3"
                                          maxlength="5000"><?php echo e(old('meta_description')); ?></textarea>
                                <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-0">
                                <label for="meta_keywords" class="form-label">Meta keywords</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="meta_keywords"
                                       name="meta_keywords"
                                       value="<?php echo e(old('meta_keywords')); ?>"
                                       maxlength="1000">
                                <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Detailed Description</label>
                        <div id="editor-description" class="bg-white border rounded" style="min-height: 220px;"></div>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> d-none" 
                                  id="description" 
                                  name="description" 
                                  rows="8"><?php echo e(old('description')); ?></textarea>
                        <small class="text-muted">Full product description. Shown in the Description tab. Use the toolbar to format.</small>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Pillow Block Specifications Form Partial -->
                    <?php echo $__env->make('admin.pillow-block.partials.pillow-block-spec-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <!-- Media Uploads (Featured Image, Gallery, Video, PDF Catalogue) -->
                    <div class="card border mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0 text-white"><i class="bi bi-images me-2"></i>Media &amp; Attachments</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Featured Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Featured Image</label>
                                    <input type="file" 
                                           class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Recommended size: 800x800px. Max size: 2MB</small>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    </div>
                                </div>

                                <!-- Gallery Images -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gallery Images</label>
                                    <div id="new-gallery-images" class="mb-2 d-flex flex-wrap gap-2"></div>
                                    <div class="d-flex gap-2">
                                        <input type="file"
                                               class="form-control"
                                               id="gallery_image_single"
                                               accept="image/*">
                                        <button type="button" class="btn btn-sm btn-success text-nowrap" id="add-gallery-image-btn">
                                            <i class="bi bi-plus me-1"></i>Add Image
                                        </button>
                                    </div>
                                    <input type="file" name="gallery_images[]" id="gallery_images_hidden" multiple accept="image/*" style="display: none;">
                                    <?php $__errorArgs = ['gallery_images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php $__errorArgs = ['gallery_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Select multiple images for the product gallery. Max size: 2MB each.</small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Product Video -->
                                <div class="col-md-6 mb-3">
                                    <label for="video" class="form-label">Product Video</label>
                                    <input type="file"
                                           class="form-control <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="video"
                                           name="video"
                                           accept="video/*">
                                    <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Optional product video (MP4, MOV, AVI, MKV). Max size: 50MB.</small>
                                </div>

                                <!-- PDF Catalogue -->
                                <div class="col-md-6 mb-3">
                                    <label for="pdf_catalogue" class="form-label">PDF Catalogue</label>
                                    <input type="file"
                                           class="form-control <?php $__errorArgs = ['pdf_catalogue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="pdf_catalogue"
                                           name="pdf_catalogue"
                                           accept=".pdf">
                                    <?php $__errorArgs = ['pdf_catalogue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Optional PDF spec sheet or catalog. Max size: 10MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status switches -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="in_stock" name="in_stock" value="1" <?php echo e(old('in_stock', true) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="in_stock">In Stock</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1" <?php echo e(old('is_new_arrival') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_new_arrival">New Arrival</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" id="sort_order" value="<?php echo e(old('sort_order', 0)); ?>" min="0">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4 border-top pt-3">
                        <a href="<?php echo e(route('admin.pillow-block.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Pillow Block
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var descTa = document.getElementById('description');
        if (descTa && document.getElementById('editor-description')) {
            var quill = new Quill('#editor-description', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [5, 6, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });
            if (descTa.value) quill.clipboard.dangerouslyPasteHTML(descTa.value);
            document.getElementById('pillow-create-form').addEventListener('submit', function(e) {
                e.preventDefault();
                descTa.value = quill.root.innerHTML;
                this.submit();
            });
        }

        // Gallery single add handler
        var gallerySingleInput = document.getElementById('gallery_image_single');
        var galleryHiddenInput = document.getElementById('gallery_images_hidden');
        var newGalleryContainer = document.getElementById('new-gallery-images');
        var addGalleryBtn = document.getElementById('add-gallery-image-btn');
        var fileList = [];
        
        if (gallerySingleInput && addGalleryBtn) {
            addGalleryBtn.addEventListener('click', function() {
                gallerySingleInput.click();
            });
            gallerySingleInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    var file = e.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var div = document.createElement('div');
                        div.className = 'position-relative d-inline-block gallery-thumb-wrap';
                        div.innerHTML = '<img src="' + event.target.result + '" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #e2e8f0;"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle remove-new-gallery-btn" style="width: 24px; height: 24px; padding: 0; font-size: 12px;"><i class="bi bi-x"></i></button>';
                        div.querySelector('.remove-new-gallery-btn').addEventListener('click', function() {
                            var dataTransfer = new DataTransfer();
                            fileList = fileList.filter(function(f) { return f !== file; });
                            fileList.forEach(function(f) { dataTransfer.items.add(f); });
                            galleryHiddenInput.files = dataTransfer.files;
                            div.remove();
                        });
                        newGalleryContainer.appendChild(div);
                        fileList.push(file);
                        var dataTransfer = new DataTransfer();
                        fileList.forEach(function(f) { dataTransfer.items.add(f); });
                        galleryHiddenInput.files = dataTransfer.files;
                        gallerySingleInput.value = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/pillow-block/create.blade.php ENDPATH**/ ?>