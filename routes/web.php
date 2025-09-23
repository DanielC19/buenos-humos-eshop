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
