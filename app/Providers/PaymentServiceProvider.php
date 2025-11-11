<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\PaymentServiceInterface;
use App\Services\Payment\BalancePaymentService;
use App\Services\Payment\BillPaymentService;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, function ($app, $params) {
            $paymentMethod = $params['paymentMethod'] ?? null;

            return match ($paymentMethod) {
                'balance' => new BalancePaymentService,
                'invoice' => new BillPaymentService,
                default => throw new InvalidArgumentException('Invalid payment method'),
            };
        });
    }
}
