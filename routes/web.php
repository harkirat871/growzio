<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use Google\Client as GoogleClient;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/viewer', function () {
    return view('pdf-viewer');
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'searchResults'])->name('search.results');
Route::get('/search/suggestions', [ProductController::class, 'searchSuggestions'])->name('search.suggestions');

Route::get('/dashboard', function () {
    $user = Auth::user();
    if (Auth::check() && $user instanceof \App\Models\User && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return app(DashboardController::class)->index(request());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::get('/cart/drawer', [CartController::class, 'drawerData'])->name('cart.drawer');
Route::post('/cart/loyalty', [CartController::class, 'applyLoyalty'])->middleware('auth')->name('cart.loyalty');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');

// Public page shown when a guest tries to access checkout
Route::get('/checkout/login-required', [CheckoutController::class, 'loginRequired'])->name('checkout.login-required');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // // Role upgrade routes
    // Route::get('/upgrade-role', [RoleController::class, 'upgradeForm'])->name('upgrade.role');
    // Route::post('/upgrade-role', [RoleController::class, 'upgrade'])->name('upgrade.role.store');

    // Cart and checkout (only for authenticated users)
    Route::put('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');

// Seller routes removed — one-vendor: admin panel handles all (admin = seller)

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', OrderAdminController::class)->only(['index','show','update']);
    Route::get('/customers/export', [\App\Http\Controllers\Admin\CustomerController::class, 'exportCsv'])->name('customers.export');
    Route::get('/customers/{customer}/export', [\App\Http\Controllers\Admin\CustomerController::class, 'exportCustomerSummary'])->name('customers.export.summary');
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show'])->parameters(['customers' => 'customer']);
    Route::get('/products/bulk-upload', [\App\Http\Controllers\Admin\BulkUploadController::class, 'showForm'])->name('products.bulk-upload');
    Route::get('/products/bulk-upload/template', [\App\Http\Controllers\Admin\BulkUploadController::class, 'downloadTemplate'])->name('products.bulk-upload.template');
    Route::post('/products/bulk-upload', [\App\Http\Controllers\Admin\BulkUploadController::class, 'process'])->name('products.bulk-upload.process');
    Route::get('/products/bulk-update/template', [\App\Http\Controllers\Admin\BulkUploadController::class, 'downloadBulkUpdateTemplate'])->name('products.bulk-update.template');
    Route::post('/products/bulk-update', [\App\Http\Controllers\Admin\BulkUploadController::class, 'processBulkUpdate'])->name('products.bulk-update.process');
    Route::post('/products/bulk-upload/zip-images', [\App\Http\Controllers\Admin\BulkUploadController::class, 'processZipImages'])->name('products.bulk-upload.zip-images');
    Route::get('/products/destroy-all', [\App\Http\Controllers\Admin\ProductController::class, 'destroyAllConfirm'])->name('products.destroy-all.confirm');
    Route::delete('/products/destroy-all', [\App\Http\Controllers\Admin\ProductController::class, 'destroyAll'])->name('products.destroy-all');
    Route::get('/products/delete-products', [\App\Http\Controllers\Admin\ProductController::class, 'deleteProductsPage'])->name('products.delete-products');
    Route::post('/products/delete-products/by-category', [\App\Http\Controllers\Admin\ProductController::class, 'destroyProductsByCategories'])->name('products.delete-products.by-category');
    Route::delete('/products/delete-products/destroy-all', [\App\Http\Controllers\Admin\ProductController::class, 'destroyAllFromDeletePage'])->name('products.delete-products.destroy-all');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});

Route::get('/debug/cart-test', function() {
    return response()->json([
        'message' => 'Cart test route working',
        'routes' => [
            'cart.add' => route('cart.add', 1),
            'cart.view' => route('cart.view'),
        ]
    ]);
})->name('debug.cart');

// STEP 1 — ENV & FILE VALIDATION ROUTE
Route::get('/debug/google-sheets/env', function () {
    $credentialsPath = config('services.google.credentials_path');
    $resolvedPath = is_string($credentialsPath) ? base_path($credentialsPath) : null;
    $fileExists = $resolvedPath && is_file($resolvedPath);
    $spreadsheetId = config('services.google.sheet_id');

    return response()->json([
        'credentials_path_raw' => $credentialsPath,
        'credentials_path_resolved' => $resolvedPath,
        'credentials_file_exists' => $fileExists,
        'spreadsheet_id' => $spreadsheetId,
    ]);
})->name('debug.google.env');

// STEP 2 — FORCE GOOGLE SHEETS WRITE ROUTE
Route::get('/debug/google-sheets/force-write', function () {
    $credentialsPath = config('services.google.credentials_path');
    $resolvedPath = is_string($credentialsPath) ? base_path($credentialsPath) : null;
    $spreadsheetId = config('services.google.sheet_id');

    if (! $credentialsPath || ! $resolvedPath || ! is_file($resolvedPath)) {
        abort(500, 'Google credentials path is missing or file does not exist.');
    }

    if (! $spreadsheetId) {
        abort(500, 'GOOGLE_SHEET_ID is missing.');
    }

    $client = new GoogleClient();
    $client->setAuthConfig($resolvedPath);
    $client->addScope(Sheets::SPREADSHEETS);

    $service = new Sheets($client);

    $rows = [
        ['FORCED TEST', 'If this appears, API works', now()->toDateTimeString()],
        ['', '', ''],
    ];

    $body = new ValueRange();
    $body->setValues($rows);

    // Append to Sheet1 explicitly
    $service->spreadsheets_values->append(
        $spreadsheetId,
        'Sheet1!A:C',
        $body,
        ['valueInputOption' => 'USER_ENTERED']
    );

    return response()->json([
        'status' => 'ok',
        'message' => 'Forced test row appended to Sheet1.',
    ]);
})->name('debug.google.force-write');

require __DIR__.'/auth.php';
