<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 16px;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-bottom: 10px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }
        .logo {
            width: 200px;
            height: auto;
            display: block;
            margin: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('logo.png') }}" alt="Company Logo" class="logo">

        <h1>Invoice #{{ $invoice->invoice_number }}</h1>

        <p>Date: {{ $invoice->created_at->format('Y-m-d') }}</p>
        <p>Bill To:</p>
        <address>
            {{ $order->user->name }}<br>
            {{ $order->user->email }}
        </address>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Subtotal:</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Tax ({{ config('app.tax_rate') }}%):</td>
                    <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Total:</td>
                    <td>${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p>Payment Method: {{ $order->payment_method }}</p>
    </div>
</body>
</html>
