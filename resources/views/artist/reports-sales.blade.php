@extends('layouts.artist')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
    <h2>My Sales Report</h2>
    
    <div class="wg-box">
    <form method="GET" action="{{ route('artist.sales.report') }}">
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
            </div>
            <div class="col-md-6">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    <h4 class="mt-4">Your Order Details</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Total Price (₱)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No orders found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="mt-4">Sales Summary</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Total Sales (₱)</th>
            </tr>
        </thead>
        <tbody>
            @if ($salesSummary)
                <tr>
                    <td>₱{{ number_format($salesSummary->total_regular_price, 2) }}</td>
                </tr>
            @else
                <tr>
                    <td class="text-center">No sales data found for the selected period.</td>
                </tr>
            @endif
        </tbody>
    </table>
        </div>
    </div>
</div>
@endsection
