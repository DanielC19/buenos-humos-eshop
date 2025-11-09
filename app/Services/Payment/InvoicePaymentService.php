<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePaymentService implements PaymentServiceInterface
{
    public function processPayment(Order $order, User $user): bool
    {
        // Generate invoice PDF
        $pdf = $this->generateInvoice($order, $user);

        // Store the PDF
        $invoicePath = 'invoices/invoice_'.$order->getId().'.pdf';
        $pdf->save(storage_path('app/public/'.$invoicePath));

        // Update order with invoice path and status
        $order->setInvoicePath($invoicePath);
        $order->setStatus(OrderStatus::PENDING->value); // Order is pending until payment is received
        $order->save();

        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'Invoice';
    }

    public function canPay(User $user, float $amount): bool
    {
        // Invoice can always be generated
        return true;
    }

    public function getPaymentDetails(User $user): array
    {
        return [
            'method' => $this->getPaymentMethodName(),
            'description' => __('Generate PDF invoice for your order'),
        ];
    }

    private function generateInvoice(Order $order, User $user): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'order' => $order,
            'user' => $user,
            'orderedProducts' => $order->getOrderedProducts(),
            'date' => now()->format('F d, Y'),
        ];

        return Pdf::loadView('invoices.order', $data);
    }
}
