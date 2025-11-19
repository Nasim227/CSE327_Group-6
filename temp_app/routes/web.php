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

Route::post('/logout', [AuthController::class, 'logout_user'])->name('logout')->middleware('auth');
