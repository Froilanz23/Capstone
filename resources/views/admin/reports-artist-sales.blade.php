@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
    <h3>Artist Sales Report</h3>
    
    <div class="wg-box">
    <form method="GET" action="{{ route('admin.artist.sales.report') }}">
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}">
            </div>
            <div class="col-md-4">
                <label for="artist_id">Artist</label>
                <select id="artist_id" name="artist_id" class="form-control">
                    <option value="">All Artists</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ request('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    <h4 class="mt-4">Individual Order Details</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Artist</th>
                <th>Product</th>
                <th>Price (₱)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->artist_name }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>₱{{ number_format($order->price, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No orders found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="mt-4">Artist Total Sales</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Artist</th>
                <th>Artwork + Fee (₱)</th>
                <th>Admin Commission (₱)</th>
                <th>Artist Total Sales </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->artist_name }}</td>
                    <!-- Artwork + Fee = Total Earnings (includes fee) -->
                    <td>₱{{ number_format($sale->total_earnings + $sale->admin_commission, 2) }}</td>
                    <!-- Admin Commission -->
                    <td>₱{{ number_format($sale->admin_commission, 2) }}</td>
                    <!-- Net Total = Total Earnings -->
                    <td>₱{{ number_format($sale->total_earnings, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No sales found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        </div>
    </div>
</div>
@endsection
