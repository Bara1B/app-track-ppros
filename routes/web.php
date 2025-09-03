<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Admin\StockOpnameController;
use App\Http\Controllers\Admin\OvermateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\Api\WorkOrderStatusController;

// Halaman utama & Auth
Route::get('/', [App\Http\Controllers\PublicHomeController::class, 'index'])->name('public.home');
Route::get('/public/work-orders', [App\Http\Controllers\PublicHomeController::class, 'workOrders'])->name('public.work-orders');
Route::get('/public/tracking/{workOrder}', [App\Http\Controllers\PublicHomeController::class, 'showTracking'])->name('public.tracking');

Auth::routes();

// Route untuk download template (bisa diakses tanpa login)
Route::get('/stock-opname/download-template', [StockOpnameController::class, 'downloadTemplate'])->name('stock-opname.download-template');

// ===================================================================
// GRUP UNTUK SEMUA USER YANG SUDAH LOGIN (ADMIN & USER BIASA)
// ===================================================================
Route::middleware(['auth'])->group(function () {
    // Rute yang bisa diakses SEMUA user
    // Rute dashboard sekarang jadi lebih dinamis
    Route::get('/workorder-dashboard/{status?}', [DashboardController::class, 'index'])->name('workorderdashboard');
    // Backward compatibility: redirect /dashboard ke rute baru
    Route::get('/dashboard/{status?}', function ($status = null) {
        return redirect()->route('workorderdashboard', ['status' => $status]);
    })->name('dashboard');

    Route::get('/work-order/{workOrder}', [WorkOrderController::class, 'show'])->name('work-order.show');

    // API Routes (buat form cerdas)
    Route::get('/api/product/{kode}', [ProductApiController::class, 'getProductDetail']);
    Route::get('/api/product/{kode}/next-sequence', [ProductApiController::class, 'getNextSequence']);

    // Route buat export Excel
    Route::get('/work-orders/export', [DashboardController::class, 'export'])->name('work-orders.export');

    // Rute buat update due date borongan
    Route::put('/work-orders/bulk-update-due-date', [WorkOrderController::class, 'bulkUpdateDueDate'])->name('work-orders.bulk-update-due-date');

    // Stock Opname Routes (User - View Only)
    Route::get('/stock-opname', [App\Http\Controllers\StockOpnameController::class, 'index'])->name('stock-opname.index');
    Route::get('/stock-opname/data/{fileId}', [App\Http\Controllers\StockOpnameController::class, 'showData'])->name('stock-opname.show-data');
    Route::get('/stock-opname/export/{fileId}', [App\Http\Controllers\StockOpnameController::class, 'exportData'])->name('stock-opname.export-data');

    // Overmate Routes (Public - accessible to all authenticated users)
    Route::get('/overmate', [OvermateController::class, 'index'])->name('overmate.index');

    // Legacy user pages no longer needed: redirect to public home
    Route::get('/home', function () {
        return redirect()->route('public.home');
    })->name('home');

    Route::get('/user/home', function () {
        return redirect()->route('public.home');
    })->name('user.home');

    Route::put('/work-orders/tracking/{tracking}/update-date', [WorkOrderController::class, 'updateTrackingDate'])->name('work-orders.tracking.update-date');

    Route::post('/work-orders/tracking/{tracking}/complete', [WorkOrderController::class, 'completeStep'])->name('work-orders.tracking.complete');

    // API Routes for selective DOM updates
    Route::get('/api/work-orders/{workOrder}/status', [WorkOrderStatusController::class, 'getStatus'])->name('api.work-orders.status');
    Route::get('/api/work-orders/{workOrder}/status/{status}', [WorkOrderStatusController::class, 'getStatusById'])->name('api.work-orders.status-by-id');
});

// ===================================================================
// GRUP UNTUK RUTE KHUSUS ADMIN
// ===================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    // User Management - Removed standalone users route, now handled in settings

    // Work Order Management (Create, Update, Delete)
    Route::get('/work-orders/create', [WorkOrderController::class, 'create'])->name('work-orders.create');
    Route::post('/work-orders', [WorkOrderController::class, 'store'])->name('work-orders.store');
    Route::get('/work-orders/{workOrder}/edit', [WorkOrderController::class, 'edit'])->name('work-orders.edit');
    Route::put('/work-orders/{workOrder}', [WorkOrderController::class, 'update'])->name('work-orders.update');
    Route::delete('/work-orders/{workOrder}', [WorkOrderController::class, 'destroy'])->name('work-orders.destroy');

    // Rute buat nampilin form tambah borongan
    Route::get('/work-orders/bulk-create', [WorkOrderController::class, 'bulkCreate'])->name('work-orders.bulk-create');

    // Rute buat ngeproses form-nya
    Route::post('/work-orders/bulk-store', [WorkOrderController::class, 'bulkStore'])->name('work-orders.bulk-store');

    // Aksi-aksi lain yang butuh admin
    Route::post('/work-order/{workOrder}/products', [ProductController::class, 'store'])->name('work-order.products.store');

    // Rute buat hapus borongan
    Route::delete('/work-orders', [WorkOrderController::class, 'bulkDestroy'])->name('work-orders.bulk-destroy');

    Route::get('/api/charts/monthly-wo', [ChartController::class, 'monthlyWorkOrders'])->name('charts.monthly-wo');

    // Admin Home
    Route::get('/admin/home', [App\Http\Controllers\Admin\AdminHomeController::class, 'index'])->name('admin.home');

    // Data Master Hub
    Route::get('/data-master', function () {
        return view('admin.data_master');
    })->name('admin.data-master');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('/settings/wo', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/wo', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/wo/reset', [SettingController::class, 'reset'])->name('settings.reset');

    // Overmate Master CRUD (Admin)
    Route::get('/overmate/create', [OvermateController::class, 'create'])->name('overmate.create');
    Route::post('/overmate', [OvermateController::class, 'store'])->name('overmate.store');
    // More specific routes must come BEFORE the general catch-all route
    Route::get('/overmate/{itemNumber}/edit', [OvermateController::class, 'editByItemNumber'])->name('overmate.edit');
    Route::put('/overmate/{itemNumber}', [OvermateController::class, 'updateByItemNumber'])->name('overmate.update');
    Route::delete('/overmate/{itemNumber}', [OvermateController::class, 'destroy'])->name('overmate.destroy');
    // General catch-all route for show (must come LAST)
    Route::get('/overmate/{itemNumber}', [OvermateController::class, 'show'])
        ->where('itemNumber', '^(?!create$).+')->name('overmate.show');

    // Work Order Data (Master Product) CRUD
    Route::get('/work-orders/data', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'index'])->name('work-orders.data.index');
    Route::get('/work-orders/data/create', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'create'])->name('work-orders.data.create');
    Route::post('/work-orders/data', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'store'])->name('work-orders.data.store');
    Route::get('/work-orders/data/{product}/edit', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'edit'])->name('work-orders.data.edit');
    Route::put('/work-orders/data/{product}', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'update'])->name('work-orders.data.update');
    Route::delete('/work-orders/data/{product}', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'destroy'])->name('work-orders.data.destroy');
    Route::post('/work-orders/data/import', [\App\Http\Controllers\Admin\WorkOrderDataController::class, 'import'])->name('work-orders.data.import');

    // User Management
    Route::get('/settings/users', [SettingController::class, 'users'])->name('admin.settings.users');
    Route::get('/settings/users/create', [SettingController::class, 'createUser'])->name('admin.settings.create-user');
    Route::post('/settings/users', [SettingController::class, 'storeUser'])->name('admin.settings.store-user');
    Route::get('/settings/users/{user}/edit', [SettingController::class, 'editUser'])->name('admin.settings.edit-user');
    Route::put('/settings/users/{user}', [SettingController::class, 'updateUser'])->name('admin.settings.update-user');
    Route::delete('/settings/users/{user}', [SettingController::class, 'destroyUser'])->name('admin.settings.destroy-user');

    // Admin Stock Opname Management (CRUD & Import)
    Route::prefix('admin')->group(function () {
        Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('admin.stock-opname.index');
        Route::get('/stock-opname/create', [StockOpnameController::class, 'create'])->name('admin.stock-opname.create');
        Route::post('/stock-opname/import', [StockOpnameController::class, 'import'])->name('admin.stock-opname.import');
        Route::post('/stock-opname/{fileId}/import-data', [StockOpnameController::class, 'importData'])->name('admin.stock-opname.import-data');
        Route::put('/stock-opname/{id}/stok-fisik', [StockOpnameController::class, 'updateStokFisik'])->name('admin.stock-opname.update-stok-fisik');
        Route::delete('/stock-opname/{fileId}', [StockOpnameController::class, 'deleteFile'])->name('admin.stock-opname.delete-file');
        Route::get('/stock-opname/data/{fileId}', [StockOpnameController::class, 'showData'])->name('admin.stock-opname.show-data');
        Route::get('/stock-opname/export/{fileId}', [StockOpnameController::class, 'exportData'])->name('admin.stock-opname.export-data');
        Route::get('/stock-opname/download-template', [StockOpnameController::class, 'downloadTemplate'])->name('admin.stock-opname.download-template');
    });
});

// Hapus API dev auto refresh - gunakan Vite HMR
