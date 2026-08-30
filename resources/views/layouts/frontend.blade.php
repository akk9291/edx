<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EDX Rulmenti Romania S.R.L.')</title>
    @stack('meta')
    <link rel="icon" href="{{ asset('assets/images/EDX-LOGO-RULMENTI.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('assets/images/EDX-LOGO-RULMENTI.png') }}" type="image/png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}">
    
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

        /* Bearing live search suggestions dropdown */
        .edx-search-suggestions-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            width: 100%;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 12px 30px -4px rgba(0, 0, 0, 0.16), 0 4px 10px -2px rgba(0, 0, 0, 0.08);
            border: 1px solid #e4e4e7;
            z-index: 9999;
            overflow: hidden;
            max-height: min(460px, 75vh);
            overflow-y: auto;
            text-align: left;
            box-sizing: border-box;
            -webkit-overflow-scrolling: touch;
        }

        .edx-suggestion-header {
            padding: 0.625rem 1rem 0.375rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #71717a;
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        .edx-suggestion-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.625rem 1rem;
            border-bottom: 1px solid #f4f4f5;
            text-decoration: none !important;
            color: #18181b !important;
            transition: background-color 0.15s ease;
            cursor: pointer;
        }

        .edx-suggestion-item:last-child {
            border-bottom: none;
        }

        .edx-suggestion-item:hover,
        .edx-suggestion-item.is-selected {
            background-color: #f4f4f5;
        }

        .edx-suggestion-thumb {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 0.5rem;
            border: 1px solid #e4e4e7;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .edx-suggestion-thumb img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .edx-suggestion-info {
            flex: 1 1 0;
            min-width: 0;
        }

        .edx-suggestion-sku {
            font-size: 0.875rem;
            font-weight: 700;
            color: #c8102e;
            line-height: 1.25;
        }

        .edx-suggestion-name {
            font-size: 0.8125rem;
            color: #3f3f46;
            line-height: 1.35;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .edx-suggestion-meta {
            font-size: 0.6875rem;
            color: #71717a;
            margin-top: 2px;
            line-height: 1.2;
        }

        .edx-suggestion-arrow {
            flex-shrink: 0;
            color: #a1a1aa;
            font-size: 1rem;
        }

        .edx-suggestion-category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.625rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #27272a !important;
            border-bottom: 1px solid #f4f4f5;
            text-decoration: none !important;
            transition: background-color 0.15s ease;
        }

        .edx-suggestion-category-item:hover,
        .edx-suggestion-category-item.is-selected {
            background-color: #f4f4f5;
            color: #c8102e !important;
        }

        .edx-suggestion-footer {
            padding: 0.75rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #c8102e !important;
            background: #fafafa;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none !important;
        }

        .edx-suggestion-footer:hover,
        .edx-suggestion-footer.is-selected {
            background: #f4f4f5;
            text-decoration: underline !important;
        }

        .edx-suggestion-loading,
        .edx-suggestion-empty {
            padding: 1.25rem 1rem;
            text-align: center;
            font-size: 0.875rem;
            color: #71717a;
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
        /* Search Popup Modal */
        #edx-search-modal {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 99995;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        #edx-search-modal .edx-search-modal-shell {
            position: relative;
            min-height: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 1.25rem 1rem;
        }
        @media (min-width: 640px) {
            #edx-search-modal .edx-search-modal-shell {
                padding: 3.5rem 1.5rem 2rem;
            }
        }
        #edx-search-modal .edx-search-modal-backdrop {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 0;
            background: rgba(15, 23, 42, 0.68);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        #edx-search-modal .edx-search-modal-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 44rem;
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: edxSearchPopIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes edxSearchPopIn {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(-10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        .edx-search-modal-header {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            gap: 0.75rem;
            background: #ffffff;
        }
        .edx-search-modal-input-wrap {
            display: flex;
            align-items: center;
            flex: 1 1 0%;
            gap: 0.75rem;
        }
        .edx-search-modal-input-wrap input {
            width: 100%;
            border: none !important;
            outline: none !important;
            font-size: 1.0625rem;
            color: #0f172a;
            background: transparent;
            padding: 0.5rem 0;
            box-shadow: none !important;
        }
        .edx-search-modal-input-wrap input::placeholder {
            color: #94a3b8;
        }
        .edx-search-modal-close-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.5rem;
            color: #64748b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .edx-search-modal-close-btn:hover {
            color: #0f172a;
            background: #f1f5f9;
        }
        .edx-search-modal-clear-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        .edx-search-modal-clear-btn:hover {
            color: #475569;
        }
        .edx-search-modal-body {
            max-height: min(28rem, 65vh);
            overflow-y: auto;
            padding: 0;
            -webkit-overflow-scrolling: touch;
        }
        .edx-search-modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.625rem 1.25rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            font-size: 0.75rem;
            color: #64748b;
        }
        .edx-search-modal-footer kbd {
            display: inline-block;
            padding: 0.125rem 0.375rem;
            font-size: 0.6875rem;
            font-family: inherit;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 0.25rem;
            box-shadow: 0 1px 1px rgba(0,0,0,0.05);
        }
        .edx-search-quick-chip,
        .edx-search-tag-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.85rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #334155;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            text-decoration: none !important;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .edx-search-quick-chip:hover,
        .edx-search-tag-chip:hover {
            color: #c8102e;
            background: #fee2e2;
            border-color: #fca5a5;
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
    
    @yield('styles')
</head>
<body>
    {{-- Theme main.js does document.querySelector(".cart-icon") + modal cart; first match must not be the quota bag. --}}
    <div class="cart-icon" aria-hidden="true" tabindex="-1" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">
        <span>0</span>
    </div>
    <!-- Header -->
    @include('frontend.partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.partials.footer')
    
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
                        <a id="edx-quota-modal-cta" href="{{ route('frontend.quota-list.index') }}#request-quotation" class="edx-quota-modal-checkout">
                            Send quotation request
                        </a>
                        <a id="edx-quota-modal-secondary" href="{{ route('frontend.quota-list.index') }}" class="edx-quota-modal-viewlist">
                            View full list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search Popup Modal with Live Suggestions -->
    <div id="edx-search-modal" class="edx-search-modal-root" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="edx-search-modal-input" aria-hidden="true">
        <div class="edx-search-modal-shell">
            <div class="edx-search-modal-backdrop" data-search-modal-close tabindex="-1" aria-hidden="true"></div>
            <div class="edx-search-modal-card">
                <form action="{{ route('frontend.range') }}" method="get" class="edx-search-modal-form m-0" id="edx-search-modal-form" role="search" aria-label="Search catalogue">
                    <div class="edx-search-modal-header">
                        <div class="edx-search-modal-input-wrap">
                            <i class="ph-bold ph-magnifying-glass text-xl text-stone-400 shrink-0" aria-hidden="true"></i>
                            <input type="search" id="edx-search-modal-input" name="search" placeholder="Search bearings, SKU, dimensions (e.g. 6200, UCFL)..." autocomplete="off" />
                            <button type="button" id="edx-search-modal-clear" class="edx-search-modal-clear-btn" style="display: none;" title="Clear input" aria-label="Clear search query">
                                <i class="ph ph-x-circle text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                        <button type="button" class="edx-search-modal-close-btn" data-search-modal-close title="Close (Esc)" aria-label="Close search">
                            <i class="ph ph-x text-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="edx-search-modal-body" id="edx-search-modal-results">
                        <div class="edx-search-modal-initial p-4 sm:p-5">
                            <div class="mb-4">
                                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-2">Popular Categories</div>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('frontend.range', ['category' => 'deep-groove-ball-bearings']) }}" class="edx-search-quick-chip">Deep Groove Ball Bearings</a>
                                    <a href="{{ route('frontend.range', ['category' => 'angular-contact-ball-bearings']) }}" class="edx-search-quick-chip">Angular Contact Bearings</a>
                                    <a href="{{ route('frontend.range', ['category' => 'spherical-roller-bearings']) }}" class="edx-search-quick-chip">Spherical Roller Bearings</a>
                                    <a href="{{ route('frontend.range', ['category' => 'pillow-block-units']) }}" class="edx-search-quick-chip">Pillow Blocks</a>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-2">Popular Searches</div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="6200">6200</button>
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="6305">6305</button>
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="16001">16001</button>
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="UCFL">UCFL</button>
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="2RS">2RS</button>
                                    <button type="button" class="edx-search-tag-chip" data-fill-search="C3">C3</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edx-search-modal-footer">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center gap-1"><kbd>↑</kbd><kbd>↓</kbd> Navigate</span>
                            <span class="flex items-center gap-1"><kbd>↵</kbd> Select</span>
                            <span class="flex items-center gap-1"><kbd>ESC</kbd> Close</span>
                        </div>
                        <div class="text-xs text-stone-400 font-medium">EDX Bearings</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Files -->
    <script src="{{ asset('assets/js/phosphor-icons.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
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
            fetch('{{ route('frontend.quota-list.count') }}', {
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
            fetch('{{ route('frontend.quota-list.add') }}', {
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
        var quotaPreviewUrl = '{{ route('frontend.quota-list.preview') }}';
        var quotaListUrl = '{{ route('frontend.quota-list.index') }}';
        var quotaRangeUrl = '{{ route('frontend.range') }}';

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
    
    <script>
    (function () {
        var suggestionApiUrl = '{{ route('frontend.search.suggestions') }}';
        var debounceTimer = null;
        var currentAbortCtrl = null;

        function escapeHtml(str) {
            if (!str) return '';
            var div = document.createElement('div');
            div.textContent = String(str);
            return div.innerHTML;
        }

        function initAutocomplete(form) {
            var input = form.querySelector('input[name="search"]');
            var dropdown = form.querySelector('.edx-search-suggestions-dropdown');
            
            if (!input) return;
            
            if (!dropdown) {
                dropdown = document.createElement('div');
                dropdown.className = 'edx-search-suggestions-dropdown';
                dropdown.style.display = 'none';
                form.appendChild(dropdown);
            }

            var selectedIndex = -1;

            function closeDropdown() {
                dropdown.style.display = 'none';
                dropdown.innerHTML = '';
                selectedIndex = -1;
            }

            function highlightIndex(index) {
                var items = dropdown.querySelectorAll('.edx-navigable-item');
                if (!items.length) return;
                
                items.forEach(function (el) { el.classList.remove('is-selected'); });
                
                if (index >= 0 && index < items.length) {
                    selectedIndex = index;
                    items[selectedIndex].classList.add('is-selected');
                    items[selectedIndex].scrollIntoView({ block: 'nearest' });
                } else {
                    selectedIndex = -1;
                }
            }

            function renderResults(data, query) {
                if (!data || ((!data.products || !data.products.length) && (!data.categories || !data.categories.length))) {
                    dropdown.innerHTML = 
                        '<div class="edx-suggestion-empty">' +
                            '<i class="ph ph-magnifying-glass text-xl mb-1 block opacity-60"></i>' +
                            '<div>No bearings found for <strong>"' + escapeHtml(query) + '"</strong></div>' +
                            '<div class="caption2 text-secondary mt-1">Press Enter to search entire catalog</div>' +
                        '</div>';
                    dropdown.style.display = 'block';
                    selectedIndex = -1;
                    return;
                }

                var html = '';

                // Categories
                if (data.categories && data.categories.length > 0) {
                    html += '<div class="edx-suggestion-header">Categories</div>';
                    data.categories.forEach(function (cat) {
                        html += '<a href="' + escapeHtml(cat.url) + '" class="edx-suggestion-category-item edx-navigable-item">' +
                            '<span class="flex items-center gap-2"><i class="ph ph-folder text-sm opacity-60"></i> ' + escapeHtml(cat.name) + '</span>' +
                            '<i class="ph ph-caret-right text-xs opacity-50"></i>' +
                        '</a>';
                    });
                }

                // Products
                if (data.products && data.products.length > 0) {
                    html += '<div class="edx-suggestion-header">Bearings & Products</div>';
                    data.products.forEach(function (p) {
                        var thumb = p.image_url 
                            ? '<img src="' + escapeHtml(p.image_url) + '" alt="' + escapeHtml(p.name) + '" loading="lazy">' 
                            : '<i class="ph ph-package text-xl opacity-40"></i>';
                        
                        var cleanName = p.display_name || p.name || '';
                        var skuVal = p.sku ? String(p.sku).trim() : '';
                        if (skuVal && cleanName.endsWith(skuVal)) {
                            cleanName = cleanName.substring(0, cleanName.length - skuVal.length).trim();
                        }

                        var metaText = '';
                        if (p.dimensions) {
                            metaText = escapeHtml(p.dimensions);
                        } else if (p.category) {
                            metaText = escapeHtml(p.category);
                        }

                        html += '<a href="' + escapeHtml(p.url) + '" class="edx-suggestion-item edx-navigable-item">' +
                            '<div class="edx-suggestion-thumb">' + thumb + '</div>' +
                            '<div class="edx-suggestion-info">' +
                                '<div class="edx-suggestion-sku">' + escapeHtml(skuVal || cleanName) + '</div>' +
                                (cleanName ? '<div class="edx-suggestion-name">' + escapeHtml(cleanName) + '</div>' : '') +
                                (metaText ? '<div class="edx-suggestion-meta">' + metaText + '</div>' : '') +
                            '</div>' +
                            '<div class="edx-suggestion-arrow"><i class="ph ph-arrow-right"></i></div>' +
                        '</a>';
                    });
                }

                // Footer / View all
                var searchRangeUrl = '{{ route('frontend.range') }}?search=' + encodeURIComponent(query);
                html += '<a href="' + searchRangeUrl + '" class="edx-suggestion-footer edx-navigable-item">' +
                    '<i class="ph ph-magnifying-glass"></i>' +
                    '<span>View all results for <strong>"' + escapeHtml(query) + '"</strong></span>' +
                '</a>';

                dropdown.innerHTML = html;
                dropdown.style.display = 'block';
                selectedIndex = -1;
            }

            function fetchSuggestions(query) {
                if (currentAbortCtrl) {
                    currentAbortCtrl.abort();
                }
                currentAbortCtrl = new AbortController();

                dropdown.innerHTML = 
                    '<div class="edx-suggestion-loading">' +
                        '<i class="ph ph-spinner animate-spin text-xl mb-1 inline-block text-red-600"></i>' +
                        '<div class="caption1 text-secondary">Searching bearings...</div>' +
                    '</div>';
                dropdown.style.display = 'block';

                fetch(suggestionApiUrl + '?q=' + encodeURIComponent(query), {
                    signal: currentAbortCtrl.signal,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    renderResults(data, query);
                })
                .catch(function (err) {
                    if (err && err.name === 'AbortError') return;
                    dropdown.innerHTML = '<div class="edx-suggestion-empty text-red-600">Could not load suggestions.</div>';
                });
            }

            input.addEventListener('input', function () {
                var q = input.value.trim();
                clearTimeout(debounceTimer);
                if (q.length < 1) {
                    closeDropdown();
                    return;
                }
                debounceTimer = setTimeout(function () {
                    fetchSuggestions(q);
                }, 200);
            });

            input.addEventListener('focus', function () {
                var q = input.value.trim();
                if (q.length >= 1 && dropdown.children.length > 0) {
                    dropdown.style.display = 'block';
                } else if (q.length >= 1) {
                    fetchSuggestions(q);
                }
            });

            input.addEventListener('keydown', function (e) {
                var items = dropdown.querySelectorAll('.edx-navigable-item');
                if (dropdown.style.display === 'none' || !items.length) {
                    return;
                }

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    var next = selectedIndex + 1;
                    if (next >= items.length) next = 0;
                    highlightIndex(next);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    var prev = selectedIndex - 1;
                    if (prev < 0) prev = items.length - 1;
                    highlightIndex(prev);
                } else if (e.key === 'Enter') {
                    if (selectedIndex >= 0 && items[selectedIndex]) {
                        e.preventDefault();
                        items[selectedIndex].click();
                    }
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    closeDropdown();
                }
            });

            document.addEventListener('click', function (e) {
                if (!form.contains(e.target)) {
                    closeDropdown();
                }
            });
        }

        // Search Modal Controller
        (function () {
            var searchModal = document.getElementById('edx-search-modal');
            var searchInput = document.getElementById('edx-search-modal-input');
            var searchResults = document.getElementById('edx-search-modal-results');
            var searchClearBtn = document.getElementById('edx-search-modal-clear');
            var initialHtml = searchResults ? searchResults.innerHTML : '';
            var suggestionApiUrl = '{{ route('frontend.search.suggestions') }}';
            var searchRangeUrl = '{{ route('frontend.range') }}';
            var debounceTimer = null;
            var currentAbortCtrl = null;
            var selectedIndex = -1;

            if (!searchModal || !searchInput || !searchResults) {
                return;
            }

            function escapeHtml(str) {
                if (!str) return '';
                var div = document.createElement('div');
                div.textContent = String(str);
                return div.innerHTML;
            }

            function openSearchModal(initialQuery) {
                searchModal.style.display = 'block';
                searchModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                if (typeof initialQuery === 'string') {
                    searchInput.value = initialQuery;
                }
                setTimeout(function () {
                    searchInput.focus();
                    if (searchInput.value) {
                        searchInput.select();
                        triggerSearch(searchInput.value.trim());
                    }
                }, 50);
            }

            function closeSearchModal() {
                searchModal.style.display = 'none';
                searchModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                if (currentAbortCtrl) {
                    currentAbortCtrl.abort();
                }
            }

            function highlightIndex(index) {
                var items = searchResults.querySelectorAll('.edx-navigable-item');
                if (!items.length) return;
                items.forEach(function (el) { el.classList.remove('is-selected'); });
                if (index >= 0 && index < items.length) {
                    selectedIndex = index;
                    items[selectedIndex].classList.add('is-selected');
                    items[selectedIndex].scrollIntoView({ block: 'nearest' });
                } else {
                    selectedIndex = -1;
                }
            }

            function renderModalResults(data, query) {
                if (!data || ((!data.products || !data.products.length) && (!data.categories || !data.categories.length))) {
                    searchResults.innerHTML = 
                        '<div class="edx-suggestion-empty p-8 text-center">' +
                            '<i class="ph ph-magnifying-glass text-3xl mb-2 block opacity-40"></i>' +
                            '<div class="font-medium text-stone-800">No bearings found for <strong>"' + escapeHtml(query) + '"</strong></div>' +
                            '<div class="text-xs text-stone-500 mt-1">Press Enter to search entire catalog</div>' +
                        '</div>';
                    selectedIndex = -1;
                    return;
                }

                var html = '';

                // Categories
                if (data.categories && data.categories.length > 0) {
                    html += '<div class="edx-suggestion-header">Categories</div>';
                    data.categories.forEach(function (cat) {
                        html += '<a href="' + escapeHtml(cat.url) + '" class="edx-suggestion-category-item edx-navigable-item">' +
                            '<span class="flex items-center gap-2"><i class="ph ph-folder text-sm opacity-60"></i> ' + escapeHtml(cat.name) + '</span>' +
                            '<i class="ph ph-caret-right text-xs opacity-50"></i>' +
                        '</a>';
                    });
                }

                // Products
                if (data.products && data.products.length > 0) {
                    html += '<div class="edx-suggestion-header">Bearings &amp; Products</div>';
                    data.products.forEach(function (p) {
                        var thumb = p.image_url 
                            ? '<img src="' + escapeHtml(p.image_url) + '" alt="' + escapeHtml(p.name) + '" loading="lazy">' 
                            : '<i class="ph ph-package text-xl opacity-40"></i>';
                        
                        var cleanName = p.display_name || p.name || '';
                        var skuVal = p.sku ? String(p.sku).trim() : '';
                        if (skuVal && cleanName.endsWith(skuVal)) {
                            cleanName = cleanName.substring(0, cleanName.length - skuVal.length).trim();
                        }

                        var metaText = '';
                        if (p.dimensions) {
                            metaText = escapeHtml(p.dimensions);
                        } else if (p.category) {
                            metaText = escapeHtml(p.category);
                        }

                        html += '<a href="' + escapeHtml(p.url) + '" class="edx-suggestion-item edx-navigable-item">' +
                            '<div class="edx-suggestion-thumb">' + thumb + '</div>' +
                            '<div class="edx-suggestion-info">' +
                                '<div class="edx-suggestion-sku">' + escapeHtml(skuVal || cleanName) + '</div>' +
                                (cleanName ? '<div class="edx-suggestion-name">' + escapeHtml(cleanName) + '</div>' : '') +
                                (metaText ? '<div class="edx-suggestion-meta">' + metaText + '</div>' : '') +
                            '</div>' +
                            '<div class="edx-suggestion-arrow"><i class="ph ph-arrow-right"></i></div>' +
                        '</a>';
                    });
                }

                // Footer / View all
                var fullSearchUrl = searchRangeUrl + '?search=' + encodeURIComponent(query);
                html += '<a href="' + fullSearchUrl + '" class="edx-suggestion-footer edx-navigable-item">' +
                    '<i class="ph ph-magnifying-glass"></i>' +
                    '<span>View all results for <strong>"' + escapeHtml(query) + '"</strong></span>' +
                '</a>';

                searchResults.innerHTML = html;
                selectedIndex = -1;
            }

            function triggerSearch(query) {
                if (currentAbortCtrl) {
                    currentAbortCtrl.abort();
                }
                if (!query || query.length < 1) {
                    searchResults.innerHTML = initialHtml;
                    if (searchClearBtn) searchClearBtn.style.display = 'none';
                    return;
                }

                if (searchClearBtn) {
                    searchClearBtn.style.display = 'inline-flex';
                }

                currentAbortCtrl = new AbortController();
                searchResults.innerHTML = 
                    '<div class="edx-suggestion-loading p-8 text-center">' +
                        '<i class="ph ph-spinner animate-spin text-2xl mb-2 inline-block text-red-600"></i>' +
                        '<div class="text-sm text-stone-500">Searching catalogue...</div>' +
                    '</div>';

                fetch(suggestionApiUrl + '?q=' + encodeURIComponent(query), {
                    signal: currentAbortCtrl.signal,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    renderModalResults(data, query);
                })
                .catch(function (err) {
                    if (err && err.name === 'AbortError') return;
                    searchResults.innerHTML = '<div class="edx-suggestion-empty text-red-600 p-6 text-center">Could not load search results.</div>';
                });
            }

            // Open button listeners
            document.addEventListener('click', function (e) {
                var openBtn = e.target.closest('.edx-search-modal-open');
                if (openBtn) {
                    e.preventDefault();
                    openSearchModal();
                    return;
                }

                var closeBtn = e.target.closest('[data-search-modal-close]');
                if (closeBtn) {
                    e.preventDefault();
                    closeSearchModal();
                    return;
                }

                var tagBtn = e.target.closest('[data-fill-search]');
                if (tagBtn) {
                    e.preventDefault();
                    var val = tagBtn.getAttribute('data-fill-search');
                    if (val) {
                        searchInput.value = val;
                        triggerSearch(val);
                    }
                }
            });

            if (searchClearBtn) {
                searchClearBtn.addEventListener('click', function () {
                    searchInput.value = '';
                    searchInput.focus();
                    triggerSearch('');
                });
            }

            searchInput.addEventListener('input', function () {
                var q = searchInput.value.trim();
                clearTimeout(debounceTimer);
                if (q.length < 1) {
                    triggerSearch('');
                    return;
                }
                debounceTimer = setTimeout(function () {
                    triggerSearch(q);
                }, 180);
            });

            searchInput.addEventListener('keydown', function (e) {
                var items = searchResults.querySelectorAll('.edx-navigable-item');
                if (e.key === 'ArrowDown' && items.length) {
                    e.preventDefault();
                    var next = selectedIndex + 1;
                    if (next >= items.length) next = 0;
                    highlightIndex(next);
                } else if (e.key === 'ArrowUp' && items.length) {
                    e.preventDefault();
                    var prev = selectedIndex - 1;
                    if (prev < 0) prev = items.length - 1;
                    highlightIndex(prev);
                } else if (e.key === 'Enter') {
                    if (selectedIndex >= 0 && items[selectedIndex]) {
                        e.preventDefault();
                        items[selectedIndex].click();
                    }
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    closeSearchModal();
                }
            });

            // Global shortcut (Cmd+K / Ctrl+K / slash)
            document.addEventListener('keydown', function (e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchModal.style.display === 'block') {
                        closeSearchModal();
                    } else {
                        openSearchModal();
                    }
                } else if (e.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    openSearchModal();
                } else if (e.key === 'Escape' && searchModal.style.display === 'block') {
                    closeSearchModal();
                }
            });
        })();

        document.addEventListener('DOMContentLoaded', function () {
            var forms = document.querySelectorAll('[data-bearing-search-form], .edx-search-pill-form, .edx-catalog-search-form');
            forms.forEach(function (form) {
                initAutocomplete(form);
            });
        });
    })();
    </script>
    
    @yield('scripts')
</body>
</html>
