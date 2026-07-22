<?php
    $variant = $variant ?? 'list';
    $mrp = (float) $product->price;
    $sale = $product->sale_price !== null ? (float) $product->sale_price : null;
    $showPrice = $product->hasDisplayablePrice();
    $priceLabelClass = $variant === 'detail' ? 'heading5 edx-text-accent mb-0 font-bold' : 'text-title font-bold edx-text-accent mb-0';
    $saleStackClass = $variant === 'detail' ? 'heading5 edx-text-accent mb-0 font-bold' : 'text-title font-bold edx-text-accent mb-0';
    $mrpStrikeClass = $variant === 'detail' ? 'caption1 text-secondary edx-mrp-strike font-normal' : 'caption2 text-secondary edx-mrp-strike font-normal';
?>
<?php if($showPrice): ?>
    <div class="edx-catalog-list-price w-full <?php echo e($variant === 'detail' ? 'mt-2' : 'mt-1.5'); ?>">
        <?php if($mrp > 0 && $sale !== null && $sale > 0 && $sale < $mrp): ?>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <span class="<?php echo e($priceLabelClass); ?>">Price: <?php echo e(number_format($sale, 2)); ?></span>
                <span class="w-px h-5 bg-line shrink-0 self-center" aria-hidden="true"></span>
                <span class="<?php echo e($mrpStrikeClass); ?>"><?php echo e(number_format($mrp, 2)); ?></span>
            </div>
        <?php elseif($sale !== null && $sale > 0): ?>
            <div class="<?php echo e($saleStackClass); ?>">Price: <?php echo e(number_format($sale, 2)); ?></div>
            <?php if($mrp > 0 && $sale >= $mrp): ?>
                <div class="caption1 text-secondary <?php echo e($variant === 'detail' ? 'mb-0' : 'mt-0.5'); ?>">MRP: <?php echo e(number_format($mrp, 2)); ?></div>
            <?php endif; ?>
        <?php elseif($mrp > 0): ?>
            <div class="<?php echo e($saleStackClass); ?>"><?php echo e($variant === 'detail' ? 'MRP: ' : 'Price: '); ?><?php echo e(number_format($mrp, 2)); ?></div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php if($variant === 'detail'): ?>
        <div class="product-price heading5 edx-text-accent mt-2">Price on request</div>
    <?php else: ?>
        <div class="caption2 text-secondary mt-1">Price on request</div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\laragon\www\edx\resources\views/frontend/partials/catalog-list-price.blade.php ENDPATH**/ ?>