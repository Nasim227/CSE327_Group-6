<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show_login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_user']);
    Route::get('/register', [AuthController::class, 'show_register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_user']);
});

Route::middleware(['auth', 'prevent-back-history', 'check-status'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'userDashboard'])->name('dashboard');
});

Route::post('/logout', [AuthController::class, 'logout_user'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [App\Http\Controllers\AdminAuthController::class, 'login']);
        Route::get('/register', [App\Http\Controllers\AdminAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [App\Http\Controllers\AdminAuthController::class, 'register']);
    });

    // Authenticated Admin Routes
    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('logout');
        
        // User Management
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\DashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
        
        // Product Management
        Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    });
});
