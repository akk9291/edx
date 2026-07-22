<?php
    $searchAction = $searchAction ?? route('frontend.range');
    $centered = $centered ?? false;
?>
<div id="catalog-search" class="catalog-top-search w-full <?php if($centered): ?> has-search-card <?php else: ?> mb-4 <?php endif; ?>">
    <?php if($centered): ?>
        <div class="edx-search-card w-full max-w-full">
            <form action="<?php echo e($searchAction); ?>" method="GET" class="edx-search-pill-form">
                <?php $__currentLoopData = ['bore', 'rows', 'sort']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preserveKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(request()->filled($preserveKey)): ?>
                        <input type="hidden" name="<?php echo e($preserveKey); ?>" value="<?php echo e(request($preserveKey)); ?>">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="edx-search-pill-row">
                    <input
                        type="search"
                        name="search"
                        value="<?php echo e(request('search')); ?>"
                        autocomplete="off"
                        placeholder="Search bearings…"
                        class="edx-search-pill-input"
                    />
                    <button type="submit" class="edx-search-pill-btn" aria-label="Search">
                        <i class="ph ph-magnifying-glass" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="heading6 mb-3">Search</div>
        <form action="<?php echo e($searchAction); ?>" method="GET" class="edx-catalog-search-form flex w-full max-w-5xl items-stretch">
            <?php $__currentLoopData = ['bore', 'rows', 'sort']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preserveKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(request()->filled($preserveKey)): ?>
                    <input type="hidden" name="<?php echo e($preserveKey); ?>" value="<?php echo e(request($preserveKey)); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="edx-search-field-wrap flex min-h-[48px] min-w-0 flex-1 items-center rounded-l-lg border border-r-0 bg-white pl-1" style="border-color: #e4e4e7;">
                <input type="search" name="search" value="<?php echo e(request('search')); ?>"
                    autocomplete="off"
                    placeholder="Search by designation, name or SKU…"
                    class="edx-search-input h-full w-full min-w-0 border-0 bg-transparent py-2 pl-3 pr-2 text-sm text-black" />
            </div>
            <button type="submit" class="edx-search-submit inline-flex min-h-[48px] w-12 shrink-0 items-center justify-center rounded-r-lg" aria-label="Search">
                <i class="ph ph-magnifying-glass text-xl" aria-hidden="true"></i>
            </button>
        </form>
    <?php endif; ?>
</div>
<?php /**PATH F:\laragon\www\edx\resources\views/frontend/partials/catalog-search-bar.blade.php ENDPATH**/ ?>