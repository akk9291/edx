<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> | EDX Admin</title>
    <link rel="icon" href="<?php echo e(asset('assets/images/edx.png')); ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?php echo e(asset('assets/images/edx.png')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-gradient: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%);
            --card-shadow: 0 4px 15px rgba(0,0,0,0.08);
            --card-hover-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            background: var(--sidebar-gradient);
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .sidebar .sidebar-nav-wrap {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 80px;
        }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar { width: 6px; }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); border-radius: 3px; }
        .sidebar .sidebar-nav-wrap::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        
        .sidebar h4 {
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 14px 20px;
            margin: 4px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
            padding-left: 25px;
        }
        
        .sidebar .nav-link:hover::before {
            transform: scaleY(1);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .sidebar .nav-link.active::before {
            transform: scaleY(1);
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 12px;
            margin: 20px 20px 0 20px;
            padding: 15px 25px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.5rem;
        }
        
        .main-content {
            padding: 30px;
        }
        
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 20px 25px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead {
            background: var(--primary-gradient);
            color: white;
        }
        
        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .btn-group .btn {
            margin: 0 2px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        code {
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 4px;
            color: #e11d48;
            font-size: 0.9em;
        }
        
        .tree-item {
            padding: 10px;
            border-left: 3px solid #e2e8f0;
            margin-left: 10px;
            transition: all 0.2s ease;
        }
        
        .tree-item:hover {
            border-left-color: #667eea;
            background: #f8f9ff;
            border-radius: 6px;
        }
        
        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 4px;
        }
        
        .pagination .page-link {
            color: #667eea;
            border: 1px solid #e2e8f0;
            padding: 8px 14px;
            margin: 0;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            min-width: 40px;
            text-align: center;
            display: inline-block;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .pagination .page-link {
            font-size: 14px;
        }
        
        /* Ensure arrow characters are properly sized */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 16px;
            font-weight: normal;
            line-height: 1.2;
            padding: 8px 12px;
            max-width: 50px;
        }
        
        .pagination .page-link:hover:not(.disabled):not([aria-disabled="true"]) {
            background: var(--primary-gradient);
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: #667eea;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .pagination .page-item.disabled .page-link,
        .pagination .page-link[aria-disabled="true"] {
            color: #cbd5e0;
            background: #f7fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background: #f7fafc;
            color: #cbd5e0;
        }
        
        /* Card Footer Styling */
        .card-footer-pagination {
            padding: 20px 25px;
            background: #f8f9fa;
            border-top: 1px solid #e2e8f0;
            border-radius: 0 0 15px 15px;
        }
        
        .card-footer-pagination nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            width: 100%;
        }
        
        /* Ensure no large decorative elements */
        .card-footer-pagination * {
            max-width: 100%;
            box-sizing: border-box;
        }
        
        .card-footer-pagination .pagination li {
            list-style: none;
            display: inline-block;
        }
        
        /* Hide any pseudo-elements that might create large arrows */
        .card-footer-pagination .pagination::before,
        .card-footer-pagination .pagination::after,
        .card-footer-pagination nav::before,
        .card-footer-pagination nav::after,
        .card-footer-pagination *::before,
        .card-footer-pagination *::after {
            display: none !important;
            content: none !important;
        }
        
        /* Ensure no large icons or decorative elements */
        .card-footer-pagination i,
        .card-footer-pagination svg,
        .card-footer-pagination .icon {
            display: none !important;
        }
        
        /* Limit font size for all pagination content */
        .card-footer-pagination {
            font-size: 14px;
        }
        
        .card-footer-pagination * {
            font-size: inherit;
            max-height: 50px;
        }
        
        /* Ensure pagination links don't have large content */
        .pagination .page-link {
            max-width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .card-footer-pagination .text-muted {
            color: #64748b !important;
            font-size: 0.875rem;
        }
        
        @media (max-width: 576px) {
            .card-footer-pagination {
                padding: 15px;
            }
            
            .card-footer-pagination nav {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .card-footer-pagination .pagination {
                justify-content: center;
                width: 100%;
            }
            
            .card-footer-pagination .text-muted {
                text-align: center;
                width: 100%;
            }
        }
        
        /* Table Container */
        .table-container {
            margin-bottom: 0;
        }
        
        .card-body {
            padding-bottom: 0;
        }
        
        /* Ensure consistent card spacing */
        .row:last-child {
            margin-bottom: 30px;
        }
        
        /* Table bottom spacing */
        .table-responsive {
            margin-bottom: 0;
        }
        
        /* Empty state styling */
        .table tbody tr td.text-center {
            padding: 40px 20px !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3 pb-0">
                    <h5 class="text-white mb-0 small text-nowrap">Admin Panel</h5>
                </div>
                <div class="sidebar-nav-wrap px-3">
                    <?php ($adminMinimalSidebar = (bool) config('app.admin_minimal_sidebar', true)); ?>
                    <ul class="nav flex-column mt-2">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">
                                <i class="bi bi-folder2 me-2"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index')); ?>">
                                <i class="bi bi-box-seam me-2"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.pillow-block.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.pillow-block.index')); ?>">
                                <i class="bi bi-grid-fill me-2"></i> Pillow Blocks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.quota-requests.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.quota-requests.index')); ?>">
                                <i class="bi bi-clipboard-data me-2"></i> Quotations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.profile.edit')); ?>">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                        <?php if (! ($adminMinimalSidebar)): ?>
                        <li class="nav-item pt-2 mt-2 border-top border-secondary border-opacity-25">
                            <div class="px-3 py-2 text-white-50 small text-uppercase" style="letter-spacing: 0.06em;">More</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.settings.index')); ?>">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.main-categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.main-categories.index')); ?>">
                                <i class="bi bi-folder me-2"></i> Main category groups
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.instagram-reels.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.instagram-reels.index')); ?>">
                                <i class="bi bi-instagram me-2"></i> Instagram Reels
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.alerts.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.alerts.index')); ?>">
                                <i class="bi bi-bell me-2"></i> Alerts
                                <?php if(isset($alertsCount) && $alertsCount > 0): ?>
                                    <span class="badge bg-danger rounded-pill ms-2"><?php echo e($alertsCount); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.hero-banners.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.hero-banners.index')); ?>">
                                <i class="bi bi-image me-2"></i> Hero Banners
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.customize.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.customize.index')); ?>">
                                <i class="bi bi-sliders me-2"></i> Customize
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.color-size-master.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.color-size-master.index')); ?>">
                                <i class="bi bi-palette2 me-2"></i> Color &amp; Size
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                                <i class="bi bi-cart-check me-2"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.payments.index')); ?>">
                                <i class="bi bi-credit-card me-2"></i> Payments History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.coupons.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.coupons.index')); ?>">
                                <i class="bi bi-ticket-perforated me-2"></i> Coupons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.reports.index')); ?>">
                                <i class="bi bi-download me-2"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">
                                <i class="bi bi-people me-2"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.policy-pages.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.policy-pages.index')); ?>">
                                <i class="bi bi-file-text me-2"></i> Policy Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.faqs.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.faqs.index')); ?>">
                                <i class="bi bi-question-circle me-2"></i> FAQs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.reviews.index')); ?>">
                                <i class="bi bi-chat-square-text me-2"></i> Review Manage
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="p-3 pt-2 border-top border-secondary border-opacity-25 flex-shrink-0">
                    <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-light w-100 btn-sm">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <div>
                            <div class="navbar-brand mb-0 fw-bold" style="font-size: 1.25rem;">Admin Panel</div>
                            <div class="text-muted small">Control Center</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="<?php echo e(route('admin.profile.edit')); ?>" class="d-flex align-items-center me-3 text-decoration-none text-body" title="My profile">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-weight: bold;">
                                    <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="fw-semibold"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                                    <div class="text-muted small">
                                        <?php if(Auth::user()->isAdmin()): ?>
                                            Administrator
                                        <?php else: ?>
                                            <?php echo e(ucfirst(Auth::user()->role ?? 'User')); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                            <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                <div class="main-content">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo e(session('warning')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($errors) && $errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH F:\laragon\www\edx\resources\views/admin/layout.blade.php ENDPATH**/ ?>