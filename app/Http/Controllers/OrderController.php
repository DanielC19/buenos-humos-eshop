<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Interfaces\PaymentServiceInterface;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
        $cartProducts = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartProducts))->get();

        $cartService = new CartService($cartProducts, $products->all());

        if (! $cartService->checkStock()) {
            return redirect()->back()->with('error', __('One or more products in your cart are out of stock.'));
        }

        $paymentMethod = $request->input('payment_method', 'balance');

        $paymentService = app(PaymentServiceInterface::class, ['paymentMethod' => $paymentMethod]);

        $paymentId = uniqid('pay_', true);
        $paymentId = str_replace(['.', '/', '#'], '', $paymentId);

        $orderData = [
            'status' => OrderStatus::PENDING->value,
            'subtotal' => $cartService->calculateSubtotal(),
            'tax' => $cartService->calculateTax(),
            'shipping' => CartService::$SHIPPING_COST,
            'total' => $cartService->calculateTotal(),
            'payment_id' => $paymentId,
            'payment_method' => $paymentMethod,
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

        // Process payment using the injected service
        if (! $paymentService->processPayment($order, $request->user())) {
            // Rollback if payment fails
            foreach ($products as $product) {
                $product->setStock($product->getStock() + $cartProducts[$product->getId()]);
                $product->save();
            }
            $order->delete();

            return redirect()->back()->with('error', 'Payment failed. Insufficient balance.');
        }

        session()->forget('cart');

        return redirect()->route('orders.success', ['order_id' => $order->getId()]);
    }

    public function confirm(string $paymentId): RedirectResponse
    {
        $order = Order::where('payment_id', $paymentId)->firstOrFail();

        $order->setStatus(OrderStatus::CONFIRMED->value);
        $order->save();

        return redirect()->route('orders.success', ['order_id' => $order->getId()]);
    }

    public function success(int $orderId): View
    {
        $order = Order::findOrFail($orderId);

        if ($order->getUserId() !== auth()->user()->getId()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['newBalance'] = $order->getUser()->getBalance();
        $viewData['previousBalance'] = $viewData['newBalance'] + $order->getTotal();

        return view('orders.success')->with('viewData', $viewData);
    }
}
