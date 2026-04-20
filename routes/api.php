<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class,'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('currencies', [CurrencyController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
});
