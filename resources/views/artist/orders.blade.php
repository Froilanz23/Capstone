@extends('layouts.artist')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Orders</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('artist.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Orders</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name" tabindex="2">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:70px">Order No</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Order Status</th>
                                <th class="text-center">Transaction Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Delivered On</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Artwork Price</th>
                                <th class="text-center">Fee</th>
                                <th class="text-center">Total (Fee Included)</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            @php
                                // Filter order items for the current artist
                                $artistOrderItems = $order->orderItems->filter(fn($item) => $item->product->artist_id == Auth::user()->artist->id);
                    
                                // Calculate subtotal (based on regular price)
                                $artistSubtotal = $artistOrderItems->sum(fn($item) => $item->product->regular_price * $item->quantity);
                    
                                // Calculate fees (commission)
                                $feePercentage = 0.12; // Example: 12% commission
                                $artistFee = $artistSubtotal * $feePercentage;
                    
                                // Calculate total (Subtotal + Fee)
                                $artistTotal = $artistSubtotal + $artistFee;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $order->id }}</td>
                                <td class="text-center">{{ $order->name }}</td>
                                <td class="text-center">{{ $order->phone }}</td>
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($order->transaction)
                                        @if($order->transaction->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($order->transaction->status == 'declined')
                                            <span class="badge bg-danger">Declined</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">No Transaction</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $order->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">{{ $order->delivered_date ?? 'N/A' }}</td>
                                <td class="text-center">{{ $artistOrderItems->count() }}</td>
                                <td class="text-center">₱{{ number_format($artistSubtotal, 2) }}</td>
                                <td class="text-center">₱{{ number_format($artistFee, 2) }}</td>
                                <td class="text-center">₱{{ number_format($artistTotal, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('artist.order.details', ['order_id' => $order->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="icon-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$orders->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection
