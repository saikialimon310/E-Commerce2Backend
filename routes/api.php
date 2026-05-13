<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\Api\ProductsApiController;
use App\Http\Controllers\Api\ProductStoreApiController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/get-category', [ApiProductController::class, 'getCategory']);
Route::get('/get-product', [ApiProductController::class, 'getProduct']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Product Store
    Route::get('/user-products', [ProductStoreApiController::class, 'userProducts']);
    Route::post('/products', [ProductStoreApiController::class, 'store']);

    // Product Images and Status
    Route::delete('/product-image/{id}', [ProductsApiController::class, 'deleteImage']);
    Route::post('/product-status/{id}', [ProductsApiController::class, 'updateStatus']);

    // Addresses
    Route::post('/addresses', [UserInformationController::class, 'store']);
    Route::get('/addresses', [UserInformationController::class, 'index']);
    Route::put('/addresses/{id}', [UserInformationController::class, 'update']);
    Route::delete('/addresses/{id}', [UserInformationController::class, 'destroy']);
});
