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
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\DevController;

// Halaman utama & Auth
Route::get('/', function () {
    return redirect()->route('login');
});
Auth::routes();

// ===================================================================
// GRUP UNTUK SEMUA USER YANG SUDAH LOGIN (ADMIN & USER BIASA)
// ===================================================================
Route::middleware(['auth'])->group(function () {
    // Rute yang bisa diakses SEMUA user
    // Rute dashboard sekarang jadi lebih dinamis
    Route::get('/dashboard/{status?}', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/work-order/{workOrder}', [WorkOrderController::class, 'show'])->name('work-order.show');

    // API Routes (buat form cerdas)
    Route::get('/api/product/{kode}', [ProductApiController::class, 'getProductDetail']);
    Route::get('/api/product/{kode}/next-sequence', [ProductApiController::class, 'getNextSequence']);

    // Route buat export Excel
    Route::get('/work-orders/export', [DashboardController::class, 'export'])->name('work-orders.export');

    // Rute buat update due date borongan
    Route::put('/work-orders/bulk-update-due-date', [WorkOrderController::class, 'bulkUpdateDueDate'])->name('work-orders.bulk-update-due-date');

    Route::resource('stock-opname', StockOpnameController::class);

    Route::resource('stock-opname', StockOpnameController::class);

    // Rute API buat ngambil detail overmate
    Route::get('/api/overmate-details/{master}', [StockOpnameController::class, 'getOvermateDetails'])->name('api.overmate.details');

    Route::get('/home', [DashboardController::class, 'home'])->name('home');

    Route::put('/work-orders/tracking/{tracking}/update-date', [WorkOrderController::class, 'updateTrackingDate'])->name('work-orders.tracking.update-date');

    Route::post('/work-orders/tracking/{tracking}/complete', [WorkOrderController::class, 'completeStep'])->name('work-orders.tracking.complete');
});

// ===================================================================
// GRUP UNTUK RUTE KHUSUS ADMIN
// ===================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    // User Management
    Route::resource('users', UserController::class);

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

    // Settings
    Route::get('/settings/wo', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/wo', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/wo/reset', [SettingController::class, 'reset'])->name('settings.reset');
});

// Hapus API dev auto refresh - gunakan Vite HMR
