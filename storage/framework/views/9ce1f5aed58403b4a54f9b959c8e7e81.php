<?php
    $facets = $facets ?? ['rows' => []];
    $rowList = $facets['rows'] ?? [];
?>

<!-- 1. Type of bearing -->
<div class="filter-type-block pb-8 border-b border-line">
    <div class="heading6">Type of bearing</div>
    <div class="list-type filter-type menu-tab mt-4">
        <a href="<?php echo e(route('frontend.range', request()->except(['category', 'page', 'search']))); ?>"
           class="item tab-item flex items-center justify-between cursor-pointer <?php echo e(! request()->filled('category') ? 'active' : ''); ?>">
            <div class="type-name text-secondary has-line-before hover:text-black capitalize">All types</div>
            <div class="text-secondary2 number"><?php echo e($categories->sum('catalog_product_count')); ?></div>
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['category', 'page', 'search']), ['category' => $category->slug]))); ?>"
               class="item tab-item flex items-center justify-between cursor-pointer <?php echo e(request('category') === $category->slug ? 'active' : ''); ?>"
               data-item="<?php echo e($category->slug); ?>">
                <div class="type-name text-secondary has-line-before hover:text-black capitalize"><?php echo e($category->name); ?></div>
                <div class="text-secondary2 number"><?php echo e($category->catalog_product_count ?? 0); ?></div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- 2. Inner bore diameter -->
<div class="filter-size pb-8 border-b border-line mt-8">
    <div class="heading6">Inner bore diameter (mm)</div>
    <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
        <a href="<?php echo e(route('frontend.range', request()->except(['bore', 'page']))); ?>"
           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(! request()->filled('bore') ? 'bg-black text-white' : ''); ?>">All</a>
        <?php $__currentLoopData = ['0-20' => '0–20', '20-50' => '20–50', '50-100' => '50–100', '100+' => '100+']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bKey => $bLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['bore', 'page']), ['bore' => $bKey]))); ?>"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(request('bore') === $bKey ? 'bg-black text-white' : ''); ?>"><?php echo e($bLabel); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php if(count($rowList) > 0): ?>
    <!-- 3. Number of rows -->
    <div class="filter-size pb-8 border-b border-line mt-8">
        <div class="heading6">Number of rows</div>
        <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
            <a href="<?php echo e(route('frontend.range', request()->except(['rows', 'page']))); ?>"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(! request()->filled('rows') ? 'bg-black text-white' : ''); ?>">All</a>
            <?php $__currentLoopData = $rowList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['rows', 'page']), ['rows' => $row]))); ?>"
                   class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(request('rows') === $row ? 'bg-black text-white' : ''); ?>"><?php echo e($row); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH F:\laragon\www\edx\resources\views/frontend/partials/catalog-sidebar.blade.php ENDPATH**/ ?>