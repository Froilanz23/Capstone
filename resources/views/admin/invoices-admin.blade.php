<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f4f4f4; }
        .total { font-weight: bold; }
        h3 { margin-bottom: 10px; }
        p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Invoice</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <h3>Artist Details</h3>
    <p>
        Name: {{ $artistOrderItems->first()->product->artist->name }}<br>
        Email: {{ $artistOrderItems->first()->product->artist->email }}<br>
        Address: {{ $artistOrderItems->first()->product->artist->address }}
    </p>

    <h3>Customer Details</h3>
    <p>
        Name: {{ $order->name }}<br>
        Email: {{ $order->user->email ?? 'Not Provided' }}<br>
        Address: {{ $order->street }}, {{ $order->barangay }}, {{ $order->city }}, {{ $order->state }}, {{ $order->zip_code }}<br>
        Phone: {{ $order->phone }}
    </p>

    <h3>Order Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($artistOrderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>₱{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td>₱{{ number_format($artistOrderItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
