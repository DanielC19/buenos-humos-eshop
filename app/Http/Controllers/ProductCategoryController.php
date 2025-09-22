<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function index(): View
    {
        $viewData['categories'] = ProductCategory::all();

        return view('productCategory.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('productCategory.create');
    }

    public function destroy(int $category_id): RedirectResponse
    {
        $category = ProductCategory::findOrFail($category_id);
        $category->delete();

        return redirect()->route('admin.product-category.index');
    }

    public function edit(int $category_id): View
    {
        $viewData['category'] = ProductCategory::findOrFail($category_id);

        return view('productCategory.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $category_id): RedirectResponse
    {
        $request->validate(ProductCategory::rules());
        $category = ProductCategory::findOrFail($category_id);
        $category->setName($request->name);
        $category->setDescription($request->description);
        $category->save();

        return redirect()->route('admin.product-category.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(ProductCategory::rules());
        $category = new ProductCategory;
        $category->setName($request->name);
        $category->setDescription($request->description);
        $category->save();

        return redirect()->route('admin.product-category.index');
    }
}
