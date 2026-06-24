<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatagoriApiContoller;
use App\Http\Controllers\Api\MyCartApiController;
use App\Http\Controllers\Api\MyOrderApiController;
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

Route::get('/categories', [CatagoriApiContoller::class, 'index']);
Route::get('/categories/{id}', [CatagoriApiContoller::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
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

        // Categories
    Route::post('/categories', [CatagoriApiContoller::class, 'store']);
    Route::put('/categories/{id}', [CatagoriApiContoller::class, 'update']);
    Route::delete('/categories/{id}', [CatagoriApiContoller::class, 'destroy']);

        // My Cart
    Route::get('/carts', [MyCartApiController::class, 'index']);
    Route::post('/carts', [MyCartApiController::class, 'store']);
    Route::get('/carts/{id}', [MyCartApiController::class, 'show']);
    Route::put('/carts/{id}', [MyCartApiController::class, 'update']);
    Route::delete('/carts/{id}', [MyCartApiController::class, 'destroy']);

        // My Orders
    Route::get('/my-orders', [MyOrderApiController::class, 'myOrders']);
    Route::get('/recent-orders', [MyOrderApiController::class, 'recentOrders']);
    Route::get('/my-order-saler', [MyOrderApiController::class, 'myOrderSaler']);
    Route::post('/orders', [MyOrderApiController::class, 'store']);
    Route::post('/orders/{id}/confirm', [MyOrderApiController::class, 'confirm']);
    Route::post('/orders/{id}/delivered', [MyOrderApiController::class, 'delivered']);
});
