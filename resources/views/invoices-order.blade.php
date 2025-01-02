<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
        }
        .artist-details {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>
    <h3>Customer Details</h3>
    <p>
        Name: {{ $order->name }}<br>
        Address: {{ $order->street }}, {{ $order->barangay }}, {{ $order->city }}, {{ $order->state }}, {{ $order->zip_code }}<br>
        Phone: {{ $order->phone }}
    </p>
    <h3>Order Details</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Artist</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        {{ $item->product->artist->name }}<br>
                        Email: {{ $item->product->artist->email }}<br>
                        Phone: {{ $item->product->artist->mobile }}
                    </td>
                    <td>₱{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Subtotal</td>
                <td>₱{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total">Tax</td>
                <td>₱{{ number_format($order->tax, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total">Total</td>
                <td>₱{{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
