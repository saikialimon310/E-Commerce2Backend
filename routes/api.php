<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/test', function () {
    return response()->json(["ok" => true]);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);




// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/address', [UserInformationController::class, 'store']);
    Route::get('/addresses', [UserInformationController::class, 'index']);
    Route::put('/address/{id}', [UserInformationController::class, 'update']);
    Route::delete('/address/{id}', [UserInformationController::class, 'destroy']);

});
