<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\User;

interface PaymentServiceInterface
{
    /**
     * Process the payment for an order
     */
    public function processPayment(Order $order, User $user): bool;

    /**
     * Get the payment method name
     */
    public function getPaymentMethodName(): string;

    /**
     * Check if the user can pay with this method
     */
    public function canPay(User $user, float $amount): bool;

    /**
     * Get payment details for display
     */
    public function getPaymentDetails(User $user): array;
}
