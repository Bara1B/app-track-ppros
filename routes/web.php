<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\Admin\UserController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/work-order/{workOrder}', [WorkOrderController::class, 'show'])->name('work-order.show');

    // API Routes (buat form cerdas)
    Route::get('/api/product/{kode}', [ProductApiController::class, 'getProductDetail']);
    Route::get('/api/product/{kode}/next-sequence', [ProductApiController::class, 'getNextSequence']);

    // Route buat export Excel
    Route::get('/work-orders/export', [DashboardController::class, 'export'])->name('work-orders.export');
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

    // Aksi-aksi lain yang butuh admin
    Route::post('/work-orders/tracking/{tracking}/complete', [WorkOrderController::class, 'completeStep'])->name('work-orders.tracking.complete');
    Route::post('/work-order/{workOrder}/products', [ProductController::class, 'store'])->name('work-order.products.store');
});
