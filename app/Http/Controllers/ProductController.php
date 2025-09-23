<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

        return view('product.index')->with('viewData', $viewData);
    }

    public function show(int $productId): View
    {
        $product = Product::findOrFail($productId);

        $viewData = [];
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }

    public function cart(): View
    {
        $cartProducts = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartProducts))->get();

        $cartService = new CartService($cartProducts, $products->all());

        $viewData = [];
        $viewData['products'] = $products;
        $viewData['cartProducts'] = $cartProducts;
        $viewData['subtotal'] = $cartService->calculateSubtotal();
        $viewData['tax'] = $cartService->calculateTax();
        $viewData['shipping'] = $cartService::$SHIPPING_COST;
        $viewData['total'] = $cartService->calculateTotal();

        return view('product.cart')->with('viewData', $viewData);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $productId = $request->input('productId');
        $quantity = (int) $request->input('quantity');

        $product = Product::findOrFail($productId);
        if (! $product->checkStock($quantity)) {
            return redirect()->back()->with('error', 'Insufficient stock for the requested quantity.');
        }

        $cart = session()->get('cart', []);
        $cart[$productId] = $quantity;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart(Request $request): RedirectResponse
    {
        $productId = $request->input('productId');

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}
