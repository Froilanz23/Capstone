@extends('layouts.artist')
@section('content')
<style>
    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;
    }
</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
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
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>

        <!-- Update Entire Order Status -->
        <div class="wg-box mb-16">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Update Order Status</h5>
                </div>
            </div>
            <form action="{{ route('artist.order.status.update') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <select name="order_status" class="form-select" {{ !$transaction || $transaction->status !== 'approved' ? 'disabled' : '' }}>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" {{ !$transaction || $transaction->status !== 'approved' ? 'disabled' : '' }}>Update Order Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        @if($order->status == 'ordered' || $order->status == 'shipped')
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Add Tracking Details</h5>
                </div>
            </div>
            <form action="{{ route('artist.orders.addTracking', $order->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tracking_number">Tracking Number</label>
                            <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="{{ $order->tracking_number ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="shipping_company">Shipping Company</label>
                            <input type="text" name="shipping_company" id="shipping_company" class="form-control" value="{{ $order->shipping_company ?? '' }}" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Tracking Details</button>
            </form>
        </div>
        @endif

        <!-- Order Summary -->
        <div class="wg-box mb-16">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Order Details</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{route('artist.orders')}}">Back</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('status'))
                    <p class="alert alert-success">{{Session::get('status')}}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Order No</th>
                        <td>{{$order->id}}</td>
                        <th>Mobile</th>
                        <td>{{$order->phone}}</td>
                        <th>Zip Code</th>
                        <td>{{$order->zip_code}}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{$order->created_at}}</td>
                        <th>Delivered Date</th>
                        <td>{{$order->delivered_date}}</td>
                        <th>Cancelled Date</th>
                        <td>{{$order->canceled_date}}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td colspan="5">
                            @if($order->status == 'delivered')
                                <span class="badge bg-success">Delivered</span>
                            @elseif($order->status == 'canceled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                    </tr>
                       {{-- @if (auth()->user()->hasRole('admin')) --}}
                       <a href="{{ route('artist.invoice', $order->id) }}" class="btn btn-primary">
                        Download Invoice
                    </a>
                {{-- @endif --}}
                    <tr>
                        <th>Transaction Status</th>
                        <td colspan="5">
                            @if($transaction)
                                @if($transaction->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($transaction->status == 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">No Transaction</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Shipping Details -->
        <div class="wg-box mb-16">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Customer Shipping Details</h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            {{ $order->house_number }}, {{ $order->street }}, {{ $order->barangay }}, 
                            {{ $order->city }}, {{ $order->state }}, {{ $order->zip_code }}, {{ $order->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>Phone number</th>
                        <td>{{ $order->phone }}</td>
                    </tr>
                </table>
            </div>
    </div>
            <!-- Ordered Items -->
            <div class="wg-box mb 16">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Total (Fee Included)</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Item Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                            <tr>
                                <td>{{$item->product->name}}</td>
                                <td class="text-center">₱{{ number_format($item->price, 2) }}</td>
                                <td class="text-center">{{$item->quantity}}</td>
                                <td class="text-center">{{$item->product->category->name}}</td>
                                <td class="text-center">
                                    @if($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-info">Shipped</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
</div>
@endsection
