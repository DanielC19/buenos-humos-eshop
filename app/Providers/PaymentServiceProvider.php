<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PaymentServiceInterface;
use App\Services\Payment\BalancePaymentService;
use App\Services\Payment\InvoicePaymentService;
use InvalidArgumentException;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, function ($app, $params) {
            $paymentMethod = $params["paymentMethod"] ?? null;
            return match ($paymentMethod) {
                'balance' => new BalancePaymentService(),
                'invoice' => new InvoicePaymentService(),
                default => throw new InvalidArgumentException("Invalid payment method"),
            };
        });
    }
}
