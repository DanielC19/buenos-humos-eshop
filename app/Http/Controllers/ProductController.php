<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData['products'] = Product::all();

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function delete(int $product_id): RedirectResponse
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return redirect()->route('product.index');
    }

    public function edit(int $product_id): View
    {
        $viewData['product'] = Product::findOrFail($product_id);

        return view('product.edit')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Product::rules());

        $product = new Product;
        $product->setName($request->name);
        $product->setDescription($request->description);
        $product->setPrice(($request->price));
        $product->setStock($request->stock);
        $product->save();

        return redirect()->route('product.index');
    }
}
