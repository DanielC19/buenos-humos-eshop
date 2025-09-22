<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/product-category', [ProductCategoryController::class, 'index'])->name('product-category.index');
    Route::get('/product-category/create', [ProductCategoryController::class, 'create'])->name('product-category.create');
    Route::post('/product-category/store', [ProductCategoryController::class, 'store'])->name('product-category.store');
    Route::delete('/product-category/destroy/{category_id}', [ProductCategoryController::class, 'destroy'])->name('product-category.destroy');
    Route::get('/product-category/edit/{category_id}', [ProductCategoryController::class, 'edit'])->name('product-category.edit');
    Route::put('/product-category/update/{category_id}', [ProductCategoryController::class, 'update'])->name('product-category.update');
});
