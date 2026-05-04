<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AvailableProductController;
use App\Http\Controllers\MyCartController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Categories
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::post('/categories/delete/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete');

    // Products
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductsController::class, 'destroy'])->name('products.delete');
    Route::put('/products/status/{id}', [ProductsController::class, 'updateStatus'])->name('products.status.update');
    Route::delete('/product-image/{id}', [ProductsController::class, 'deleteImage'])->name('product-image.delete');

    //Available_Products
    Route::get('/available-products', [AvailableProductController::class, 'index'])->name('available-products.index');
    Route::get('/available-products/create', [AvailableProductController::class, 'create'])->name('available-products.create');
    Route::post('/available-products/store', [AvailableProductController::class, 'store'])->name('available-products.store');
    Route::get('/available-products/edit/{id}', [AvailableProductController::class, 'edit'])->name('available-products.edit');
    Route::post('/available-products/update/{id}', [AvailableProductController::class, 'update'])->name('available-products.update');
    Route::post('/available-products/delete/{id}', [AvailableProductController::class, 'destroy'])->name('available-products.delete');
    Route::put('/available-products/status/{id}', [AvailableProductController::class, 'updateStatus'])->name('available-products.status.update');


    Route::get('/carts', [MyCartController::class, 'index'])->name('carts.index');
});