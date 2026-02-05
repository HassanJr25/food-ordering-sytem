<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Manual - No Laravel UI)
// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Authenticated Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Customer Menu Routes
Route::get('/menu', [App\Http\Controllers\Customer\MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{foodItem}', [App\Http\Controllers\Customer\MenuController::class, 'show'])->name('menu.show');

// Customer Cart Routes (Protected - must be logged in)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{foodItem}', [App\Http\Controllers\Customer\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cart}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [App\Http\Controllers\Customer\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\Customer\CartController::class, 'clear'])->name('cart.clear');
});
// Admin Routes - Protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('food-items', \App\Http\Controllers\Admin\FoodItemController::class);
});