<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): View
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

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(Request $request): RedirectResponse
    {
        $productId = $request->input('productId');
        $quantity = (int) $request->input('quantity');

        $product = Product::findOrFail($productId);
        if (! $product->checkStock($quantity)) {
            return redirect()->back()->with('error', __('Insufficient stock for the requested quantity.'));
        }

        $cart = session()->get('cart', []);
        $cart[$productId] = $quantity;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', __('Product added to cart!'));
    }

    public function remove(Request $request): RedirectResponse
    {
        $productId = $request->input('productId');

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', __('Product removed from cart!'));
    }
}
