<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\ShippingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes (Laravel automatically adds /api prefix)
// Home & Products (Public)
Route::get('/home', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/by-id/{id}', [ProductController::class, 'showById']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/settings', [SettingController::class, 'index']);
Route::get('/hero-banners', [HomeController::class, 'heroBanners']);
Route::get('/ui-settings', [SettingController::class, 'uiSettings']);

// Cart (Public - uses session/cookie)
Route::prefix('cart')->group(function () {
    Route::get('/count', [CartController::class, 'count']);
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update/{id}', [CartController::class, 'update']);
    Route::delete('/remove/{id}', [CartController::class, 'remove']);
    Route::post('/check', [CartController::class, 'check']);
});

// Shipping & Coupons (Public)
Route::post('/shipping/calculate', [ShippingController::class, 'calculate']);
Route::post('/coupons/validate', [CouponController::class, 'validate']);

// Authentication (Public)
Route::prefix('auth')->group(function () {
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/customer-login', [AuthController::class, 'customerLogin']);
    Route::post('/admin-login', [AuthController::class, 'adminLogin']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Orders (Guest checkout supported)
Route::post('/orders', [OrderController::class, 'store']); // Public route for guest checkout

// Customer Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // Addresses
    Route::apiResource('addresses', AddressController::class);
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault']);

    // Orders (Authenticated only)
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice']);
});

// Payment Routes (Public - No Authentication Required)
Route::get('/payments/test-config', [PaymentController::class, 'testConfig']);
Route::post('/payments/create-order', [PaymentController::class, 'createOrder']);
Route::post('/payments/verify', [PaymentController::class, 'verify']);
Route::get('/payments/status/{orderId}', [PaymentController::class, 'status']);

// OTP Routes (Public - No Authentication Required)
Route::post('/otp/send', [App\Http\Controllers\Api\OTPController::class, 'sendOTP']);
Route::post('/otp/verify', [App\Http\Controllers\Api\OTPController::class, 'verifyOTP']);
Route::post('/otp/resend', [App\Http\Controllers\Api\OTPController::class, 'resendOTP']);
Route::get('/otp/check-verification', [App\Http\Controllers\Api\OTPController::class, 'checkVerification']);

// Mobile Authentication Routes (Public)
Route::post('/auth/register/send-otp', [App\Http\Controllers\Api\MobileAuthController::class, 'sendRegistrationOTP']);
Route::post('/auth/register/verify', [App\Http\Controllers\Api\MobileAuthController::class, 'verifyAndRegister']);
Route::post('/auth/login/send-otp', [App\Http\Controllers\Api\MobileAuthController::class, 'sendLoginOTP']);
Route::post('/auth/login/verify', [App\Http\Controllers\Api\MobileAuthController::class, 'verifyAndLogin']);
Route::post('/auth/login/resend-otp', [App\Http\Controllers\Api\MobileAuthController::class, 'resendLoginOTP']);

// Test route for debugging
Route::post('/auth/test', function(Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Test endpoint working',
        'received_data' => $request->all()
    ]);
});

// Test MSG91 directly
Route::post('/test-msg91', function(Request $request) {
    $mobile = $request->mobile ?? '8839507322';
    $otp = rand(100000, 999999);
    
    // Show what we're sending
    $templateId = config('services.msg91.template_id');
    $authKey = config('services.msg91.auth_key');
    
    // Get server IP
    $serverIp = file_get_contents('https://ipinfo.io/ip');
    
    $payload = [
        'template_id' => $templateId,
        'short_url' => '0',
        'realTimeResponse' => '1',
        'recipients' => [
            [
                'mobiles' => '91' . $mobile,
                'VAR1' => $otp,
                'OTP' => $otp,
            ]
        ]
    ];
    
    $response = Http::withHeaders([
        'accept' => 'application/json',
        'authkey' => $authKey,
        'content-type' => 'application/json'
    ])->post('https://control.msg91.com/api/v5/flow', $payload);
    
    return response()->json([
        'server_ip' => trim($serverIp),
        'debug_info' => [
            'template_id' => $templateId,
            'template_id_empty' => empty($templateId),
            'auth_key_length' => strlen($authKey),
            'payload' => $payload
        ],
        'response_status' => $response->status(),
        'response_body' => $response->json(),
        'success' => $response->successful()
    ]);
});

// Admin Routes (Requires Authentication + Admin)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);

    // Hero Banners
    Route::apiResource('hero-banners', App\Http\Controllers\Api\Admin\HeroBannerController::class);

    // Settings
    Route::get('/settings', [App\Http\Controllers\Api\Admin\SettingController::class, 'index']);
    Route::post('/settings', [App\Http\Controllers\Api\Admin\SettingController::class, 'update']);
    Route::post('/ui-settings', [App\Http\Controllers\Api\Admin\SettingController::class, 'updateUiSettings']);

    // Products
    Route::apiResource('products', App\Http\Controllers\Api\Admin\ProductController::class);
    Route::post('/products/{id}/toggle-active', [App\Http\Controllers\Api\Admin\ProductController::class, 'toggleActive']);

    // Inventory
    Route::get('/inventory/product/{id}', [App\Http\Controllers\Api\Admin\InventoryController::class, 'show']);
    Route::post('/inventory/product/{id}', [App\Http\Controllers\Api\Admin\InventoryController::class, 'update']);
    Route::get('/inventory/product/{id}/total-stock', [App\Http\Controllers\Api\Admin\InventoryController::class, 'totalStock']);
    Route::delete('/inventory/{id}', [App\Http\Controllers\Api\Admin\InventoryController::class, 'destroy']);

    // Categories
    Route::apiResource('main-categories', App\Http\Controllers\Api\Admin\MainCategoryController::class);
    Route::post('/main-categories/{id}/toggle-active', [App\Http\Controllers\Api\Admin\MainCategoryController::class, 'toggleActive']);
    Route::apiResource('categories', App\Http\Controllers\Api\Admin\CategoryController::class);
    Route::post('/categories/{id}/toggle-active', [App\Http\Controllers\Api\Admin\CategoryController::class, 'toggleActive']);

    // Orders
    Route::get('/orders', [App\Http\Controllers\Api\Admin\OrderController::class, 'index']);
    Route::get('/orders/{id}', [App\Http\Controllers\Api\Admin\OrderController::class, 'show']);
    Route::put('/orders/{id}', [App\Http\Controllers\Api\Admin\OrderController::class, 'update']);
    Route::post('/orders/{id}/cancel', [App\Http\Controllers\Api\Admin\OrderController::class, 'cancel']);
    Route::get('/orders/{id}/invoice', [App\Http\Controllers\Api\Admin\OrderController::class, 'invoice']);

    // Payments History
    Route::get('/payments-history', [App\Http\Controllers\Api\Admin\PaymentHistoryController::class, 'index']);
    Route::get('/payments-history/{id}', [App\Http\Controllers\Api\Admin\PaymentHistoryController::class, 'show']);
    Route::get('/payments-history/statistics', [App\Http\Controllers\Api\Admin\PaymentHistoryController::class, 'statistics']);
    Route::get('/payments-history/analytics', [App\Http\Controllers\Api\Admin\PaymentHistoryController::class, 'analytics']);
    Route::get('/payments-history/export', [App\Http\Controllers\Api\Admin\PaymentHistoryController::class, 'export']);

    // Shiprocket Integration (delivery)
    Route::post('/orders/{id}/shiprocket/create-shipment', [App\Http\Controllers\Api\Admin\ShiprocketController::class, 'createShipment']);
    Route::get('/orders/{id}/shiprocket/track', [App\Http\Controllers\Api\Admin\ShiprocketController::class, 'track']);

    // Delhivery Integration
    Route::post('/orders/{id}/delhivery/create-shipment', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'createShipment']);
    Route::get('/orders/{id}/delhivery/track', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'track']);
    Route::post('/orders/{id}/delhivery/cancel', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'cancel']);
    Route::post('/delhivery/create-pickup-request', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'createPickupRequest']);
    Route::get('/delhivery/check-pincode', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'checkPincode']);
    Route::get('/delhivery/delivery-estimate', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'deliveryEstimate']);
    Route::get('/orders/{id}/delhivery/print-label', [App\Http\Controllers\Api\Admin\DelhiveryController::class, 'printLabel']);

    // Admin & Customer Management
    Route::apiResource('admins', App\Http\Controllers\Api\Admin\AdminController::class);
    Route::get('/customers', [App\Http\Controllers\Api\Admin\CustomerController::class, 'index']);
    Route::get('/customers/{id}', [App\Http\Controllers\Api\Admin\CustomerController::class, 'show']);
    Route::put('/customers/{id}', [App\Http\Controllers\Api\Admin\CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [App\Http\Controllers\Api\Admin\CustomerController::class, 'destroy']);

    // Coupons
    Route::apiResource('coupons', App\Http\Controllers\Api\Admin\CouponController::class);

    // Reports & Alerts
    Route::get('/reports', [App\Http\Controllers\Api\Admin\ReportController::class, 'index']);
    Route::get('/reports/download', [App\Http\Controllers\Api\Admin\ReportController::class, 'download']);
    Route::get('/alerts', [App\Http\Controllers\Api\Admin\AlertController::class, 'index']);
});

// Webhook Routes (Public - no auth required)
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);

