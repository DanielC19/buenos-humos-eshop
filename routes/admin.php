<?php

declare(strict_types=1);

use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/productCategory', [ProductCategoryController::class, 'index'])->name('productCategory.index');
    Route::get('/productCategory/create', [ProductCategoryController::class, 'create'])->name('productCategory.create');
    Route::post('/productCategory/store', [ProductCategoryController::class, 'store'])->name('productCategory.store');
    Route::post('/productCategory/destroy/{category_id}', [ProductCategoryController::class, 'destroy'])->name('productCategory.destroy');
    Route::get('/productCategory/edit/{category_id}', [ProductCategoryController::class, 'edit'])->name('productCategory.edit');
    Route::put('/productCategory/update/{category_id}', [ProductCategoryController::class, 'update'])->name('productCategory.update');
});
