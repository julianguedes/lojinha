<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth:api')->group(function(){

    Route::apiResource('products', ProductController::class); 
    Route::apiResource('carts', CartController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', UserController::class);

    Route::put('/carts/{cart}/add-product', [CartController::class, 'addProduct'])->name('add-product');
    Route::delete('/carts/{cart}/remove-product', [CartController::class, 'removeProduct'])->name('remove-product');
    Route::delete('/carts/{cart}/remove-all-products', [CartController::class, 'removeAllProducts'])->name('remove-all-product');

});



