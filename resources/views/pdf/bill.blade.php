<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Bill') }} #{{ $order->getId() }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2D1B69;
        }
        .header h1 {
            color: #2D1B69;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #84CC16;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px;
        }
        .customer-info {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background: #2D1B69;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .totals table {
            margin-left: auto;
            width: 300px;
        }
        .totals td {
            padding: 8px;
        }
        .totals .total-row {
            font-weight: bold;
            font-size: 16px;
            background: #f8f9fa;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('Buenos Humos') }}</h1>
        <p>{{ __('Your trusted smoke shop') }}</p>
    </div>

    <div class="invoice-info">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>{{ __('Invoice Number') }}:</strong> #{{ $order->getId() }}<br>
                    <strong>{{ __('Payment ID') }}:</strong> {{ $order->getPaymentId() }}<br>
                    <strong>{{ __('Date') }}:</strong> {{ $date }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>{{ __('Status') }}:</strong> {{ __(ucfirst($order->getStatus())) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="customer-info">
        <h3 style="margin-top: 0;">{{ __('Customer Information') }}</h3>
        <strong>{{ __('Name') }}:</strong> {{ $user->getFullName() }}<br>
        <strong>{{ __('Email') }}:</strong> {{ $user->getEmail() }}<br>
        <strong>{{ __('Phone') }}:</strong> {{ $user->getPhone() }}
    </div>

    <h3>{{ __('Order Items') }}</h3>
    <table class="items-table">
        <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderedProducts as $orderedProduct)
                <tr>
                    <td>{{ $orderedProduct->getProduct()->getName() }}</td>
                    <td>{{ $orderedProduct->getAmount() }}</td>
                    <td>${{ number_format($orderedProduct->getPrice(), 2) }}</td>
                    <td>${{ number_format($orderedProduct->getPrice() * $orderedProduct->getAmount(), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>{{ __('Subtotal') }}:</td>
                <td>${{ number_format($order->getSubtotal(), 2) }}</td>
            </tr>
            <tr>
                <td>{{ __('Shipping') }}:</td>
                <td>${{ number_format($order->getShipping(), 2) }}</td>
            </tr>
            <tr>
                <td>{{ __('Tax') }} (19%):</td>
                <td>${{ number_format($order->getTax(), 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>{{ __('Total') }}:</td>
                <td>${{ number_format($order->getTotal(), 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>{{ __('Thank you for your purchase!') }}</p>
        <p>{{ __('Buenos Humos - Premium smoke shop products') }}</p>
    </div>
</body>
</html>
