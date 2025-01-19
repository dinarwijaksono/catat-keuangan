<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Middleware\CheckTokenMiddeware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/register', [AuthController::class, 'doRegister']);
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get("/current-user", [AuthController::class, 'getCurrentUser'])->middleware(CheckTokenMiddeware::class);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware(CheckTokenMiddeware::class);

// CategoryController
Route::post('/create-category', [CategoryController::class, 'create'])->middleware(CheckTokenMiddeware::class);
Route::get('/category/get-all', [CategoryController::class, 'getAll'])->middleware(CheckTokenMiddeware::class);
