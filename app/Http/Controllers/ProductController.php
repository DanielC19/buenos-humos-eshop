<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $searchInput = $request->input('search');
        $mostSoldOrder = $request->input('mostSold');

        $products = Product::searchAndOrder($searchInput, $mostSoldOrder);

        $viewData = [];
        $viewData['products'] = $products;
        $viewData['breadcrumbs'] = [
            ['label' => __('Products'), 'url' => '#'],
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    public function show(int $productId): View
    {
        $product = Product::findOrFail($productId);

        $viewData = [];
        $viewData['product'] = $product;
        $viewData['breadcrumbs'] = [
            ['label' => __('Products'), 'url' => route('products.index')],
            ['label' => $product->getProductCategory()->getName(), 'url' => route('product-categories.show', ['category_id' => $product->getProductCategory()->getId()])],
            ['label' => $product->getName(), 'url' => '#'],
        ];

        return view('products.show')->with('viewData', $viewData);
    }
}
