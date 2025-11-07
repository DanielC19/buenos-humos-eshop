<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::prefix('product-categories')->name('product-categories.')->group(function (): void {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ProductCategoryController::class, 'store'])->name('store');
        Route::delete('/destroy/{category_id}', [ProductCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/edit/{category_id}', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{category_id}', [ProductCategoryController::class, 'update'])->name('update');
    });

    Route::prefix('products')->name('products.')->group(function (): void {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::delete('/delete/{product_id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{product_id}', [ProductController::class, 'update'])->name('update');
    });
});
