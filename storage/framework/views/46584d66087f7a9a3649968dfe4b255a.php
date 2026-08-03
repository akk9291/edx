<?php
    $specs = [];
    if (!($product instanceof \App\Models\PillowBlock)) {
        $specs = $product->specifications;
        if (is_string($specs)) {
            $specs = json_decode($specs, true);
        }
    }
    $specs = is_array($specs) ? $specs : [];

    $equivRows = [];
    foreach (['equiv_skf' => 'SKF', 'equiv_fag' => 'FAG', 'equiv_ntn' => 'NTN', 'equiv_timken' => 'Timken'] as $key => $brand) {
        if ($product instanceof \App\Models\PillowBlock) {
            $model = trim((string) ($product->$key ?? ''));
        } else {
            $model = isset($specs[$key]) ? trim((string) $specs[$key]) : '';
        }
        $equivRows[] = ['brand' => $brand, 'model' => $model];
    }

    $suffixRows = [];
    $hadAdminSuffixPairRows = false;
    if (! empty($specs['suffix_pairs']) && is_array($specs['suffix_pairs'])) {
        foreach ($specs['suffix_pairs'] as $row) {
            if (! is_array($row)) {
                continue;
            }
            $s = trim((string) ($row['suffix'] ?? ''));
            $d = trim((string) ($row['description'] ?? ''));
            if ($s === '' && $d === '') {
                continue;
            }
            $hadAdminSuffixPairRows = true;
            $suffixRows[] = ['suffix' => $s !== '' ? $s : '—', 'description' => $d];
        }
    }
    if (! $hadAdminSuffixPairRows) {
        $suffixName = isset($specs['suffix_name']) ? trim((string) $specs['suffix_name']) : '';
        $suffixDesc = isset($specs['suffix_desc']) ? trim((string) $specs['suffix_desc']) : '';
        $suffixCode = isset($specs['suffix']) ? trim((string) $specs['suffix']) : '';
        if ($suffixName !== '' && $suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixName, 'description' => $suffixDesc];
        } elseif ($suffixCode !== '' && $suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixCode, 'description' => $suffixDesc];
        } elseif ($suffixCode !== '' && $suffixName !== '') {
            $suffixRows[] = ['suffix' => $suffixCode, 'description' => $suffixName];
        } elseif ($suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixCode !== '' ? $suffixCode : '—', 'description' => $suffixDesc];
        }
    }
    if (! $hadAdminSuffixPairRows) {
    foreach ($specs as $k => $v) {
        if ($k === 'suffix_pairs') {
            continue;
        }
        if (! is_string($k) || ! is_scalar($v)) {
            continue;
        }
        $v = trim((string) $v);
        if ($v === '') {
            continue;
        }
        if (! str_starts_with(strtolower($k), 'suffix_')) {
            continue;
        }
        if (in_array($k, ['suffix_name', 'suffix_desc', 'suffix'], true)) {
            continue;
        }
        $label = (string) preg_replace('/^suffix_/i', '', $k);
        $label = $label !== '' ? str_replace('_', ' ', $label) : $k;
        $suffixRows[] = ['suffix' => ucwords($label), 'description' => $v];
    }
    }

    $suffixCount = count($suffixRows);
?>

<?php $__env->startSection('title'); ?>
<?php echo e(trim((string) ($product->meta_title ?? '')) !== '' ? trim($product->meta_title) : ($product->display_name.' - EDX Rulmenti Romania')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('meta'); ?>
<?php
    $metaDesc = trim((string) ($product->meta_description ?? ''));
    $metaKw = trim((string) ($product->meta_keywords ?? ''));
?>
<?php if($metaDesc !== ''): ?>
<meta name="description" content="<?php echo e(\Illuminate\Support\Str::limit(strip_tags($metaDesc), 500)); ?>">
<?php endif; ?>
<?php if($metaKw !== ''): ?>
<meta name="keywords" content="<?php echo e(e(strip_tags($metaKw))); ?>">
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html p:last-child { margin-bottom: 0; }

/* Spec tables in tabs use global .spec-table (layouts/frontend) */
.product-detail .desc-tab .spec-table td.edx-empty-cell {
    text-align: left !important;
    color: #71717a !important;
    padding: 1.25rem 0 !important;
    font-size: 0.875rem;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td.edx-empty-cell {
    padding: 1.25rem 0 !important;
}

/* Product spec sheet (edx-product.html style): flat, label left / value right, hairline rules — no “card” chrome */
.product-detail .desc-tab .desc-block--spec {
    background: #fff;
    border: none;
    border-radius: 0;
    padding: 0;
    margin-top: 2rem;
}
.product-detail .desc-tab .edx-spec-block {
    min-width: 0;
    margin: 0;
}
.product-detail .desc-tab .edx-spec-block__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #18181b;
    line-height: 1.3;
    margin: 0 0 0.75rem 0;
    padding: 0;
    letter-spacing: -0.01em;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table {
    width: 100%;
    border-collapse: collapse;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr {
    border-bottom: 1px solid #e8e8ed;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr:last-child {
    border-bottom: none;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td {
    padding: 0.6rem 0;
    font-size: 0.875rem;
    line-height: 1.45;
    color: #3f3f46;
    vertical-align: top;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td:first-child {
    color: #52525b;
    font-weight: 500;
    padding-right: 1.25rem;
    max-width: 58%;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td:last-child {
    text-align: right;
    color: #18181b;
    font-weight: 500;
    word-break: break-word;
}
/* Cross-ref / suffix: two-column data with a header row (no grey bar — hairline only) */
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th {
    border-bottom: 1px solid #d4d4d8;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td {
    background: transparent;
    font-weight: 600;
    color: #18181b;
    font-size: 0.875rem;
    padding: 0 0 0.5rem 0;
    vertical-align: bottom;
    border: none;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td:first-child {
    color: #18181b;
    font-weight: 600;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td:last-child {
    text-align: right;
}
/* edx.ltd style: rectangular tab buttons, uppercase, grey inactive / solid red selected */
.product-detail .desc-tab .menu-tab.edx-spec-tabs {
    position: relative;
    justify-content: flex-start;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab {
    -webkit-appearance: none;
    appearance: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 0;
    margin: 0;
    padding: 0.65rem 1.35rem;
    min-height: 2.75rem;
    font: inherit;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
    cursor: pointer;
    /* Inactive: very light grey, dark text (edxromania reference) */
    color: #52525b;
    background-color: #f4f4f5;
    transition: background-color 0.2s ease, color 0.2s ease;
    text-align: center;
    line-height: 1.2;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab:hover:not(.active) {
    background-color: #e9e9ec;
    color: #3f3f46;
    outline: none;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab:focus-visible:not(.active) {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #ec2127;
    outline: none;
}
/* Active: medium grey + white label + red top bar (~4px), like edxromania Equivalents tab */
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active {
    background-color: #9ca3af;
    color: #ffffff;
    box-shadow: inset 0 4px 0 #ec2127;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active:hover {
    background-color: #8b909a;
    color: #ffffff;
    box-shadow: inset 0 4px 0 #ec2127;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active:focus-visible {
    box-shadow: inset 0 4px 0 #ec2127, 0 0 0 2px #fff, 0 0 0 4px #18181b;
}

/* Equivalents & Suffix — full width inside .container; Equivalents uses light grey rules only (see --equiv) */
.product-detail .edx-tab-table-panel {
    width: 100%;
    max-width: none;
    margin-left: auto;
    margin-right: auto;
}
.product-detail .edx-tab-table-panel .edx-tab-panel-heading {
    font-size: 1.375rem;
    font-weight: 700;
    color: #18181b;
    line-height: 1.25;
    margin: 0 0 1rem 0;
    padding: 0;
    letter-spacing: -0.02em;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table thead th {
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: #18181b;
    padding: 0 0 0.65rem 0;
    border-bottom: none;
    vertical-align: bottom;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table thead th:first-child,
.product-detail .edx-tab-table-panel .edx-tab-minimal-table tbody td:first-child {
    padding-right: 1.25rem;
    box-sizing: border-box;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table thead th:last-child {
    text-align: right;
}
/* Suffix: column split + strong header rule */
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix thead tr {
    border-bottom: 2px solid #18181b;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix thead th:first-child,
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix tbody td:first-child {
    width: 38%;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix thead th:last-child,
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix tbody td:last-child {
    width: 62%;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix thead th:last-child {
    text-align: left;
}

/* Equivalents (Brand | Model) — brand first, model beside it; empty model cells when no data */
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv {
    border-top: 1px solid #e0e0e0;
    width: auto;
    max-width: 100%;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv thead tr {
    border-bottom: 1px solid #e0e0e0;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv thead th {
    padding: 12px 1.25rem 12px 0;
    font-weight: 700;
    font-size: 0.875rem;
    color: #18181b;
    text-align: left;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv thead th:first-child,
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv tbody td:first-child {
    width: 1%;
    white-space: nowrap;
    padding-right: 1.25rem;
    font-weight: 600;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv thead th:last-child,
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv tbody td:last-child {
    width: auto;
    text-align: left;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv tbody td {
    padding: 12px 1.25rem 12px 0;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #27272a;
    border-bottom: 1px solid #e0e0e0;
    vertical-align: top;
    text-align: left;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv tbody td:last-child {
    text-align: left !important;
    font-weight: 400;
}

.product-detail .edx-tab-table-panel .edx-tab-minimal-table tbody td {
    font-size: 0.875rem;
    line-height: 1.5;
    color: #3f3f46;
    padding: 0.7rem 0;
    border-bottom: 1px solid #e8e8ed;
    vertical-align: top;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table tbody td:first-child {
    font-weight: 500;
    color: #18181b;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table tbody td:last-child {
    text-align: right;
    font-weight: 500;
    color: #18181b;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix tbody td:first-child {
    font-weight: 700;
    color: #18181b;
    text-align: left;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--suffix tbody td:last-child {
    text-align: left;
    font-weight: 400;
    color: #3f3f46;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table tbody tr:last-child td {
    border-bottom: none;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table--equiv tbody tr:last-child td {
    border-bottom: 1px solid #e0e0e0;
}
.product-detail .edx-tab-table-panel .edx-tab-minimal-table td.edx-empty-cell {
    text-align: left !important;
    color: #71717a !important;
    padding: 1rem 0 !important;
}
.edx-red {
    --tw-bg-opacity: 1;
    background-color: rgb(236 33 39);
    color: #fff !important;
}
/* Scoped accent — never add bare `.ph` here (breaks all Phosphor icons) */
.product-detail .edx-text-accent {
    color: rgb(236 33 39);
}

/* Match theme .quantity-block .disabled for edx-quantity-block (main.js handleQuantity binds .quantity-block only) */
.featured-product.underwear .edx-quantity-block .disabled,
.featured-product.cosmetic .edx-quantity-block .disabled {
    color: var(--secondary2);
    opacity: 0.8;
    cursor: default;
}

/* Quantity: typeable number, hide spinners, match stepper row */
.edx-quantity-block input#qty-value {
    width: 2.75rem;
    min-width: 1.5rem;
    max-width: 4rem;
    text-align: center;
    font: inherit;
    font-weight: 600;
    color: inherit;
    background: transparent;
    border: 0;
    border-radius: 0;
    padding: 0;
    -moz-appearance: textfield;
    appearance: textfield;
}
.edx-quantity-block input#qty-value:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(236, 33, 39, 0.25);
    border-radius: 4px;
}
.edx-quantity-block input#qty-value::-webkit-outer-spin-button,
.edx-quantity-block input#qty-value::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb (matches edx-product.html) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2"><?php echo e($product->category->name ?? 'Bearing'); ?></div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">Bearing</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-detail default">
    <div class="featured-product underwear filter-product-img md:py-20 py-14">
        <div class="container flex justify-between gap-y-6 flex-wrap md:items-start">
            <div class="list-img w-full md:w-5/12 md:pr-8 lg:pr-10 flex-shrink-0">
                <img class="object-contain object-center duration-700" src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>">
            </div>
            <div class="product-item product-infor w-full md:w-7/12 md:pl-6 lg:pl-8" data-item="<?php echo e($product->id); ?>">
                <div class="product-name heading4 mt-1"><?php echo e($product->sku); ?></div>

                <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                    <div class="product-sale font-semibold edx-red px-3 py-0.5 inline-block rounded-full"><?php echo e($product->category->name ?? 'Deep Groove Ball Bearing'); ?></div>
                    <?php $descHtml = trim((string) ($product->description ?? '')); ?>
                    <?php if($descHtml !== ''): ?>
                    <div class="product-description text-secondary mt-3 w-full product-description-html">
                        <?php echo $descHtml; ?>

                    </div>
                    <?php endif; ?>
                    <?php echo $__env->make('frontend.partials.catalog-list-price', ['variant' => 'detail'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <div class="list-action mt-6">
                    <div class="product-category text-secondary font-semibold edx-text-accent">Available in stock</div>
                    <div class="text-title mt-5">Quantity:</div>
                    <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                        
                        <div class="edx-quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-center gap-1 rounded-lg border border-line sm:w-[160px] w-[140px] flex-shrink-0">
                            <i class="ph-bold ph-minus cursor-pointer body1 disabled shrink-0" id="qty-minus" role="button" aria-label="Decrease quantity" tabindex="0"></i>
                            <input type="number" class="body1 quantity" id="qty-value" name="quantity" min="1" max="99999" value="1" inputmode="numeric" pattern="[0-9]*" aria-label="Quantity" autocomplete="off" />
                            <i class="ph-bold ph-plus cursor-pointer body1 shrink-0" id="qty-plus" role="button" aria-label="Increase quantity" tabindex="0"></i>
                        </div>
                        <button type="button" class="edx-btn-add-quote whitespace-nowrap edx-add-quota-btn" data-product-id="<?php echo e($product->id); ?>">
                            <i class="ph ph-files shrink-0" aria-hidden="true"></i>
                            <span class="edx-quota-btn-label">Add to quote</span>
                        </button>
                    </div>

                    <div class="more-infor mt-6">
                                <div class="flex items-center gap-4 flex-wrap">
                                    <div class="flex items-center gap-1">
                                        <i class="ph ph-package body1"></i>
                                        <div class="text-title">This product is available from stock.</div>
                                    </div>
                                    
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-clock body1"></i>
                                    <div class="text-title">Orders placed before 6 p.m. CEST will be shipped today.</div>
                                    
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-scroll body1"></i>
                                    <div class="text-title">Payment by invoice possible.</div>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-path body1"></i>
                                    <div class="text-title">Track your order.</div>
                                    
                                </div>
                                
                            </div>
                </div>

                <div class="button-block mt-5 flex flex-col sm:flex-row gap-3">
                    <a href="<?php echo e(route('frontend.product.pdf.download', $product->slug)); ?>" class="button-main flex-1 text-center"><i class="ph ph-download"></i> Download PDF</a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-tab md:pb-20 pb-10">
        <div class="container">
            <div class="w-full">
                <div class="menu-tab edx-spec-tabs flex flex-wrap items-stretch gap-2" role="tablist" aria-label="Product information">
                    <button type="button" class="tab-item edx-spec-tab active" data-item="Overview" role="tab" aria-selected="true" id="tab-overview">Overview</button>
                    <button type="button" class="tab-item edx-spec-tab" data-item="Equivalents" role="tab" aria-selected="false" id="tab-equivalents">Equivalents</button>
                    <?php if(!($product instanceof \App\Models\PillowBlock)): ?>
                    <button type="button" class="tab-item edx-spec-tab" data-item="Suffixdescription" role="tab" aria-selected="false" id="tab-suffix">Suffix description</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="desc-block desc-block--spec mt-6 relative w-full max-w-full">
                <div class="desc-item description open pb-10 w-full max-w-full" data-item="Overview">
                    <?php if($product instanceof \App\Models\PillowBlock): ?>
                    <div class="grid md:grid-cols-2 gap-8 md:gap-x-12 gap-y-8 mt-2 w-full">
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-dim">
                            <h2 id="spec-dim" class="edx-spec-block__title">Specifications</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table">
                                    <tr>
                                        <td>Bearing Number</td>
                                        <td><strong><?php echo e($product->bearing_number ?? '—'); ?></strong></td>
                                    </tr>
                                    <?php
                                        $specsList = $product->specifications ?? [];
                                        $half = max(1, (int)ceil(count($specsList) / 2));
                                        $leftSpecs = array_slice($specsList, 0, $half);
                                        $rightSpecs = array_slice($specsList, $half);
                                    ?>
                                    <?php $__currentLoopData = $leftSpecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($spec['title'] ?? 'Specification'); ?>

                                            <?php if(!empty($spec['dimension'])): ?>
                                                (<?php echo e($spec['dimension']); ?>)
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($spec['value'] ?? '—'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </section>
                        <?php if(!empty($rightSpecs)): ?>
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-dim-right">
                            <h2 id="spec-dim-right" class="edx-spec-block__title">&nbsp;</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table">
                                    <?php $__currentLoopData = $rightSpecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($spec['title'] ?? 'Specification'); ?>

                                            <?php if(!empty($spec['dimension'])): ?>
                                                (<?php echo e($spec['dimension']); ?>)
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($spec['value'] ?? '—'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </section>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="grid md:grid-cols-2 gap-8 md:gap-x-12 gap-y-8 mt-2 w-full">
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-dim">
                            <h2 id="spec-dim" class="edx-spec-block__title">Boundary dimensions</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table">
                                    <tr>
                                        <td>Bore diameter</td>
                                        <td><?php echo e($specs['bore_diameter'] ?? '12 mm'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Outside diameter</td>
                                        <td><?php echo e($specs['outside_diameter'] ?? '28 mm'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Width</td>
                                        <td><?php echo e($specs['width'] ?? '7 mm'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-perf">
                            <h2 id="spec-perf" class="edx-spec-block__title">Performance</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table">
                                    <tr>
                                        <td>Basic dynamic load rating</td>
                                        <td><?php echo e($specs['dynamic_load_rating'] ?? '5.10 KN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Basic static load rating</td>
                                        <td><?php echo e($specs['static_load_rating'] ?? '2.39 KN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Grease</td>
                                        <td><?php echo e($specs['limiting_speed_grease'] ?? '26000 r/min'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Oil</td>
                                        <td><?php echo e($specs['limiting_speed_oil'] ?? '30000 r/min'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <section class="edx-spec-block min-w-0 md:col-span-2" aria-labelledby="spec-props">
                            <h2 id="spec-props" class="edx-spec-block__title">Properties</h2>
                            <div class="edx-spec-block__table max-w-4xl">
                                <table class="spec-table">
                                    <tr>
                                        <td>Number of rows</td>
                                        <td><?php echo e($specs['number_of_rows'] ?? '1'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bore type</td>
                                        <td><?php echo e($specs['bore_type'] ?? 'Cylindrical'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cage</td>
                                        <td><?php echo e($specs['cage'] ?? 'Sheet Steel'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Radial internal clearance</td>
                                        <td><?php echo e($specs['radial_clearance'] ?? 'CN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tolerance class for dimensions</td>
                                        <td><?php echo e($specs['tolerance_class'] ?? 'P6'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                    </div>
                    <?php endif; ?>
                </div>


                <div class="desc-item description pb-10 w-full max-w-full" data-item="Equivalents">
                    <div class="mt-2 min-w-0 w-full max-w-full overflow-x-auto">
                        <section class="edx-spec-block edx-tab-table-panel" aria-labelledby="spec-equiv">
                            <h2 id="spec-equiv" class="edx-tab-panel-heading">Equivalents</h2>
                            <table class="edx-tab-minimal-table edx-tab-minimal-table--equiv">
                                <thead>
                                    <tr>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Model</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $equivRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($row['brand']); ?></td>
                                        <td><?php if($row['model'] !== ''): ?><?php echo e($row['model']); ?><?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>

                <div class="desc-item description pb-10 w-full max-w-full" data-item="Suffixdescription">
                    <?php if($suffixCount === 0): ?>
                    <p class="text-secondary mt-2">No suffix codes or descriptions are stored for this product in the catalogue data.</p>
                    <?php else: ?>
                    <div class="mt-2 min-w-0 w-full max-w-full overflow-x-auto">
                        <section class="edx-spec-block edx-tab-table-panel" aria-labelledby="spec-suf">
                            <h2 id="spec-suf" class="edx-tab-panel-heading">Suffix description</h2>
                            <table class="edx-tab-minimal-table edx-tab-minimal-table--suffix">
                                <thead>
                                    <tr>
                                        <th scope="col">Suffix / field</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $suffixRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($row['suffix']); ?></td>
                                        <td><?php echo e($row['description']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($relatedProducts->count() > 0): ?>
    <div class="related-products lg:py-20 md:py-14 py-10 bg-surface">
        <div class="container">
            <div class="heading text-center mb-10">
                <div class="heading3">Related Products</div>
            </div>
            <div class="list-product grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-item edxpro bg-white rounded-2xl border border-line overflow-hidden flex flex-col h-full">
                    <a href="<?php echo e(route('frontend.product', $relatedProduct->slug)); ?>" class="block p-4 pb-3 no-underline text-inherit flex-1 min-w-0">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl aspect-square">
                            <div class="product-img w-full h-full rounded-2xl overflow-hidden flex items-center justify-center bg-surface">
                                <img class="w-full h-full object-contain duration-700" src="<?php echo e($relatedProduct->image_url); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                            </div>
                        </div>
                        <div class="product-infor mt-4">
                            <div class="product-name heading6 block duration-300 line-clamp-2"><?php echo e($relatedProduct->display_name); ?></div>
                            <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                <div class="product-price text-title edx-red px-3 py-0.5 inline-block rounded-full text-sm"><?php echo e($relatedProduct->category->name ?? 'Bearing'); ?></div>
                            </div>
                        </div>
                    </a>
                    <div class="action flex flex-col gap-2 p-4 pt-0 mt-auto">
                        <a href="<?php echo e(route('frontend.product', $relatedProduct->slug)); ?>" class="button-main w-full text-center py-2.5 px-4 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white no-underline text-sm">View details</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
(function () {
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    const qtyValue = document.getElementById('qty-value');

    function getQty() {
        var n = parseInt(String(qtyValue && qtyValue.value !== undefined ? qtyValue.value : '').trim(), 10);
        if (isNaN(n) || n < 1) {
            return 1;
        }
        return Math.min(99999, n);
    }
    function setQty(n) {
        var v = Math.max(1, Math.min(99999, parseInt(n, 10) || 1));
        if (qtyValue) {
            qtyValue.value = String(v);
        }
        if (qtyMinus) {
            qtyMinus.classList.toggle('disabled', v <= 1);
        }
    }
    if (qtyMinus && qtyPlus && qtyValue) {
        qtyMinus.addEventListener('click', function (e) {
            e.preventDefault();
            setQty(getQty() - 1);
        });
        qtyPlus.addEventListener('click', function (e) {
            e.preventDefault();
            setQty(getQty() + 1);
        });
        qtyValue.addEventListener('change', function () {
            setQty(getQty());
        });
        qtyValue.addEventListener('blur', function () {
            setQty(getQty());
        });
        qtyValue.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                setQty(getQty());
                qtyValue.blur();
            }
        });
        setQty(1);
    }

    const descTabItems = document.querySelectorAll('.product-detail .desc-tab .menu-tab .tab-item[data-item]');
    const descItems = document.querySelectorAll('.product-detail .desc-tab .desc-block .desc-item');

    function showDescTab(key) {
        descItems.forEach(function (item) {
            item.classList.toggle('open', item.getAttribute('data-item') === key);
        });
    }

    descTabItems.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var key = tab.getAttribute('data-item');
            if (!key) {
                return;
            }
            descTabItems.forEach(function (t) {
                var isActive = t === tab;
                t.classList.toggle('active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            showDescTab(key);
        });
    });

    var initial = document.querySelector('.product-detail .desc-tab .menu-tab .tab-item.active[data-item]');
    if (initial) {
        showDescTab(initial.getAttribute('data-item'));
    }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\edx\resources\views/frontend/product.blade.php ENDPATH**/ ?>