<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class); 
Route::apiResource('carts', CartController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('users', UserController::class);

Route::put('/carts/{cart}/add-product', [CartController::class, 'addProduct']);
Route::delete('/carts/{cart}/remove-product', [CartController::class, 'removeProduct']);
Route::delete('/carts/{cart}/remove-all-products', [CartController::class, 'removeAllProducts']);
