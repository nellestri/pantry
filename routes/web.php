<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'showWelcome'])->name('welcome');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('food-items', FoodItemController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('donations', DonationController::class);

    // Admin routes with custom middleware
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });
});

// API routes for AJAX requests
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/food-items/search', [FoodItemController::class, 'search'])->name('api.food-items.search');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('api.stats');
});
