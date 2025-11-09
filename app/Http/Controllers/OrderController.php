<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Services\CartService;
use App\Services\Payment\BalancePaymentService;
use App\Services\Payment\InvoicePaymentService;
use App\Services\Payment\PaymentServiceInterface;
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

        $paymentMethod = $request->input('payment_method', 'balance');

        // Dependency Injection - Get the appropriate payment service
        $paymentService = $this->getPaymentService($paymentMethod);

        $orderData = [
            'status' => OrderStatus::CONFIRMED->value,
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

        // Store balance before payment for display
        $previousBalance = $request->user()->getBalance();

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

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['paymentMethod'] = $paymentMethod;

        // Add balance information for balance payments
        if ($paymentMethod === 'balance') {
            $viewData['previousBalance'] = $previousBalance;
            $viewData['newBalance'] = $request->user()->getBalance();
            $viewData['paidAmount'] = $order->getTotal();
        }

        return view('orders.success')->with('viewData', $viewData);
    }

    private function getPaymentService(string $method): PaymentServiceInterface
    {
        return match ($method) {
            'balance' => new BalancePaymentService,
            'invoice' => new InvoicePaymentService,
            default => new BalancePaymentService,
        };
    }
}
