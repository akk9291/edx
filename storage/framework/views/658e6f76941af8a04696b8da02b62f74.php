<?php $__env->startSection('title', 'Product Range - EDX Rulmenti Romania'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .edx-red {
        --tw-bg-opacity: 1;
        background-color: rgb(236 33 39);
        color: #fff !important;
    }
</style>
<!-- Breadcrumb (red) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container max-w-5xl mx-auto pt-3 pb-4 md:pt-4 md:pb-5 relative">
            <div class="main-content w-full flex flex-col items-center text-center relative z-[1]">
                <div class="text-content w-full" style="color: aliceblue;">
                    <?php if(!empty($rangeCategory)): ?>
                        <div class="heading6 font-semibold text-white/95 leading-snug max-w-3xl mx-auto"><?php echo e($rangeCategory->name); ?></div>
                    <?php endif; ?>
                    <div class="link flex justify-center gap-1 caption1 flex-wrap <?php echo e(!empty($rangeCategory) ? 'mt-2' : 'mt-3'); ?>">
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                        <i class="ph ph-caret-right text-sm" aria-hidden="true"></i>
                        <div class="capitalize"><?php echo e($rangeCategory?->name ?? 'Bearing'); ?></div>
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
                            <div class="min-price"><?php echo e($products->total()); ?></div>
                        </div>
                        <?php if(request()->filled('search')): ?>
                            <a href="<?php echo e(route('frontend.range', request()->except(['search', 'page']))); ?>" class="caption1 inline-flex items-center gap-1 rounded-full border border-line px-3 py-1 text-secondary hover:text-black">
                                Search: <?php echo e(request('search')); ?>

                                <span aria-hidden="true">&times;</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="sort-product right flex items-center gap-3">
                        <label for="select-filter" class="caption1 capitalize">Sort by</label>
                        <div class="select-block relative">
                            <select id="select-filter" name="select-filter" class="caption1 py-2 pl-3 md:pr-20 pr-10 rounded-lg border border-line" onchange="window.location.href=this.value">
                                <option value="<?php echo e(route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'latest']))); ?>" <?php echo e(request('sort', 'latest') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                                <option value="<?php echo e(route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'name']))); ?>" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name A-Z</option>
                            </select>
                            <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                        <div class="product-price text-title edx-red px-3 py-0.5 inline-block rounded-full"><?php echo e($product->category->name ?? 'Bearing'); ?></div>
                                    </div>
                                     <?php if($product instanceof \App\Models\PillowBlock): ?>
                                         <?php
                                             $specs = $product->specifications ?? [];
                                             $displaySpecs = array_slice($specs, 0, 3);
                                         ?>
                                         <?php $__empty_2 = true; $__currentLoopData = $displaySpecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                             <div class="min flex items-center gap-1 <?php echo e($idx === 0 ? 'mt-3' : ''); ?>">
                                                 <div><?php echo e($spec['title'] ?? 'Spec'); ?><?php echo e(!empty($spec['dimension']) ? ' ('.$spec['dimension'].')' : ''); ?>:</div>
                                                 <div class="min-price"><?php echo e($spec['value'] ?? 'N/A'); ?></div>
                                             </div>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                             <div class="min flex items-center gap-1 mt-3">
                                                 <div>Bearing number:</div>
                                                 <div class="min-price"><?php echo e($product->bearing_number ?? 'N/A'); ?></div>
                                             </div>
                                         <?php endif; ?>
                                    <?php elseif($product->specifications): ?>
                                    <?php $specs = is_array($product->specifications) ? $product->specifications : json_decode($product->specifications, true); ?>
                                    <?php if($specs): ?>
                                    <div class="min flex items-center gap-1 mt-3">
                                        <div>Bore diameter:</div>
                                        <div class="min-price"><?php echo e($specs['bore_diameter'] ?? 'N/A'); ?></div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Outside diameter:</div>
                                        <div class="min-price"><?php echo e($specs['outside_diameter'] ?? 'N/A'); ?></div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Width:</div>
                                        <div class="min-price"><?php echo e($specs['width'] ?? 'N/A'); ?></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="action w-fit flex flex-col items-center justify-center flex-shrink-0">
                                <button type="button" class="edx-btn-add-quote edx-btn-add-quote--compact w-full min-w-0 sm:min-w-[12rem] edx-add-quota-btn whitespace-nowrap" data-product-id="<?php echo e($product->id); ?>">
                                    <span class="edx-quota-btn-label">Add to quote</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-10">
                        <p class="text-lg text-gray-500">No products found.</p>
                        <?php if(request()->filled('search') && request()->filled('category')): ?>
                            <p class="text-secondary mt-2">No matches for &ldquo;<?php echo e(request('search')); ?>&rdquo; in <?php echo e($rangeCategory?->name ?? 'this category'); ?>.</p>
                        <?php endif; ?>
                        <?php if(!empty($searchWithoutCategoryCount) && $searchWithoutCategoryCount > 0): ?>
                            <p class="text-secondary mt-2">
                                <?php echo e($searchWithoutCategoryCount); ?> matching <?php echo e($searchWithoutCategoryCount === 1 ? 'product' : 'products'); ?> for &ldquo;<?php echo e(request('search')); ?>&rdquo; in other bearing types.
                            </p>
                            <a href="<?php echo e(route('frontend.range', request()->except(['category', 'page']))); ?>" class="mt-3 inline-block button-main py-2 px-6 rounded-full">View all matching products</a>
                        <?php elseif(request()->filled('category')): ?>
                            <a href="<?php echo e(route('frontend.range', ['category' => request('category')])); ?>" class="mt-4 inline-block button-main py-2 px-6 rounded-full">View all in <?php echo e($rangeCategory?->name ?? 'category'); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('frontend.range')); ?>" class="mt-4 inline-block button-main py-2 px-6 rounded-full">View All Products</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($products->hasPages()): ?>
                <div class="list-pagination w-full flex items-center gap-4 mt-10">
                    <?php if($products->onFirstPage()): ?>
                    <button class="opacity-50 cursor-not-allowed">&lt;&lt;</button>
                    <?php else: ?>
                    <a href="<?php echo e($products->url(1)); ?>">&lt;&lt;</a>
                    <a href="<?php echo e($products->previousPageUrl()); ?>">&lt;</a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($url); ?>" class="<?php echo e($page == $products->currentPage() ? 'active' : ''); ?>"><?php echo e($page); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($products->hasMorePages()): ?>
                    <a href="<?php echo e($products->nextPageUrl()); ?>">&gt;</a>
                    <a href="<?php echo e($products->url($products->lastPage())); ?>">&gt;&gt;</a>
                    <?php else: ?>
                    <button class="opacity-50 cursor-not-allowed">&gt;&gt;</button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/frontend/range.blade.php ENDPATH**/ ?>