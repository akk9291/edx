<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($product->display_name); ?> — EDX</title>
    <style>
        @page { margin: 28px 36px 32px 36px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            margin: 0;
        }
        .pdf-header {
            background: #e31e24;
            color: #fff;
            padding: 10px 14px;
            margin: -8px -8px 14px -8px;
        }
        .pdf-header-inner { width: 100%; border-collapse: collapse; }
        .pdf-header-inner td { vertical-align: middle; }
        .pdf-header .pdf-logo-link {
            display: inline-block;
            text-decoration: none;
            border: 0;
            line-height: 0;
        }
        .pdf-header img { height: 36px; display: block; }
        .pdf-header-title {
            font-size: 13px;
            font-weight: bold;
            text-align: right;
            letter-spacing: 0.04em;
        }
        .pdf-header a.pdf-header-title-link {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .pdf-main-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 6px 0;
        }
        a.pdf-product-title-link {
            color: #1a1a1a;
            text-decoration: none;
        }
        .pdf-cat {
            display: inline-block;
            background: #16a34a;
            color: #fff;
            padding: 3px 10px;
            font-size: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .pdf-top { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .pdf-top td { vertical-align: top; }
        .pdf-top .img-cell { width: 42%; padding-right: 12px; }
        .pdf-top img.product-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #e5e5e5;
        }
        .pdf-desc { color: #444; line-height: 1.45; }
        .pdf-desc p { margin: 0 0 8px 0; }
        .pdf-desc p:last-child { margin-bottom: 0; }
        .pdf-desc ul, .pdf-desc ol { margin: 0 0 8px 0; padding-left: 1.2em; }
        .section-label {
            background: #e31e24;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            display: inline-block;
            margin: 14px 0 8px 0;
        }
        .spec-grid { width: 100%; border-collapse: collapse; }
        .spec-grid td { width: 50%; vertical-align: top; padding: 0 8px 0 0; }
        .spec-grid td + td { padding: 0 0 0 8px; }
        .spec-title { font-size: 11px; font-weight: bold; margin: 0 0 6px 0; }
        .spec-table { width: 100%; border-collapse: collapse; }
        .spec-table tr { border-bottom: 1px solid #ccc; }
        /* DomPDF: baseline + mixed font-weights misaligns label vs value; middle + one line-height fixes row alignment */
        .spec-table td {
            padding: 6px 0;
            font-size: 10px;
            line-height: 1.35;
            vertical-align: middle;
            font-weight: normal;
        }
        .spec-table td.spec-value {
            text-align: right;
            font-weight: bold;
            white-space: nowrap;
        }
        .pdf-footer {
            margin-top: 22px;
            background: #0f0f0f;
            color: #fff;
            padding: 14px 16px;
            font-size: 9px;
        }
        .pdf-footer table { width: 100%; border-collapse: collapse; }
        .pdf-footer td { vertical-align: top; padding: 4px 8px; width: 33%; }
        .pdf-footer h4 {
            margin: 0 0 6px 0;
            font-size: 10px;
            color: #fff;
        }
        .pdf-footer ul { margin: 0; padding-left: 14px; }
        .pdf-footer li { margin: 2px 0; }
        .pdf-footer a { color: #ccc; text-decoration: none; }
        .pdf-footer a.pdf-logo-link {
            display: inline-block;
            line-height: 0;
            border: 0;
        }
        .pdf-footer a.pdf-footer-block-link {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .pdf-footer a.pdf-footer-bottom-link {
            color: #aaa;
            text-decoration: none;
        }
        .pdf-footer .pdf-brand-logo {
            width: 56px;
            height: auto;
            display: block;
        }
        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 10px;
            padding-top: 8px;
            text-align: center;
            color: #aaa;
            font-size: 8px;
        }
    </style>
</head>
<body>
<?php
    $specs = [];
    if (!($product instanceof \App\Models\PillowBlock)) {
        $specs = $product->specifications;
        if (is_string($specs)) {
            $specs = json_decode($specs, true);
        }
        $specs = is_array($specs) ? $specs : [];
    }
    $pdfSiteUrl = rtrim((string) config('app.url'), '/');
    $pdfProductUrl = ($product->slug ?? '') !== ''
        ? $pdfSiteUrl.'/product/'.$product->slug
        : $pdfSiteUrl;
?>

<div class="pdf-header">
    <table class="pdf-header-inner">
        <tr>
            <td style="width: 50%;">
                <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-logo-link">
                    <?php if($pdfLogoSrc !== ''): ?>
                        <img src="<?php echo e($pdfLogoSrc); ?>" alt="EDX">
                    <?php else: ?>
                        <span style="font-size: 18px; font-weight: bold;">EDX</span>
                    <?php endif; ?>
                </a>
            </td>
            <td class="pdf-header-title">
                <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-header-title-link">EDX RULMENTI ROMANIA S.R.L.</a>
            </td>
        </tr>
    </table>
</div>

<table class="pdf-top">
    <tr>
        <td class="img-cell">
            <?php if($pdfProductImageSrc !== ''): ?>
                <img class="product-img" src="<?php echo e($pdfProductImageSrc); ?>" alt="">
            <?php endif; ?>
        </td>
        <td>
            <div class="pdf-main-title">
                <a href="<?php echo e($pdfProductUrl); ?>" class="pdf-product-title-link"><?php echo e($product->display_name); ?></a>
            </div>
            <div class="pdf-cat"><?php echo e($product->category->name ?? 'Deep Groove Ball Bearing'); ?></div>
            <div class="pdf-desc"><?php echo $product->description ?? ''; ?></div>
        </td>
    </tr>
</table>

<div class="section-label">OVERVIEW</div>

<?php if($product instanceof \App\Models\PillowBlock): ?>
<table class="spec-grid">
    <tr>
        <td>
            <div class="spec-title">Product specifications</div>
            <table class="spec-table">
                <tr>
                    <td valign="middle">Bearing number</td>
                    <td class="spec-value" valign="middle"><?php echo e($product->bearing_number ?? '—'); ?></td>
                </tr>
                <?php
                    $specsList = $product->specifications ?? [];
                    $half = max(1, (int)ceil(count($specsList) / 2));
                    $leftSpecs = array_slice($specsList, 0, $half);
                    $rightSpecs = array_slice($specsList, $half);
                ?>
                <?php $__currentLoopData = $leftSpecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td valign="middle">
                            <?php echo e($spec['title'] ?? 'Specification'); ?>

                            <?php if(!empty($spec['dimension'])): ?>
                                (<?php echo e($spec['dimension']); ?>)
                            <?php endif; ?>
                        </td>
                        <td class="spec-value" valign="middle"><?php echo e($spec['value'] ?? '—'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </td>
        <td>
            <?php if(!empty($rightSpecs)): ?>
            <div class="spec-title">&nbsp;</div>
            <table class="spec-table">
                <?php $__currentLoopData = $rightSpecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td valign="middle">
                            <?php echo e($spec['title'] ?? 'Specification'); ?>

                            <?php if(!empty($spec['dimension'])): ?>
                                (<?php echo e($spec['dimension']); ?>)
                            <?php endif; ?>
                        </td>
                        <td class="spec-value" valign="middle"><?php echo e($spec['value'] ?? '—'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php else: ?>
<table class="spec-grid">
    <tr>
        <td>
            <div class="spec-title">Boundary dimensions</div>
            <table class="spec-table">
                <tr><td valign="middle">Bore diameter</td><td class="spec-value" valign="middle"><?php echo e($specs['bore_diameter'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Outside diameter</td><td class="spec-value" valign="middle"><?php echo e($specs['outside_diameter'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Width</td><td class="spec-value" valign="middle"><?php echo e($specs['width'] ?? '—'); ?></td></tr>
            </table>
        </td>
        <td>
            <div class="spec-title">Performance</div>
            <table class="spec-table">
                <tr><td valign="middle">Basic dynamic load rating</td><td class="spec-value" valign="middle"><?php echo e($specs['dynamic_load_rating'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Basic static load rating</td><td class="spec-value" valign="middle"><?php echo e($specs['static_load_rating'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Limiting speed – Grease</td><td class="spec-value" valign="middle"><?php echo e($specs['limiting_speed_grease'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Limiting speed – Oil</td><td class="spec-value" valign="middle"><?php echo e($specs['limiting_speed_oil'] ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 10px;">
            <div class="spec-title">Properties</div>
            <table class="spec-table">
                <tr><td valign="middle">Number of rows</td><td class="spec-value" valign="middle"><?php echo e($specs['number_of_rows'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Bore type</td><td class="spec-value" valign="middle"><?php echo e($specs['bore_type'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Cage</td><td class="spec-value" valign="middle"><?php echo e($specs['cage'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Radial internal clearance</td><td class="spec-value" valign="middle"><?php echo e($specs['radial_clearance'] ?? '—'); ?></td></tr>
                <tr><td valign="middle">Tolerance class for dimensions</td><td class="spec-value" valign="middle"><?php echo e($specs['tolerance_class'] ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>
</table>
<?php endif; ?>

<div class="pdf-footer">
    <table>
        <tr>
            <td style="vertical-align: top; width: 64px;">
                <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-logo-link">
                    <?php if($pdfLogoSrc !== ''): ?>
                        <img src="<?php echo e($pdfLogoSrc); ?>" alt="EDX Rulmenți" class="pdf-brand-logo">
                    <?php else: ?>
                        <div style="background:#e31e24;color:#fff;width:56px;height:56px;text-align:center;padding:6px 4px;font-weight:bold;line-height:1.1;font-size:14px;">EDX</div>
                    <?php endif; ?>
                </a>
            </td>
            <td>
                <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-footer-block-link">
                    <h4>Get in touch</h4>
                    <div>Sediu social: Bucuresti Sectorul 4,<br>Bulevardul METALURGIEI, Nc 132, Bloc BIC, Etaj 4, Ap. 42.</div>
                    <div style="margin-top: 4px;">+40 723 370 345</div>
                    <div>info@edxromania.ro</div>
                </a>
            </td>
            <td>
                <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-footer-block-link">
                    <h4>Products &amp; services</h4>
                    <ul>
                        <li>Ball Bearing</li>
                        <li>Spherical Roller Bearing</li>
                        <li>Cylindrical Roller Bearing</li>
                        <li>Taper Roller Bearing</li>
                    </ul>
                </a>
            </td>
        </tr>
    </table>
    <div class="footer-bottom">
        <a href="<?php echo e($pdfSiteUrl); ?>" class="pdf-footer-bottom-link"><?php echo e(date('Y')); ?> © All Rights Reserved by Edx Rulmenti Romania S.R.L.</a>
    </div>
</div>
</body>
</html>
<?php /**PATH F:\laragon\www\edx\resources\views/pdf/product-specification.blade.php ENDPATH**/ ?>