<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Interfaces\PaymentServiceInterface;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PDFDocument;

class BillPaymentService implements PaymentServiceInterface
{
    public function processPayment(Order $order, User $user): bool
    {
        // Generate invoice PDF
        $pdf = $this->generateBill($order, $user);

        // Store the PDF
        $billPath = 'bills/bill_'.$order->getId().'.pdf';
        $pdf->save(storage_path('app/public/'.$billPath));

        // Update order with invoice path and status
        $order->setInvoicePath($billPath);
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

    private function generateBill(Order $order, User $user): PDFDocument
    {
        $pdfData = [
            'order' => $order,
            'user' => $user,
            'orderedProducts' => $order->getOrderedProducts(),
            'date' => now()->format('F d, Y'),
            'qrLink' => config('app.url').'/orders/confirm/'.$order->getPaymentId(),
        ];

        return Pdf::loadView('pdf.bill', $pdfData);
    }
}
