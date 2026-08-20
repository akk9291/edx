<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'EDX Rulmenti Romania S.R.L.'); ?></title>
    <?php echo $__env->yieldPushContent('meta'); ?>
    <link rel="icon" href="<?php echo e(asset('assets/images/EDX-LOGO-RULMENTI.png')); ?>" type="image/png">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/EDX-LOGO-RULMENTI.png')); ?>" type="image/png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/swiper-bundle.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/output-scss.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/output-tailwind.css')); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .spec-table {
            width: 100%;
            border-collapse: collapse;
        }
        .spec-table tr {
            border-bottom: 1px solid #ccc;
        }
        .spec-table td {
            padding: 12px 0;
            font-size: 14px;
        }
        .spec-table td:last-child {
            text-align: right;
        }
        .properties-section {
            grid-column: 1 / 2;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .properties-section {
                margin-top: 20px;
            }
        }
        
        /* Footer Styles */
        .footer {
            background-color: #0f0f0f;
            color: #ffffff;
            padding: 104px 0 0px;
            font-family: Muli, sans-serif;
        }
        .footer-container {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
        }
        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 30px;
            padding: 0 15px;
        }
        .logo-box {
            background-color: #e31e24;
            width: 150px;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }
        .logo-text {
            font-size: 50px;
            line-height: 1;
        }
        .logo-subtext {
            font-size: 14px;
            letter-spacing: 2px;
        }
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .footer-column ul {
            list-style: none;
        }
        .footer-column ul li {
            margin-bottom: 16px;
            position: relative;
            padding-left: 15px;
        }
        .footer-column ul li::before {
            content: "■";
            color: #e31e24;
            font-size: 10px;
            position: absolute;
            left: 0;
            top: 2px;
        }
        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-column ul li a:hover {
            color: #fff;
        }
        .copyright {
            color: #ccc;
            font-size: 14px;
            font-family: Roboto, sans-serif;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: #aaa;
        }
        .contact-item i {
            color: #e31e24;
            margin-right: 15px;
            margin-top: 5px;
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0;
            padding: 20px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #888;
            font-size: 14px;
        }
        .social-links {
            display: flex;
            gap: 10px;
        }
        .social-links a {
            background-color: #e31e24;
            color: white;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            border-radius: 2px;
            transition: opacity 0.3s;
        }
        .social-links a:hover {
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
            }
            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
        }

        #top-nav .header-main {
            align-items: center;
        }
        /* Mobile header: keep menu + logo left-aligned; desktop unchanged (display:contents passes children to .header-main flex) */
        #top-nav .edx-header-brand-cluster {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
            min-width: 0;
        }
        @media (min-width: 1024px) {
            #top-nav .edx-header-brand-cluster {
                display: contents;
            }
        }
        
        /* Product item styles */
        .edxpro {
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 20px;
        }
        /* Catalogue list rows: web markup unchanged — mobile fixes only via this query */
        @media (min-width: 768px) {
            .list-product .product-item.list-type .product-main .product-infor {
                position: relative;
                width: 60%;
                border-right: 1px solid #ccc;
                padding-right: 20px;
            }
            .list-product .product-item.list-type .product-main .action {
                padding-left: 20px;
            }
        }
        @media (max-width: 767.98px) {
            .shop-product.breadcrumb1 {
                overflow-x: hidden;
            }
            .list-product .product-item.list-type.edxpro {
                padding: 12px;
            }
            .list-product .product-item.list-type .product-main {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .list-product .product-item.list-type .product-main > a {
                flex-direction: column !important;
                align-items: center !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .list-product .product-item.list-type .product-thumb {
                width: auto !important;
                max-width: 100%;
            }
            .list-product .product-item.list-type .product-thumb img {
                width: auto !important;
                max-width: min(200px, 100%) !important;
                height: auto !important;
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .list-product .product-item.list-type .product-main .product-infor {
                width: 100% !important;
                max-width: 100%;
                border-right: none !important;
                padding-right: 0 !important;
                text-align: center;
            }
            .list-product .product-item.list-type .product-price-block {
                justify-content: center;
            }
            .list-product .product-item.list-type .product-main .action {
                width: 100% !important;
                max-width: 100%;
                padding-left: 0 !important;
                align-items: stretch !important;
                border-top: 1px solid #e5e5e5;
                padding-top: 0.75rem;
                margin-top: 0.25rem;
            }
        }
        .list-pagination button {
            width: 40px;
            height: 40px;
            border: 1px solid #ccc;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s;
        }
        .list-pagination button:hover,
        .list-pagination button.active {
            background: #e31e24;
            color: #fff;
            border-color: #e31e24;
        }
        .bg-green {
            background-color: #22c55e !important;
            color: #fff !important;
        }

        /* Original list price — built Tailwind bundle omits .line-through in this project */
        .edx-mrp-strike {
            text-decoration: line-through;
            -webkit-text-decoration-line: line-through;
            text-decoration-line: line-through;
            text-decoration-thickness: 1px;
        }

        /* "Add to quote" — red CTA (product, range, home) */
        .edx-btn-add-quote {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            min-height: 3rem;
            padding: 0.75rem 1.25rem;
            font-size: 0.8125rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fff !important;
            background-color: #c8102e;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: filter 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }
        .edx-btn-add-quote:hover {
            filter: brightness(0.95);
        }
        .edx-btn-add-quote:focus-visible {
            outline: 2px solid #ec2127;
            outline-offset: 3px;
        }
        .edx-btn-add-quote:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            filter: none;
        }
        .edx-btn-add-quote .ph {
            color: #fff !important;
            font-size: 1.25rem;
        }
        .edx-btn-add-quote--compact {
            min-height: 2.625rem;
            min-width: 10rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.6875rem;
            border-radius: 9999px;
            letter-spacing: 0.06em;
        }
        .edx-btn-add-quote--compact .ph {
            font-size: 1rem;
        }

        /* Large search card (home / range) — ~modal size, pill field, popular chips */
        .has-search-card {
            display: flex;
            justify-content: center;
        }
        .catalog-top-search .edx-search-card {
            width: 100%;
            max-width: min(80vw, 32rem);
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 20px 40px -12px rgba(0, 0, 0, 0.12);
            border: 1px solid #f0f0f0;
            padding: 1.5rem 1.5rem 1.25rem;
            text-align: left;
            box-sizing: border-box;
        }
        @media (min-width: 640px) {
            .catalog-top-search .edx-search-card {
                max-width: min(80vw, 40rem);
                padding: 1.75rem 1.75rem 1.5rem;
            }
        }
        @media (min-width: 1024px) {
            .catalog-top-search .edx-search-card {
                max-width: min(80vw, 48rem);
                border-radius: 1.5rem;
            }
        }
        @media (min-width: 1280px) {
            .catalog-top-search .edx-search-card {
                max-width: min(75vw, 56rem);
            }
        }
        .catalog-top-search .edx-search-pill-form {
            margin: 0;
        }
        .catalog-top-search .edx-search-pill-row {
            display: flex;
            align-items: center;
            min-height: 3.25rem;
            border: 1px solid #e4e4e7;
            border-radius: 9999px;
            background: #fff;
            overflow: hidden;
            box-sizing: border-box;
        }
        .catalog-top-search .edx-search-pill-row:focus-within {
            border-color: #a1a1aa;
            box-shadow: 0 0 0 1px #d4d4d8;
        }
        .catalog-top-search .edx-search-pill-input {
            flex: 1 1 0;
            min-width: 0;
            border: 0;
            background: transparent;
            font-size: 0.95rem;
            color: #18181b;
            padding: 0.65rem 0.75rem 0.65rem 1.25rem;
        }
        .catalog-top-search .edx-search-pill-input::placeholder {
            color: #9ca3af;
        }
        .catalog-top-search .edx-search-pill-input:focus {
            outline: none;
        }
        .catalog-top-search .edx-search-pill-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 3.25rem;
            height: 3.25rem;
            border: 0;
            background: #fafafa;
            color: #52525b;
            cursor: pointer;
        }
        .catalog-top-search .edx-search-pill-btn:hover {
            color: #18181b;
            background: #f4f4f5;
        }
        .catalog-top-search .edx-search-pill-btn .ph {
            font-size: 1.35rem;
        }
        .catalog-top-search input[type="search"]::-webkit-search-decoration,
        .catalog-top-search input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
        }

        /* Non-card compact search (fallback) */
        .catalog-top-search .edx-search-field-wrap {
            border-color: #e4e4e7;
        }
        .catalog-top-search .edx-search-submit {
            border: 1px solid #e4e4e7;
            border-left: 0;
            background: #e4e4e7;
            color: #27272a;
        }
        .catalog-top-search .edx-search-submit:hover {
            background: #d4d4d8;
        }
        .catalog-top-search .edx-search-input:focus {
            outline: none;
            box-shadow: none;
        }

        /* Quota list count badge (explicit CSS — Tailwind build does not scan Blade files) */
        .header-menu .list-action,
        .header-menu .quota-bag-link,
        .header-menu .quota-header-bag,
        .menu_bar .quota-bag-inner {
            overflow: visible;
        }
        .quota-bag-link,
        .header-menu .quota-header-bag {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 20px 8px 10px;
            min-width: 44px;
            min-height: 44px;
            z-index: 20;
            pointer-events: auto;
        }
        .cart-quota-badge {
            position: absolute;
            top: 2px;
            right: 4px;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.02em;
            color: #fff;
            background-color: #ec2127;
            border-radius: 999px;
            box-shadow: 0 0 0 2px #fff;
            z-index: 2;
            pointer-events: none;
            font-variant-numeric: tabular-nums;
        }
        .cart-quota-badge.cart-quota-badge--empty {
            background-color: #1f1f1f;
            opacity: 0.55;
        }
        .menu_bar .quota-bag-inner {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 14px 4px 4px;
        }
        .menu_bar .cart-quota-badge {
            top: -2px;
            right: 2px;
        }

        /*
         * Quota modal: Blade is not in tailwind.config content — arbitrary utilities like z-[200]
         * are often missing from output-tailwind.css, so the overlay rendered behind the page.
         * These rules fix stacking + card visibility without relying on generated Tailwind.
         */
        #edx-quota-modal {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 99990;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        #edx-quota-modal .edx-quota-modal-shell {
            position: relative;
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
        }
        @media (min-width: 640px) {
            #edx-quota-modal .edx-quota-modal-shell {
                padding: 1.25rem;
            }
        }
        #edx-quota-modal .edx-quota-modal-backdrop {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 0;
            background: rgba(0, 0, 0, 0.55);
        }
        #edx-quota-modal .edx-quota-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: min(28rem, calc(100vw - 1.5rem));
            max-height: min(42rem, 92vh);
            margin: 0 auto;
            border-radius: 1rem;
            background: #fff;
            border: 1px solid #e9e9e9;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        #edx-quota-modal .edx-quota-card-aside {
            order: 2;
            display: none;
            flex-direction: column;
            min-height: 0;
            min-width: 0;
            background: #fafaf9;
            border-top: 1px solid #e9e9e9;
        }
        #edx-quota-modal .edx-quota-card-main {
            order: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            min-width: 0;
        }
        @media (min-width: 768px) {
            #edx-quota-modal .edx-quota-card {
                flex-direction: row;
                align-items: stretch;
                max-width: min(71rem, calc(100vw - 1.5rem));
                max-height: min(38rem, 92vh);
            }
            #edx-quota-modal .edx-quota-card-aside {
                display: flex;
                flex: 1.15 1 0%;
                order: 1;
                border-top: 0;
                border-right: 1px solid #e9e9e9;
            }
            #edx-quota-modal .edx-quota-card-main {
                flex: 0.85 1 0%;
                order: 2;
                min-width: 300px;
            }
        }

        /* Quota modal footer CTAs — layout does not rely on Tailwind scanning Blade */
        #edx-quota-modal .edx-quota-modal-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1rem 1.25rem 1.25rem;
            background: #f5f5f4;
            border-top: 1px solid #e9e9e9;
            flex-shrink: 0;
        }
        #edx-quota-modal .edx-quota-modal-checkout,
        #edx-quota-modal .edx-quota-modal-viewlist {
            display: inline-flex;
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 1.25rem;
            font-size: 0.8125rem;
            font-weight: 700;
            letter-spacing: 0.055em;
            text-transform: uppercase;
            text-decoration: none;
            text-align: center;
            line-height: 1.35;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease,
                box-shadow 0.2s ease, transform 0.15s ease;
        }
        #edx-quota-modal .edx-quota-modal-checkout {
            color: #fff;
            background: #ec2127;
            border: 2px solid #ec2127;
            box-shadow: 0 2px 10px rgba(236, 33, 39, 0.28);
        }
        #edx-quota-modal .edx-quota-modal-checkout:hover {
            background: #c41e22;
            border-color: #c41e22;
            box-shadow: 0 4px 16px rgba(196, 30, 34, 0.38);
            transform: translateY(-1px);
        }
        #edx-quota-modal .edx-quota-modal-checkout:focus-visible {
            outline: 2px solid #1f1f1f;
            outline-offset: 3px;
        }
        #edx-quota-modal .edx-quota-modal-checkout:active {
            transform: translateY(0);
        }
        #edx-quota-modal .edx-quota-modal-viewlist {
            color: #1f1f1f;
            background: #fff;
            border: 2px solid #1f1f1f;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }
        #edx-quota-modal .edx-quota-modal-viewlist:hover {
            background: #fafafa;
            border-color: #0a0a0a;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        #edx-quota-modal .edx-quota-modal-viewlist:focus-visible {
            outline: 2px solid #ec2127;
            outline-offset: 3px;
        }
        #edx-quota-modal .edx-quota-modal-viewlist:active {
            transform: translateY(0);
        }
        #edx-quota-modal button.edx-quota-modal-close {
            width: 2.25rem;
            height: 2.25rem;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            border: 1px solid #e9e9e9;
            background: #fff;
            color: #696c70;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }
        #edx-quota-modal button.edx-quota-modal-close:hover {
            background: #fafafa;
            border-color: #d4d4d4;
            color: #1f1f1f;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        }
        #edx-quota-modal button.edx-quota-modal-close:focus-visible {
            outline: 2px solid #ec2127;
            outline-offset: 2px;
        }

        /* EDX — light polish across all frontend pages */
        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }
        }

        main {
            -webkit-font-smoothing: antialiased;
        }

        main img {
            max-width: 100%;
            height: auto;
        }

        ::selection {
            background-color: rgba(236, 33, 39, 0.22);
            color: inherit;
        }

        .breadcrumb-block .link a {
            text-decoration: underline;
            text-underline-offset: 3px;
            text-decoration-color: rgba(255, 255, 255, 0.4);
            transition: text-decoration-color 0.2s ease, opacity 0.2s ease;
        }

        .breadcrumb-block .link a:hover {
            text-decoration-color: #fff;
        }

        .spec-table tr {
            border-bottom-color: #e5e5e5;
        }

        main a:focus-visible,
        main button:focus-visible,
        main input:focus-visible,
        main textarea:focus-visible,
        main select:focus-visible {
            outline: 2px solid #ec2127;
            outline-offset: 2px;
        }

        .product-item.edxpro {
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .product-item.edxpro:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
            border-color: #c8c8c8;
        }

        .list-pagination a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            min-height: 2.5rem;
            padding: 0 0.35rem;
            border-radius: 0.35rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .list-pagination a:hover {
            background-color: rgba(236, 33, 39, 0.08);
            color: #ec2127;
        }

        .sidebar .filter-type-block .item.tab-item {
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
        }

        .sidebar .filter-type-block .item.tab-item:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .sidebar .filter-type-block .item.tab-item.active {
            background-color: rgba(236, 33, 39, 0.06);
        }
    </style>
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    
    <div class="cart-icon" aria-hidden="true" tabindex="-1" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">
        <span>0</span>
    </div>
    <!-- Header -->
    <?php echo $__env->make('frontend.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Scroll to Top -->
    <a class="scroll-to-top-btn" href="#top-nav"><i class="ph-bold ph-caret-up"></i></a>
    
    <!-- Quota list quick view (header bag) — wide two-column layout like storefront cart drawer -->
    <div id="edx-quota-modal" class="edx-quota-modal-root" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="edx-quota-modal-title" aria-hidden="true">
        <div class="edx-quota-modal-shell">
            <div class="edx-quota-modal-backdrop" data-quota-modal-close tabindex="-1" aria-hidden="true"></div>
            <div class="edx-quota-card">
                <aside class="edx-quota-card-aside border-line bg-stone-50">
                    <div class="px-5 pt-4 pb-2 shrink-0 border-b border-line/80 bg-stone-50">
                        <h3 class="heading6 text-black mb-0 tracking-tight">You may also like</h3>
                        <p class="caption1 text-secondary mt-1 mb-0">More bearings from our catalogue</p>
                    </div>
                    <div id="edx-quota-modal-suggestions" class="flex-1 overflow-y-auto px-5 py-4 pb-8 min-h-[8rem]" style="padding-bottom: 32px;">
                        <p class="text-secondary caption1 mb-0">Loading…</p>
                    </div>
                </aside>
                <div class="edx-quota-card-main bg-white">
                    <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-line bg-white shrink-0">
                        <h2 id="edx-quota-modal-title" class="heading6 mb-0">Quota list</h2>
                        <button type="button" class="edx-quota-modal-close" data-quota-modal-close aria-label="Close">
                            <i class="ph ph-x text-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div id="edx-quota-modal-body" class="flex-1 overflow-y-auto px-5 py-4 text-sm bg-white min-h-[6rem]">
                        <p class="text-secondary mb-0">Loading…</p>
                    </div>
                    <div class="edx-quota-modal-actions">
                        <a id="edx-quota-modal-cta" href="<?php echo e(route('frontend.quota-list.index')); ?>#request-quotation" class="edx-quota-modal-checkout">
                            Send quotation request
                        </a>
                        <a id="edx-quota-modal-secondary" href="<?php echo e(route('frontend.quota-list.index')); ?>" class="edx-quota-modal-viewlist">
                            View full list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Files -->
    <script src="<?php echo e(asset('assets/js/phosphor-icons.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    <script>
    (function () {
        function csrfToken() {
            var el = document.querySelector('meta[name="csrf-token"]');
            return el ? el.getAttribute('content') : '';
        }
        function setQuotaBadge(count) {
            var raw = Math.max(0, parseInt(count, 10) || 0);
            var label = raw > 99 ? '99+' : String(raw);
            document.querySelectorAll('.cart-quota-badge').forEach(function (badge) {
                badge.textContent = label;
                badge.classList.toggle('cart-quota-badge--empty', raw === 0);
            });
        }
        function refreshQuotaBadge() {
            fetch('<?php echo e(route('frontend.quota-list.count')); ?>', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function (r) { return r.json(); }).then(function (data) {
                if (data && typeof data.count !== 'undefined') {
                    setQuotaBadge(data.count);
                }
            }).catch(function () {});
        }
        document.addEventListener('DOMContentLoaded', refreshQuotaBadge);
        // Capture phase: theme main.js binds bubble listeners on .product-item (redirect)
        // and .quick-shop-btn (stopPropagation + missing .quick-shop-block throws). Run first.
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.edx-add-quota-btn');
            if (!btn) {
                return;
            }
            e.preventDefault();
            e.stopPropagation();
            var productId = btn.getAttribute('data-product-id');
            var productType = btn.getAttribute('data-product-type') || 'product';
            if (!productId) {
                return;
            }
            var scope = btn.closest('.product-item') || btn.closest('.product-detail');
            var qtyEl = scope ? scope.querySelector('#qty-value') : document.getElementById('qty-value');
            var qty = 1;
            if (qtyEl) {
                var raw = (typeof qtyEl.value === 'string') ? qtyEl.value : (qtyEl.textContent || qtyEl.innerText || '');
                qty = Math.max(1, Math.min(99999, parseInt(String(raw).trim(), 10) || 1));
            }
            var labelEl = btn.querySelector('.edx-quota-btn-label') || btn;
            var prev = (labelEl.textContent || '').trim();
            btn.disabled = true;
            fetch('<?php echo e(route('frontend.quota-list.add')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: parseInt(productId, 10), quantity: qty, product_type: productType })
            }).then(function (res) {
                if (res.status === 419) {
                    return { ok: false, isCsrf: true };
                }
                return res.json().then(function (body) {
                    return { ok: res.ok, body: body };
                });
            }).then(function (result) {
                if (result.isCsrf) {
                    alert('Session expired. Reloading page...');
                    window.location.reload();
                    return;
                }
                if (result.body && typeof result.body.count !== 'undefined') {
                    setQuotaBadge(result.body.count);
                }
                if (result.ok) {
                    labelEl.textContent = 'Added';
                    setTimeout(function () {
                        labelEl.textContent = prev;
                    }, 1600);
                } else {
                    var errMsg = (result.body && result.body.message) ? result.body.message : 'Could not add to quota list.';
                    if (result.body && result.body.errors) {
                        var keys = Object.keys(result.body.errors);
                        if (keys.length && result.body.errors[keys[0]][0]) {
                            errMsg = result.body.errors[keys[0]][0];
                        }
                    }
                    window.alert(errMsg);
                }
            }).catch(function () {
                window.alert('Could not add to quota list. Please try again.');
            }).finally(function () {
                btn.disabled = false;
            });
        }, true);

        var quotaModal = document.getElementById('edx-quota-modal');
        var quotaModalBody = document.getElementById('edx-quota-modal-body');
        var quotaModalCta = document.getElementById('edx-quota-modal-cta');
        var quotaModalSecondary = document.getElementById('edx-quota-modal-secondary');
        var quotaModalSuggestions = document.getElementById('edx-quota-modal-suggestions');
        var quotaPreviewUrl = '<?php echo e(route('frontend.quota-list.preview')); ?>';
        var quotaListUrl = '<?php echo e(route('frontend.quota-list.index')); ?>';
        var quotaRangeUrl = '<?php echo e(route('frontend.range')); ?>';

        function escQuota(s) {
            if (s === null || s === undefined) {
                return '';
            }
            var d = document.createElement('div');
            d.textContent = String(s);
            return d.innerHTML;
        }

        var EDX_QUOTA_DEBUG = true;

        function logQuotaModal(phase, extra) {
            if (!EDX_QUOTA_DEBUG || typeof console === 'undefined' || !console.log) {
                return;
            }
            if (!quotaModal) {
                console.warn('[EDX quota]', phase, 'missing #edx-quota-modal');
                return;
            }
            var cs = window.getComputedStyle(quotaModal);
            var r = quotaModal.getBoundingClientRect();
            var card = quotaModal.querySelector('.edx-quota-card');
            var crc = card ? card.getBoundingClientRect() : null;
            console.log('[EDX quota]', phase, {
                display: cs.display,
                zIndex: cs.zIndex,
                visibility: cs.visibility,
                opacity: cs.opacity,
                modalRect: { w: Math.round(r.width), h: Math.round(r.height) },
                cardRect: crc ? { w: Math.round(crc.width), h: Math.round(crc.height) } : null,
                ariaHidden: quotaModal.getAttribute('aria-hidden'),
            }, extra || {});
        }

        function setQuotaModalOpen(open) {
            if (!quotaModal) {
                return;
            }
            quotaModal.style.setProperty('display', open ? 'block' : 'none', 'important');
            quotaModal.setAttribute('aria-hidden', open ? 'false' : 'true');
            document.body.style.overflow = open ? 'hidden' : '';
            document.querySelectorAll('.quota-bag-open').forEach(function (b) {
                b.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            logQuotaModal(open ? 'modal open' : 'modal close');
        }

        function isQuotaModalVisible() {
            return quotaModal && quotaModal.getAttribute('aria-hidden') === 'false';
        }

        var lastQuotaOpener = null;

        function normalizeEventTarget(t) {
            if (t && t.nodeType === 3 && t.parentElement) {
                return t.parentElement;
            }
            return t;
        }

        function closeQuotaModal() {
            setQuotaModalOpen(false);
            if (lastQuotaOpener && typeof lastQuotaOpener.focus === 'function') {
                try {
                    lastQuotaOpener.focus();
                } catch (err) {
                    /* ignore */
                }
            }
            lastQuotaOpener = null;
        }

        function renderSuggestionCards(suggestions) {
            if (!quotaModalSuggestions) {
                return;
            }
            var list = suggestions && suggestions.length ? suggestions : [];
            if (!list.length) {
                quotaModalSuggestions.innerHTML = '<p class="text-secondary caption1 mb-0">Explore the <a href="' + quotaRangeUrl + '" class="text-black font-semibold underline">product range</a> to add bearings.</p>';
                return;
            }
            var cards = list.map(function (p) {
                var url = '/product/' + encodeURIComponent(p.slug);
                var thumb = p.image_url
                    ? '<img src="' + escQuota(p.image_url) + '" alt="" class="object-contain" style="max-height: 80px;" loading="lazy">'
                    : '<div class="flex h-full w-full items-center justify-center text-stone-400"><i class="ph ph-package text-2xl" aria-hidden="true"></i></div>';
                
                var cleanName = p.name || '';
                var skuVal = (p.sku || '').trim();
                if (skuVal && cleanName.endsWith(skuVal)) {
                    cleanName = cleanName.substring(0, cleanName.length - skuVal.length).trim();
                }

                return '<a href="' + url + '" class="group flex flex-col overflow-hidden rounded-xl border border-line bg-white no-underline text-inherit shadow-sm transition-all duration-300 hover:shadow-md hover:border-red-600">' +
                    '<div class="bg-white p-2 flex items-center justify-center border-b border-line/60" style="padding: 8px; height: 100px;">' + thumb + '</div>' +
                    '<div class="flex-1 flex flex-col justify-between" style="padding: 8px 10px 10px 10px;">' +
                    '<div>' +
                    '<div class="text-sm font-bold text-red-600 leading-tight" style="margin-bottom: 2px;">' + escQuota(skuVal || 'Product') + '</div>' +
                    '<div class="text-xs text-stone-600 leading-snug line-clamp-2" style="font-size: 11px; line-height: 1.3;">' + escQuota(cleanName) + '</div>' +
                    '</div>' +
                    '</div></a>';
            }).join('');
            quotaModalSuggestions.innerHTML = '<div class="grid grid-cols-2 sm:grid-cols-3 gap-2">' + cards + '</div>';
        }

        function renderQuotaModal(data) {
            if (!quotaModalBody) {
                return;
            }
            renderSuggestionCards(data && data.suggestions ? data.suggestions : []);

            if (!data || data.empty || !data.items || data.items.length === 0) {
                quotaModalBody.innerHTML = '<p class="text-secondary leading-relaxed">Your quota list is empty. Add products from the range, then send a quotation request.</p>';
                if (quotaModalCta) {
                    quotaModalCta.classList.remove('pointer-events-none', 'opacity-50');
                    quotaModalCta.removeAttribute('aria-disabled');
                    quotaModalCta.href = quotaRangeUrl;
                    quotaModalCta.textContent = 'Browse product range';
                }
                if (quotaModalSecondary) {
                    quotaModalSecondary.href = quotaListUrl;
                    quotaModalSecondary.textContent = 'Open quota list';
                }
                return;
            }
            if (quotaModalCta) {
                quotaModalCta.classList.remove('pointer-events-none', 'opacity-50');
                quotaModalCta.removeAttribute('aria-disabled');
                quotaModalCta.href = quotaListUrl + '#request-quotation';
                quotaModalCta.textContent = 'Send quotation request';
            }
            if (quotaModalSecondary) {
                quotaModalSecondary.href = quotaListUrl;
                quotaModalSecondary.textContent = 'View full list';
            }
            var n = data.items.length;
            var rows = data.items.map(function (it) {
                var url = '/product/' + encodeURIComponent(it.slug);
                var thumb = it.image_url
                    ? '<div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-line bg-stone-100"><img src="' + escQuota(it.image_url) + '" alt="" class="h-full w-full object-contain" loading="lazy"></div>'
                    : '<div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-lg border border-line bg-stone-100 text-stone-400"><i class="ph ph-package text-xl" aria-hidden="true"></i></div>';
                return '<div class="flex gap-3 border-b border-line py-3 last:border-0">' +
                    thumb +
                    '<div class="min-w-0 flex-1">' +
                    '<a href="' + url + '" class="block text-sm font-semibold leading-snug text-black hover:underline">' + escQuota(it.sku || it.name) + '</a>' +
                    (it.category ? '<div class="caption1 mt-0.5 text-secondary">' + escQuota(it.category) + '</div>' : '') +
                    '</div>' +
                    '<div class="shrink-0 pt-0.5 text-sm font-semibold tabular-nums text-black">× ' + escQuota(String(it.quantity)) + '</div>' +
                    '</div>';
            }).join('');
            quotaModalBody.innerHTML =
                '<div class="mb-3 flex items-end justify-between gap-2 border-b border-line pb-2">' +
                '<span class="caption1 font-semibold uppercase tracking-wide text-secondary">Items</span>' +
                '<span class="text-sm font-bold text-black">' + n + ' line' + (n === 1 ? '' : 's') + '</span>' +
                '</div>' +
                '<div>' + rows + '</div>';
        }

        function openQuotaModal(fromTarget) {
            if (!quotaModal || !quotaModalBody) {
                return;
            }
            var t = normalizeEventTarget(fromTarget);
            if (t && typeof t.closest === 'function') {
                var ob = t.closest('.quota-bag-open');
                if (ob) {
                    lastQuotaOpener = ob;
                }
            }
            if (quotaModalSuggestions) {
                quotaModalSuggestions.innerHTML = '<p class="text-secondary caption1 mb-0">Loading…</p>';
            }
            quotaModalBody.innerHTML = '<p class="text-secondary mb-0">Loading…</p>';
            setQuotaModalOpen(true);
            var closeBtn = quotaModal.querySelector('button[data-quota-modal-close]');
            if (closeBtn && typeof closeBtn.focus === 'function') {
                window.setTimeout(function () {
                    try {
                        closeBtn.focus();
                    } catch (err) {
                        /* ignore */
                    }
                }, 0);
            }
            fetch(quotaPreviewUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) {
                    if (!r.ok) {
                        logQuotaModal('preview bad status', { status: r.status, statusText: r.statusText });
                        return Promise.reject(new Error('HTTP ' + r.status));
                    }
                    return r.json();
                })
                .then(function (data) {
                    logQuotaModal('preview ok', { empty: !!(data && data.empty), items: data && data.items ? data.items.length : 0 });
                    renderQuotaModal(data);
                })
                .catch(function (err) {
                    logQuotaModal('preview fetch failed', { message: err && err.message ? err.message : String(err) });
                    quotaModalBody.innerHTML = '<p class="text-red-700">Could not load your list. Please try again.</p>';
                    if (quotaModalSuggestions) {
                        quotaModalSuggestions.innerHTML = '<p class="text-red-700 caption1 mb-0">Could not load recommendations.</p>';
                    }
                });
        }

        document.addEventListener('click', function (e) {
            var t = normalizeEventTarget(e.target);
            if (!t || !t.closest) {
                return;
            }
            if (isQuotaModalVisible() && t.closest('[data-quota-modal-close]')) {
                e.preventDefault();
                closeQuotaModal();
                return;
            }
            var opener = t.closest('.quota-bag-open');
            if (opener && quotaModal && !quotaModal.contains(opener)) {
                e.preventDefault();
                logQuotaModal('bag click', { openerId: opener.id || null });
                openQuotaModal(t);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isQuotaModalVisible()) {
                closeQuotaModal();
            }
        });
    })();
    </script>
    <script>
    (function () {
        if (location.hash !== '#catalog-search') {
            return;
        }
        function focusCatalogSearch() {
            var el = document.querySelector('#catalog-search input[name="search"]');
            if (el) {
                el.focus({ preventScroll: false });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', focusCatalogSearch);
        } else {
            focusCatalogSearch();
        }
    })();
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\laragon\www\edx\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>