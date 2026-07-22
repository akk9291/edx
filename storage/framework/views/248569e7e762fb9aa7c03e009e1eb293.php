<?php $__env->startSection('title', 'Create Category'); ?>
<?php $__env->startSection('page-title', 'Create New Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
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

                        <div class="col-md-6 mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="parent_id" 
                                    name="parent_id">
                                <option value="">None (Main Category)</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id') == $parent->id ? 'selected' : ''); ?>>
                                        <?php echo e($parent->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Leave empty to create a main category</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="3"><?php echo e(old('description')); ?></textarea>
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

                    <div class="mb-3">
                        <label for="image" class="form-label">Category Thumbnail Image</label>
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
                               onchange="previewImage(this, 'imagePreview', 'previewImg')">
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
                        <small class="form-text text-muted">Category thumbnail. Recommended size: 400x400px. Max size: 2MB</small>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Hero Section (Main Banner)</h5>

                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero/Banner Image</label>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['hero_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="hero_image" 
                               name="hero_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'heroImagePreview', 'heroPreviewImg')">
                        <?php $__errorArgs = ['hero_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Main banner image for category page. Recommended size: 1920x600px. Max size: 5MB</small>
                        <div id="heroImagePreview" class="mt-2" style="display: none;">
                            <img id="heroPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="hero_text" class="form-label">Hero Text</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['hero_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hero_text" 
                                   name="hero_text" 
                                   value="<?php echo e(old('hero_text')); ?>"
                                   placeholder="e.g. Loved For A Lifetime, FOR EVERY SHADE IN YOU">
                            <?php $__errorArgs = ['hero_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Main heading text displayed on hero banner</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hero_button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['hero_button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hero_button_text" 
                                   name="hero_button_text" 
                                   value="<?php echo e(old('hero_button_text', 'Shop Now')); ?>">
                            <?php $__errorArgs = ['hero_button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Text for hero button (default: Shop Now)</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Promotional Banners (3 Blocks)</h5>

                    <?php for($i = 0; $i < 3; $i++): ?>
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Banner <?php echo e($i + 1); ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Banner Image <?php echo e($i + 1); ?></label>
                                <input type="file" 
                                       class="form-control" 
                                       name="banner_images[]" 
                                       accept="image/*"
                                       onchange="previewBannerImage(this, <?php echo e($i); ?>)">
                                <small class="form-text text-muted">Recommended size: 600x400px. Max size: 2MB</small>
                                <div id="bannerImagePreview<?php echo e($i); ?>" class="mt-2" style="display: none;">
                                    <img id="bannerPreviewImg<?php echo e($i); ?>" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Text <?php echo e($i + 1); ?></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="banner_texts[]" 
                                       value="<?php echo e(old('banner_texts.' . $i, '')); ?>"
                                       placeholder="e.g. Drinkware, Barware, Kitchenware">
                                <small class="form-text text-muted">Text to display on this banner</small>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>

                    <hr class="my-4">
                    <h5 class="mb-3">Bottom Banner Section</h5>

                    <div class="mb-3">
                        <label for="bottom_banner_image" class="form-label">Bottom Banner Image</label>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['bottom_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="bottom_banner_image" 
                               name="bottom_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'bottomBannerImagePreview', 'bottomBannerPreviewImg')">
                        <?php $__errorArgs = ['bottom_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Bottom section banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="bottomBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="bottomBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bottom_banner_text" class="form-label">Bottom Banner Text</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['bottom_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="bottom_banner_text" 
                               name="bottom_banner_text" 
                               value="<?php echo e(old('bottom_banner_text')); ?>"
                               placeholder="e.g. Created to be loved for a lifetime">
                        <?php $__errorArgs = ['bottom_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Text displayed on bottom banner</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Testimonial Section</h5>

                    <div class="mb-3">
                        <label for="testimonial_text" class="form-label">Testimonial/Quote Text</label>
                        <textarea class="form-control <?php $__errorArgs = ['testimonial_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="testimonial_text" 
                                  name="testimonial_text" 
                                  rows="3"
                                  placeholder="e.g. I absolutely love this shop! The products are high-quality..."><?php echo e(old('testimonial_text')); ?></textarea>
                        <?php $__errorArgs = ['testimonial_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Customer testimonial or quote text displayed on category page</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Additional Banner (Optional)</h5>

                    <div class="mb-3">
                        <label for="additional_banner_image" class="form-label">Additional Banner Image</label>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['additional_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="additional_banner_image" 
                               name="additional_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'additionalBannerImagePreview', 'additionalBannerPreviewImg')">
                        <?php $__errorArgs = ['additional_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Optional additional banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="additionalBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="additionalBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional_banner_text" class="form-label">Additional Banner Text</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['additional_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="additional_banner_text" 
                               name="additional_banner_text" 
                               value="<?php echo e(old('additional_banner_text')); ?>"
                               placeholder="e.g. Palettes, Check & Coutour">
                        <?php $__errorArgs = ['additional_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Text displayed on additional banner</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="<?php echo e(old('sort_order', 0)); ?>" 
                                   min="0">
                            <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Lower numbers appear first</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <small class="form-text text-muted">Inactive categories won't appear on the website</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input, previewId, imgId) {
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(imgId);
        
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

    function previewBannerImage(input, index) {
        previewImage(input, 'bannerImagePreview' + index, 'bannerPreviewImg' + index);
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>