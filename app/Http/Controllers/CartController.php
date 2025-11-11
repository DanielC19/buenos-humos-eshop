<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\CurrencyExchangeService;
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
        $exchangeService = app(CurrencyExchangeService::class);

        $subtotal = $cartService->calculateSubtotal();
        $tax = $cartService->calculateTax();
        $shipping = $cartService::$SHIPPING_COST;
        $total = $cartService->calculateTotal();

        $viewData = [];
        $viewData['products'] = $products;
        $viewData['cartProducts'] = $cartProducts;
        $viewData['subtotal'] = $exchangeService->formatMoney($subtotal);
        $viewData['tax'] = $exchangeService->formatMoney($tax);
        $viewData['shipping'] = $exchangeService->formatMoney($shipping);
        $viewData['total'] = $exchangeService->formatMoney($total);

        // Add user balance for payment
        if (auth()->check()) {
            $viewData['userBalance'] = auth()->user()->getDisplayBalance();
            $viewData['canPayWithBalance'] = auth()->user()->getBalance() >= $total;
        } else {
            $viewData['userBalance'] = 0;
            $viewData['canPayWithBalance'] = false;
        }

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
