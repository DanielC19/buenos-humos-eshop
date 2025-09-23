<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function index(): View
    {
        $viewData['categories'] = ProductCategory::all();

        return view('admin.product-category.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.product-category.create');
    }

    public function destroy(int $categoryId): RedirectResponse
    {
        $category = ProductCategory::findOrFail($categoryId);
        $category->delete();

        return redirect()->route('admin.product-category.index');
    }

    public function edit(int $categoryId): View
    {
        $viewData['category'] = ProductCategory::findOrFail($categoryId);

        return view('admin.product-category.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $categoryId): RedirectResponse
    {
        $categoryData = $request->validate(ProductCategory::rules());

        $category = ProductCategory::findOrFail($categoryId);
        $category->update($categoryData);

        return redirect()->route('admin.product-category.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $categoryData = $request->validate(ProductCategory::rules());

        ProductCategory::create($categoryData);

        return redirect()->route('admin.product-category.index');
    }
}
