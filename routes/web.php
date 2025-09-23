<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('product-category/{category_id}', [ProductCategoryController::class, 'show'])->name('product-category.show');

Route::get('product', [ProductController::class, 'index'])->name('product.index');
Route::get('product/{product_id}', [ProductController::class, 'show'])->name('product.show');
Route::post('product/cart/add', [ProductController::class, 'addToCart'])->name('product.cart.add');
Route::delete('product/cart/remove', [ProductController::class, 'removeFromCart'])->name('product.cart.remove');

Route::get('cart', [ProductController::class, 'cart'])->name('product.cart');
