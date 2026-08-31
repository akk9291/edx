<?php $__env->startSection('title', 'EDX Rulmenti Romania S.R.L. - Ball Bearings & Industrial Products'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb (red) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col items-center text-center relative z-[1]">
                <div class="text-content w-full" style="color: aliceblue;">
                    <div class="link flex justify-center gap-1 caption1 flex-wrap">
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                        <i class="ph ph-caret-right text-sm" aria-hidden="true"></i>
                        <div class="capitalize">Bearing</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full border-b border-line" style="background: #f8f8f8;">
    <div class="container max-w-6xl mx-auto px-4 py-5 md:py-8">
        <?php echo $__env->make('frontend.partials.catalog-search-bar', ['centered' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<?php echo $__env->make('frontend.partials.edx-product-category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
    <div class="container">
        
        <div class="flex max-md:flex-wrap max-md:flex-col gap-y-8">
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                <?php echo $__env->make('frontend.partials.catalog-sidebar', ['categories' => $categories ?? collect(), 'facets' => $facets ?? ['rows' => []]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="list-product-block style-list lg:w-3/4 md:w-2/3 w-full md:pl-3">
                <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                    <div class="left flex has-line items-center flex-wrap gap-5">
                        <div class="min flex items-center gap-1">
                            <div>Products:</div>
                            <div class="min-price"><?php echo e($productTotal ?? 0); ?></div>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    <?php $__empty_1 = true; $__currentLoopData = $products ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $s = $product->specifications;
                        if (is_string($s)) {
                            $s = json_decode($s, true);
                        }
                        $s = is_array($s) ? $s : [];
                    ?>
                    <div class="product-item list-type edxpro" data-product-id="<?php echo e($product->id); ?>">
                        <div class="product-main cursor-pointer flex lg:items-center sm:justify-between gap-7 max-lg:gap-5 p-4">
                            <a href="<?php echo e(route('frontend.product', $product->slug)); ?>" class="flex sm:items-center gap-7 max-lg:gap-4 max-lg:flex-wrap lg:w-2/3 lg:flex-shrink-0 max-lg:w-full max-sm:flex-col max-sm:w-1/2 flex-1 min-w-0 no-underline text-inherit">
                                <div class="product-thumb bg-white relative overflow-hidden rounded-2xl block max-sm:w-1/2">
                                    <div class="product-img w-full rounded-2xl overflow-hidden">
                                        <img class="w-full duration-700" src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" style="width: 200px;">
                                    </div>
                                </div>
                                <div class="product-infor max-sm:w-full">
                                    <div class="product-name heading6 inline-block duration-300"><?php echo e($product->display_name); ?></div>
                                    <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                        <div class="product-price text-title bg-green px-3 py-0.5 inline-block rounded-full"><?php echo e($product->category->name ?? 'Deep Groove Ball Bearing'); ?></div>
                                    </div>
                                    <div class="min flex items-center gap-1 mt-3">
                                        <div>Bore diameter:</div>
                                        <div class="min-price"><?php echo e($s['bore_diameter'] ?? '—'); ?></div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Outside diameter:</div>
                                        <div class="min-price"><?php echo e($s['outside_diameter'] ?? '—'); ?></div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Width:</div>
                                        <div class="min-price"><?php echo e($s['width'] ?? '—'); ?></div>
                                    </div>
                                </div>
                            </a>
                            <div class="action w-fit flex flex-col items-center justify-center flex-shrink-0">
                                <button type="button" class="edx-btn-add-quote edx-btn-add-quote--compact py-2 px-9 max-lg:px-5 edx-add-quota-btn whitespace-nowrap" data-product-id="<?php echo e($product->id); ?>">
                                    <span class="edx-quota-btn-label">Add to quote</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-10 text-secondary">
                        <p>No products in the database yet. Run <code class="text-black">php artisan db:seed</code> or visit the range page.</p>
                        <a href="<?php echo e(route('frontend.range')); ?>" class="inline-block mt-4 button-main py-2 px-8 rounded-full">Product range</a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if(($products ?? collect())->count() > 0 && ($productTotal ?? 0) > ($products ?? collect())->count()): ?>
                <div class="mt-10 text-center">
                    <a href="<?php echo e(route('frontend.range')); ?>" class="button-main inline-block py-3 px-10 rounded-full">View full range</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/frontend/home.blade.php ENDPATH**/ ?>