<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorSizeMasterController;
use App\Http\Controllers\Admin\CustomizeSettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\InstagramReelController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PolicyPageController as AdminPolicyPageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PillowBlockController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuotaRequestController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\ProductPdfController;
use App\Http\Controllers\Frontend\QuotaListController;
use App\Http\Controllers\Frontend\SearchSuggestionController;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\MainCategory;
use App\Models\MasterColor;
use App\Models\MasterSize;
use App\Models\Order;
use App\Models\Product;
use App\Support\CatalogFilterOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// =====================================================
// FRONTEND ROUTES - EDX Bearing Website
// =====================================================

// Home Page (edx-bearing HTML catalog only — Bearings main category)
Route::get('/', function (Request $request) {
    $base = Product::edxBearingsCatalog()->where('is_active', true);
    $productTotal = (clone $base)->count();

    $query = (clone $base)->with('category')->orderByDesc('created_at')->orderByDesc('id');

    $products = $query->limit(12)->get();

    $categories = CatalogFilterOptions::categories();
    $facets = CatalogFilterOptions::facets();

    return view('frontend.home', compact('products', 'productTotal', 'categories', 'facets'));
})->name('home');

// Product Detail Page
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\PillowBlock::where('slug', $slug)
        ->where('is_active', true)
        ->with(['category', 'galleryImages'])
        ->first();

    if ($product) {
        $relatedProducts = \App\Models\PillowBlock::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
    } else {
        $product = Product::edxBearingsCatalog()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedProducts = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($query) use ($product) {
                return $query->where('category_id', $product->category_id);
            })
            ->limit(4)
            ->get();
    }

    return view('frontend.product', compact('product', 'relatedProducts'));
})->name('frontend.product');

// Product PDF hub (site layout + embedded preview + links)
Route::get('/product/{slug}/pdf', function ($slug) {
    $product = \App\Models\PillowBlock::where('slug', $slug)
        ->where('is_active', true)
        ->with('category')
        ->first();

    if (!$product) {
        $product = Product::edxBearingsCatalog()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();
    }

    return view('frontend.product-pdf', compact('product'));
})->name('frontend.product.pdf');

Route::get('/product/{slug}/pdf/preview', [ProductPdfController::class, 'preview'])
    ->name('frontend.product.pdf.preview');
Route::get('/product/{slug}/pdf/download', [ProductPdfController::class, 'download'])
    ->name('frontend.product.pdf.download');

// Search Suggestions (Live autocomplete)
Route::get('/search/suggestions', [SearchSuggestionController::class, 'suggestions'])
    ->name('frontend.search.suggestions');

// Product Range / Shop Page
Route::get('/range', function (Request $request) {
    $categories = CatalogFilterOptions::categories($request);
    $facets = CatalogFilterOptions::facets();

    $isPillowBlockOnly = $request->filled('category') && $request->category === 'pillow-block';
    $isStandardBearingOnly = $request->filled('category') && $request->category !== 'pillow-block';

    if ($isPillowBlockOnly) {
        $query = \App\Models\PillowBlock::where('is_active', true)->with('category');
        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('sku', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }
        $sort = $request->get('sort', 'latest');
        if ($sort === 'name') {
            $query->orderBy('name');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $products = $query->paginate(12)->withQueryString();
    } else if ($isStandardBearingOnly) {
        $query = Product::edxBearingsCatalog()->where('is_active', true)->with('category');
        CatalogFilterOptions::applyListingFilters($query, $request);
        $sort = $request->get('sort', 'latest');
        if ($sort === 'name') {
            $query->orderBy('name');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $products = $query->paginate(12)->withQueryString();
    } else {
        // Union query for both
        $productQuery = Product::edxBearingsCatalog()
            ->select('id', 'name', 'slug', 'sku', 'category_id', 'price', 'sale_price', 'image', 'is_active', 'is_featured', 'is_new_arrival', 'created_at', DB::raw("'product' as type"))
            ->where('is_active', true);
        
        $pillowQuery = \App\Models\PillowBlock::select('id', 'name', 'slug', 'sku', 'category_id', 'price', 'sale_price', 'image', 'is_active', 'is_featured', 'is_new_arrival', 'created_at', DB::raw("'pillow_block' as type"))
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $productQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('sku', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
            $pillowQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('sku', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('bore') || $request->filled('rows')) {
            $query = Product::edxBearingsCatalog()->where('is_active', true)->with('category');
            CatalogFilterOptions::applyListingFilters($query, $request);
            $sort = $request->get('sort', 'latest');
            if ($sort === 'name') {
                $query->orderBy('name');
            } else {
                $query->orderBy('created_at', 'desc');
            }
            $products = $query->paginate(12)->withQueryString();
        } else {
            $unionQuery = $productQuery->union($pillowQuery);
            $sort = $request->get('sort', 'latest');
            $orderCol = $sort === 'name' ? 'name' : 'created_at';
            $orderDir = $sort === 'name' ? 'asc' : 'desc';
            
            $unionQuery->orderBy($orderCol, $orderDir);
            $products = $unionQuery->paginate(12)->withQueryString();

            // Transform raw collection to real Eloquent model instances
            $products->getCollection()->transform(function ($item) {
                if ($item->type === 'pillow_block') {
                    return \App\Models\PillowBlock::with('category')->find($item->id) ?: $item;
                } else {
                    return Product::with('category')->find($item->id) ?: $item;
                }
            });
        }
    }

    $rangeCategory = null;
    if ($request->filled('category')) {
        $bearingsMainId = MainCategory::bearingsCatalogId();
        $rangeCategoryQuery = Category::query()
            ->where('slug', $request->category)
            ->where('is_active', true);
        if ($bearingsMainId !== null) {
            $rangeCategoryQuery->where('main_category_id', $bearingsMainId);
        }
        $rangeCategory = $rangeCategoryQuery->first();
    }

    $searchWithoutCategoryCount = null;
    if ($products->total() === 0 && $request->filled('category') && $request->filled('search')) {
        if ($request->category === 'pillow-block') {
            $searchWithoutCategoryCount = Product::edxBearingsCatalog()->where('is_active', true)
                ->where(function ($q) use ($request) {
                    $search = trim((string) $request->search);
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                })->count();
        } else {
            $searchWithoutCategoryCount = \App\Models\PillowBlock::where('is_active', true)
                ->where(function ($q) use ($request) {
                    $search = trim((string) $request->search);
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                })->count();
        }
    }

    return view('frontend.range', compact('products', 'categories', 'facets', 'rangeCategory', 'searchWithoutCategoryCount'));
})->name('frontend.range');

// Static Pages
Route::get('/edx-world', function () {
    return redirect()->away('https://edxromania.ro/edx-world/', 301);
})->name('frontend.edx-world');

Route::get('/quality-path', function () {
    return redirect()->away('https://edxromania.ro/quality-path/', 301);
})->name('frontend.quality-path');

Route::get('/industries', function () {
    return redirect()->away('https://edxromania.ro/industries/', 301);
})->name('frontend.industries');

Route::get('/applications', function () {
    return redirect()->away('https://edxromania.ro/applications/', 301);
})->name('frontend.applications');

// Contact Page
Route::get('/contact', function () {
    return redirect()->away('https://edxromania.ro/contact-us/', 301);
})->name('frontend.contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    return redirect()->route('frontend.contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
})->name('frontend.contact.submit');

// Quota list (session) + quotation request submissions
Route::prefix('quota-list')->name('frontend.quota-list.')->group(function () {
    Route::get('/', [QuotaListController::class, 'index'])->name('index');
    Route::get('/preview', [QuotaListController::class, 'preview'])->name('preview');
    Route::get('/count', [QuotaListController::class, 'count'])->name('count');
    Route::post('/add', [QuotaListController::class, 'add'])->name('add');
    Route::post('/update', [QuotaListController::class, 'updateLine'])->name('update');
    Route::post('/remove', [QuotaListController::class, 'remove'])->name('remove');
    Route::post('/clear', [QuotaListController::class, 'clear'])->name('clear');
    Route::post('/submit', [QuotaListController::class, 'submit'])->name('submit');
});

// Serve storage files via PHP when symlink returns 403 or on shared hosting
$serveStorage = function (string $path) {
    $path = ltrim(preg_replace('#\.\./#', '', $path), '/');

    // 1. storage/app/public/ path
    $diskPath = storage_path('app/public/'.$path);
    if (file_exists($diskPath) && is_file($diskPath)) {
        return response()->file($diskPath);
    }

    // 2. public/storage/ path
    $publicStoragePath = public_path('storage/'.$path);
    if (file_exists($publicStoragePath) && is_file($publicStoragePath)) {
        return response()->file($publicStoragePath);
    }

    // 3. Storage public disk
    if (Storage::disk('public')->exists($path)) {
        return response()->file(Storage::disk('public')->path($path));
    }

    // 4. Default fallback image
    $fallback = public_path('assets/images/PhotoshopExtension_Image-1.webp');
    if (file_exists($fallback)) {
        return response()->file($fallback);
    }

    abort(404);
};
Route::get('/storage/{path}', $serveStorage)->where('path', '.*')->name('storage.serve');
Route::get('/public/storage/{path}', $serveStorage)->where('path', '.*')->name('storage.public.serve');
Route::get('/media/{path}', $serveStorage)->where('path', '.*')->name('media.serve');

// =====================================================
// ADMIN ROUTES
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes (public)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

        // Report Downloads
        Route::get('/dashboard/reports/inventory', [DashboardController::class, 'downloadInventoryReport'])->name('dashboard.reports.inventory');
        Route::get('/dashboard/reports/orders', [DashboardController::class, 'downloadOrdersReport'])->name('dashboard.reports.orders');
        Route::get('/dashboard/reports/revenue', [DashboardController::class, 'downloadRevenueReport'])->name('dashboard.reports.revenue');
        Route::get('/dashboard/reports/customers', [DashboardController::class, 'downloadCustomersReport'])->name('dashboard.reports.customers');
        Route::get('/dashboard/reports/skus', [DashboardController::class, 'downloadSkusReport'])->name('dashboard.reports.skus');

        // Reports hub
        Route::get('/reports', [DashboardController::class, 'reportsIndex'])->name('reports.index');

        // Resource Routes
        Route::resource('users', UserController::class);
        Route::get('products/bearing-import/sample', [ProductController::class, 'bearingImportSample'])
            ->name('products.bearing-import.sample');
        Route::post('products/bearing-import', [ProductController::class, 'importBearings'])
            ->name('products.bearing-import');
        Route::get('products/bearing-export', [ProductController::class, 'exportBearings'])
            ->name('products.bearing-export');
        Route::post('products/bulk-update', [ProductController::class, 'bulkUpdate'])
            ->name('products.bulkUpdate');
        Route::delete('products/bulk-destroy', [ProductController::class, 'bulkDestroy'])
            ->name('products.bulkDestroy');
        Route::resource('products', ProductController::class);
        
        // Pillow Blocks Module
        Route::get('pillow-block/import/sample', [PillowBlockController::class, 'importSample'])
            ->name('pillow-block.import.sample');
        Route::post('pillow-block/import', [PillowBlockController::class, 'import'])
            ->name('pillow-block.import');
        Route::get('pillow-block/export', [PillowBlockController::class, 'export'])
            ->name('pillow-block.export');
        Route::post('pillow-block/bulk-update', [PillowBlockController::class, 'bulkUpdate'])
            ->name('pillow-block.bulkUpdate');
        Route::delete('pillow-block/bulk-destroy', [PillowBlockController::class, 'bulkDestroy'])
            ->name('pillow-block.bulkDestroy');
        Route::resource('pillow-block', PillowBlockController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);

        Route::get('/quota-requests', [QuotaRequestController::class, 'index'])->name('quota-requests.index');
        Route::get('/quota-requests/{quotaRequest}', [QuotaRequestController::class, 'show'])->name('quota-requests.show');
        Route::put('/quota-requests/{quotaRequest}', [QuotaRequestController::class, 'update'])->name('quota-requests.update');
        Route::delete('/quota-requests/{quotaRequest}', [QuotaRequestController::class, 'destroy'])->name('quota-requests.destroy');
        Route::resource('hero-banners', HeroBannerController::class)->except(['show']);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/instagram-reels', [InstagramReelController::class, 'index'])->name('instagram-reels.index');
        Route::post('/instagram-reels', [InstagramReelController::class, 'store'])->name('instagram-reels.store');
        Route::put('/instagram-reels/sort', [InstagramReelController::class, 'updateSort'])->name('instagram-reels.sort');
        Route::delete('/instagram-reels/{instagram_reel}', [InstagramReelController::class, 'destroy'])->name('instagram-reels.destroy');

        // Policy Pages
        Route::get('/policy-pages', [AdminPolicyPageController::class, 'index'])->name('policy-pages.index');
        Route::get('/policy-pages/{policy_page}/edit', [AdminPolicyPageController::class, 'edit'])->name('policy-pages.edit');
        Route::put('/policy-pages/{policy_page}', [AdminPolicyPageController::class, 'update'])->name('policy-pages.update');

        // FAQs
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/category/create', [FaqController::class, 'createCategory'])->name('faqs.create-category');
        Route::post('/faqs/category', [FaqController::class, 'storeCategory'])->name('faqs.store-category');
        Route::get('/faqs/category/{faq}/edit', [FaqController::class, 'editCategory'])->name('faqs.edit-category');
        Route::put('/faqs/category/{faq}', [FaqController::class, 'updateCategory'])->name('faqs.update-category');
        Route::delete('/faqs/category/{faq}', [FaqController::class, 'destroyCategory'])->name('faqs.destroy-category');
        Route::get('/faqs/category/{faq}/items', [FaqController::class, 'items'])->name('faqs.items');
        Route::get('/faqs/category/{faq}/items/create', [FaqController::class, 'createItem'])->name('faqs.create-item');
        Route::post('/faqs/category/{faq}/items', [FaqController::class, 'storeItem'])->name('faqs.store-item');
        Route::get('/faqs/category/{faq}/items/{item}/edit', [FaqController::class, 'editItem'])->name('faqs.edit-item');
        Route::put('/faqs/category/{faq}/items/{item}', [FaqController::class, 'updateItem'])->name('faqs.update-item');
        Route::delete('/faqs/category/{faq}/items/{item}', [FaqController::class, 'destroyItem'])->name('faqs.destroy-item');

        // Product reviews
        Route::get('/reviews', [ProductReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

        // Alerts
        Route::get('/alerts', function () {
            $lowStockCount = Product::where('stock_quantity', '<', 10)->where('is_active', true)->count();
            $pendingOrdersCount = Order::where('status', 'pending')->count();

            return view('admin.alerts.index', compact('lowStockCount', 'pendingOrdersCount'));
        })->name('alerts.index');

        // Main Categories Routes
        Route::get('/main-categories', function (Request $request) {
            $catalogCategoryIds = Product::edxBearingsCatalog()
                ->where('is_active', true)
                ->whereNotNull('category_id')
                ->distinct()
                ->pluck('category_id');

            $usedMainIds = Category::query()
                ->whereIn('id', $catalogCategoryIds)
                ->whereNotNull('main_category_id')
                ->distinct()
                ->pluck('main_category_id');

            $mainCategories = MainCategory::with('categories')
                ->when(! $request->boolean('show_all') && $usedMainIds->isNotEmpty(), function ($q) use ($usedMainIds) {
                    $q->whereIn('id', $usedMainIds);
                })
                ->orderBy('sort_order')
                ->get();

            return view('admin.main-categories.index', [
                'mainCategories' => $mainCategories,
                'showAll' => $request->boolean('show_all'),
            ]);
        })->name('main-categories.index');

        Route::get('/main-categories/create', function () {
            return view('admin.main-categories.create');
        })->name('main-categories.create');

        Route::post('/main-categories', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'hero_image' => 'nullable|image|max:5120',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'banner_images' => 'nullable|array|max:3',
                'banner_images.*' => 'nullable|image|max:2048',
                'banner_texts' => 'nullable|array|max:3',
                'banner_texts.*' => 'nullable|string|max:255',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'bottom_banner_text' => 'nullable|string|max:255',
                'testimonial_text' => 'nullable|string|max:1000',
                'additional_banner_image' => 'nullable|image|max:5120',
                'additional_banner_text' => 'nullable|string|max:255',
            ]);

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }

            if ($request->hasFile('hero_image')) {
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }

            $bannerImages = [];
            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }
            $validated['banner_images'] = ! empty($bannerImages) ? array_values($bannerImages) : null;

            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = ! empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }

            if ($request->hasFile('bottom_banner_image')) {
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }

            if ($request->hasFile('additional_banner_image')) {
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
            }

            MainCategory::create($validated);

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category created successfully!');
        })->name('main-categories.store');

        Route::get('/main-categories/{id}', function ($id) {
            $category = MainCategory::with('categories')->findOrFail($id);

            return view('admin.main-categories.show', compact('category'));
        })->name('main-categories.show');

        Route::get('/main-categories/{id}/edit', function ($id) {
            $category = MainCategory::findOrFail($id);

            return view('admin.main-categories.edit', compact('category'));
        })->name('main-categories.edit');

        Route::put('/main-categories/{id}', function (Request $request, $id) {
            $category = MainCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:main_categories,slug,'.$id,
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'remove_image' => 'nullable|boolean',
                'hero_image' => 'nullable|image|max:5120',
                'remove_hero_image' => 'nullable|boolean',
                'hero_text' => 'nullable|string|max:255',
                'hero_button_text' => 'nullable|string|max:100',
                'banner_images' => 'nullable|array|max:3',
                'banner_images.*' => 'nullable|image|max:2048',
                'remove_banner_image' => 'nullable|array',
                'banner_texts' => 'nullable|array|max:3',
                'banner_texts.*' => 'nullable|string|max:255',
                'bottom_banner_image' => 'nullable|image|max:5120',
                'remove_bottom_banner_image' => 'nullable|boolean',
                'bottom_banner_text' => 'nullable|string|max:255',
                'testimonial_text' => 'nullable|string|max:1000',
                'additional_banner_image' => 'nullable|image|max:5120',
                'remove_additional_banner_image' => 'nullable|boolean',
                'additional_banner_text' => 'nullable|string|max:255',
            ]);

            if ($request->filled('remove_image') && $request->remove_image == '1') {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image')->store('main-categories', 'public');
            }

            if ($request->filled('remove_hero_image') && $request->remove_hero_image == '1') {
                if ($category->hero_image) {
                    Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = null;
            } elseif ($request->hasFile('hero_image')) {
                if ($category->hero_image) {
                    Storage::disk('public')->delete($category->hero_image);
                }
                $validated['hero_image'] = $request->file('hero_image')->store('main-categories/hero', 'public');
            }

            $bannerImages = is_array($category->banner_images) ? $category->banner_images : [];
            $removeBannerImages = $request->input('remove_banner_image', []);

            if ($request->has('banner_images')) {
                foreach ($request->file('banner_images') as $index => $file) {
                    if ($file && $file->isValid()) {
                        if (isset($bannerImages[$index])) {
                            Storage::disk('public')->delete($bannerImages[$index]);
                        }
                        $bannerImages[$index] = $file->store('main-categories/banners', 'public');
                    }
                }
            }

            foreach ($removeBannerImages as $index => $remove) {
                if ($remove == '1' && isset($bannerImages[$index])) {
                    Storage::disk('public')->delete($bannerImages[$index]);
                    unset($bannerImages[$index]);
                }
            }

            $validated['banner_images'] = ! empty($bannerImages) ? array_values($bannerImages) : null;

            if ($request->has('banner_texts')) {
                $validated['banner_texts'] = array_filter($request->banner_texts ?? []);
                $validated['banner_texts'] = ! empty($validated['banner_texts']) ? array_values($validated['banner_texts']) : null;
            }

            if ($request->filled('remove_bottom_banner_image') && $request->remove_bottom_banner_image == '1') {
                if ($category->bottom_banner_image) {
                    Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = null;
            } elseif ($request->hasFile('bottom_banner_image')) {
                if ($category->bottom_banner_image) {
                    Storage::disk('public')->delete($category->bottom_banner_image);
                }
                $validated['bottom_banner_image'] = $request->file('bottom_banner_image')->store('main-categories/bottom-banner', 'public');
            }

            if ($request->filled('remove_additional_banner_image') && $request->remove_additional_banner_image == '1') {
                if ($category->additional_banner_image) {
                    Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = null;
            } elseif ($request->hasFile('additional_banner_image')) {
                if ($category->additional_banner_image) {
                    Storage::disk('public')->delete($category->additional_banner_image);
                }
                $validated['additional_banner_image'] = $request->file('additional_banner_image')->store('main-categories/additional-banner', 'public');
            }

            unset($validated['remove_image'], $validated['remove_hero_image'], $validated['remove_bottom_banner_image'], $validated['remove_additional_banner_image'], $validated['remove_banner_image']);

            $category->update($validated);

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category updated successfully!');
        })->name('main-categories.update');

        Route::delete('/main-categories/{id}', function ($id) {
            $category = MainCategory::findOrFail($id);
            $category->delete();

            return redirect()->route('admin.main-categories.index')->with('success', 'Main category deleted successfully!');
        })->name('main-categories.destroy');

        // Inventory Routes
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/product/{id}', function ($id) {
            $product = Product::with(['category', 'inventories'])->findOrFail($id);
            $masterColors = MasterColor::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();
            $masterSizes = MasterSize::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();

            return view('admin.inventory.product', compact('product', 'masterColors', 'masterSizes'));
        })->name('inventory.product');
        Route::post('/inventory/product/{id}', [InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/inventory/product/{id}/bulk', [InventoryController::class, 'bulkStore'])->name('inventory.bulk.store');
        Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

        // Product customizer (admin)
        Route::get('/customizer', [CustomizeSettingsController::class, 'index'])->name('customize.index');
        Route::put('/customizer', [CustomizeSettingsController::class, 'update'])->name('customize.update');

        // Color & Size Master
        Route::get('/color-size-master', [ColorSizeMasterController::class, 'index'])->name('color-size-master.index');
        Route::post('/color-size-master/colors', [ColorSizeMasterController::class, 'storeColor'])->name('color-size-master.store-color');
        Route::put('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'updateColor'])->name('color-size-master.update-color');
        Route::delete('/color-size-master/colors/{color}', [ColorSizeMasterController::class, 'destroyColor'])->name('color-size-master.destroy-color');
        Route::post('/color-size-master/sizes', [ColorSizeMasterController::class, 'storeSize'])->name('color-size-master.store-size');
        Route::put('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'updateSize'])->name('color-size-master.update-size');
        Route::delete('/color-size-master/sizes/{size}', [ColorSizeMasterController::class, 'destroySize'])->name('color-size-master.destroy-size');

        // Payments Route
        Route::get('/payments', function () {
            $payments = Order::where('payment_status', 'paid')->orderBy('created_at', 'desc')->paginate(20);

            return view('admin.payments.index', compact('payments'));
        })->name('payments.index');

        // Coupons Routes
        Route::get('/coupons', function () {
            $coupons = Coupon::with('usages')->orderBy('created_at', 'desc')->get();

            return view('admin.coupons.index', compact('coupons'));
        })->name('coupons.index');

        Route::get('/coupons/create', function () {
            $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();

            return view('admin.coupons.create', compact('mainCategories'));
        })->name('coupons.create');

        Route::post('/coupons', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:coupons,code',
                'description' => 'nullable|string',
                'main_category_ids' => 'nullable|array',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'is_active' => 'nullable|boolean',
                'usage_limit' => 'nullable|integer|min:1',
                'minimum_order_amount' => 'nullable|numeric|min:0',
            ]);

            Coupon::create($validated);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
        })->name('coupons.store');

        Route::get('/coupons/{id}', function ($id) {
            $coupon = Coupon::with(['usages.user', 'usages.order'])->findOrFail($id);

            return view('admin.coupons.show', compact('coupon'));
        })->name('coupons.show');

        Route::get('/coupons/{id}/edit', function ($id) {
            $coupon = Coupon::findOrFail($id);
            $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();

            return view('admin.coupons.edit', compact('coupon', 'mainCategories'));
        })->name('coupons.edit');

        Route::put('/coupons/{id}', function (Request $request, $id) {
            $coupon = Coupon::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:coupons,code,'.$id,
                'description' => 'nullable|string',
                'main_category_ids' => 'nullable|array',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'is_active' => 'nullable|boolean',
                'usage_limit' => 'nullable|integer|min:1',
                'minimum_order_amount' => 'nullable|numeric|min:0',
            ]);

            $coupon->update($validated);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
        })->name('coupons.update');

        Route::delete('/coupons/{id}', function ($id) {
            $coupon = Coupon::findOrFail($id);
            if ($coupon->usages()->count() > 0) {
                return redirect()->route('admin.coupons.index')->with('error', 'Cannot delete coupon with usage history!');
            }
            $coupon->delete();

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
        })->name('coupons.destroy');
    });
});
