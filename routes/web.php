<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;

// 1. RUTE LOGIN & LOGOUT
Route::get('/login', [AuthController::class, 'customerLoginForm'])->name('login');
Route::get('/admin-login', [AuthController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. RUTE CUSTOMER (KATALOG & KERANJANG)
Route::get('/', [StorefrontController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [StorefrontController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [StorefrontController::class, 'cart'])->name('cart.index');
    Route::post('/checkout', [StorefrontController::class, 'checkout'])->name('checkout');
    Route::delete('/cart/remove/{id}', [StorefrontController::class, 'removeFromCart'])->name('cart.remove');
});

// 3. RUTE ADMIN & STAFF (BACKEND)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SaleController::class);
});