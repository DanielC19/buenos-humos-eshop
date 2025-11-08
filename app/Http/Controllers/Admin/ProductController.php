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
    public function index(Request $request): View
    {
        $viewData = [];
        $search = $request->query('search');

        if ($search) {
            $viewData['products'] = Product::where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%")
                ->get();
        } else {
            $viewData['products'] = Product::all();
        }

        $viewData['search'] = $search;

        return view('admin.products.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['categories'] = ProductCategory::all();

        return view('admin.products.create')->with('viewData', $viewData);
    }

    public function destroy(int $product_id): RedirectResponse
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return redirect()->route('admin.products.index');
    }

    public function edit(int $product_id): View
    {
        $viewData = [];
        $viewData['categories'] = ProductCategory::all();
        $viewData['product'] = Product::findOrFail($product_id);

        return view('admin.products.edit')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $productData = $request->validate(Product::rules());
        $productData['price'] = $productData['price'] * 100;
        Product::create($productData);

        return redirect()->route('admin.products.index');
    }

    public function update(Request $request, int $product_id): RedirectResponse
    {
        $productData = $request->validate(Product::rules($product_id));
        $productData['price'] = $productData['price'] * 100;
        $product = Product::findOrFail($product_id);
        $product->update($productData);

        return redirect()->route('admin.products.index');
    }
}
