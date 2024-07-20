<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenerateDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// HomeController
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/detail-transaction/{date}', [HomeController::class, 'detailTransactionInDay'])->middleware('auth');

// CategoryController
Route::get('/category', [CategoryController::class, 'index'])->middleware('auth');
Route::get("/edit-category/{code}", [CategoryController::class, 'edit'])->middleware('auth');

// TransactionController
Route::get('/create-transaction', [TransactionController::class, 'create'])->middleware('auth');
Route::get('/edit-transaction/{code}', [TransactionController::class, 'edit'])->middleware('auth');

// GenerateDataController
Route::get('/generate-data', [GenerateDataController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
