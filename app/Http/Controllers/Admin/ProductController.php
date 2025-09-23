<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::all();

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['categories'] = ProductCategory::all();

        return view('admin.product.create')->with('viewData', $viewData);
    }

    public function delete(int $product_id): RedirectResponse
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return redirect()->route('admin.product.index');
    }

    public function edit(int $product_id): View
    {
        $viewData['product'] = Product::findOrFail($product_id);

        return view('admin.product.edit')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Product::rules());

        $product = new Product;
        $product->setName($request->name);
        $product->setDescription($request->description);
        $product->setPrice((int) $request->price * 100);
        $product->setStock((int) $request->stock);
        $product->setSku($request->sku);
        $product->setProductCategoryId((int) $request->product_category_id);
        $product->setBrand($request->brand);
        $product->setImage($request->image);
        $product->save();

        return redirect()->route('admin.product.index');
    }
}
