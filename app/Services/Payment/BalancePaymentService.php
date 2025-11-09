<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\User;

class BalancePaymentService implements PaymentServiceInterface
{
    public function processPayment(Order $order, User $user): bool
    {
        if (! $this->canPay($user, $order->getTotal())) {
            return false;
        }

        $newBalance = $user->getBalance() - $order->getTotal();
        $user->setBalance($newBalance);
        $user->save();

        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'Balance';
    }

    public function canPay(User $user, float $amount): bool
    {
        return $user->getBalance() >= $amount;
    }

    public function getPaymentDetails(User $user): array
    {
        return [
            'method' => $this->getPaymentMethodName(),
            'balance' => $user->getBalance(),
            'formatted_balance' => number_format($user->getBalance(), 2),
        ];
    }
}
