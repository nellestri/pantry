<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodItemController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);



// Protected Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::resource('food-items', FoodItemController::class);
    Route::post('/food-items/{foodItem}/consume', [FoodItemController::class, 'consume'])->name('food-items.consume');
    Route::get('/transactions', [FoodItemController::class, 'transactions'])->name('food-items.transactions');
});

// Home redirect
Route::get('/', function () {
    return redirect()->route('food-items.index');
});
