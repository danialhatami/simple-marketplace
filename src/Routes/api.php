<?php

use Danial\SimpleMarketplace\Http\Controllers\AuthController;
use Danial\SimpleMarketplace\Http\Controllers\MarketplaceUserController;
use Danial\SimpleMarketplace\Http\Controllers\OrderController;
use Danial\SimpleMarketplace\Http\Controllers\ProductController;
use Danial\SimpleMarketplace\Models\Order;
use Illuminate\Support\Facades\Route;

Route::middleware('bindings')->prefix('api/v1')->name('api.v1.')->group(function () {

    Route::group(['prefix' => 'user'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('profile', [AuthController::class, 'userProfile'])->name('user_profile.get');
            Route::get('orders', [MarketplaceUserController::class, 'userOrders'])->name('user_orders.get');
            Route::get('products', [MarketplaceUserController::class, 'userProducts'])->name('user_products.get');
        });
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index.get');
        Route::get('{product}', [ProductController::class, 'show'])->name('show.get');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('create', [ProductController::class, 'create'])->name('create.post');
            Route::delete('{product}', [ProductController::class, 'delete'])->name('destroy.delete')
                ->middleware('can:delete,product');
        });
    });

    Route::prefix('order')->name('order.')->middleware('auth:sanctum')->group(function () {
        Route::get('', [OrderController::class, 'index'])->name('index.get')->can('viewAny', Order::class);
        Route::post('', [OrderController::class, 'create'])->name('create.post')->can('create', Order::class);
        Route::get('{order}', [OrderController::class, 'show'])->name('show.get')->middleware('can:view,order');
    });
});
