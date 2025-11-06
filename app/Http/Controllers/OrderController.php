<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request): View|RedirectResponse
    {
        $cartProducts = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartProducts))->get();

        $cartService = new CartService($cartProducts, $products->all());

        if (! $cartService->checkStock()) {
            return redirect()->back()->with('error', 'One or more products in your cart are out of stock.');
        }

        $orderData = [
            'status' => 'confirmed',
            'subtotal' => $cartService->calculateSubtotal(),
            'tax' => $cartService->calculateTax(),
            'shipping' => CartService::$SHIPPING_COST,
            'total' => $cartService->calculateTotal(),
            'payment_id' => uniqid('pay_', true),
            'user_id' => $request->user()->getId(),
        ];
        $order = Order::create($orderData);

        foreach ($products as $product) {
            $orderedProductData = [
                'amount' => $cartProducts[$product->getId()],
                'price' => $product->getPrice(),
                'order_id' => $order->getId(),
                'product_id' => $product->getId(),
            ];
            OrderedProduct::create($orderedProductData);
            $product->setStock($product->getStock() - $cartProducts[$product->getId()]);
            $product->save();
        }

        session()->forget('cart');

        $viewData = [];
        $viewData['order'] = $order;

        return view('orders.success')->with('viewData', $viewData);
    }
}
