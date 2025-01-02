@extends('layouts.app')

@section('content')
<style>
    .pt-90 {
      padding-top: 90px !important;
    }

    .pr-6px {
      padding-right: 6px;
      text-transform: uppercase;
    }

    .my-account .page-title {
      font-size: 1.5rem;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 40px;
      border-bottom: 1px solid;
      padding-bottom: 13px;
    }

    .my-account .wg-box {
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      padding: 24px;
      flex-direction: column;
      gap: 24px;
      border-radius: 12px;
      background: var(--White);
      box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
    }

    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #f44032 !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }

    .table-transaction>tbody>tr:nth-of-type(odd) {
      --bs-table-accent-bg: #fff !important;

    }

    .table-transaction th,
    .table-transaction td {
      padding: 0.625rem 1.5rem .25rem !important;
      color: #000 !important;
    }

    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .25rem !important;
      background-color: #6a6e51 !important;
    }

    .table-bordered>:not(caption)>*>* {
      border-width: inherit;
      line-height: 32px;
      font-size: 14px;
      border: 1px solid #e1e1e1;
      vertical-align: middle;
    }

    .table-striped .image {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      flex-shrink: 0;
      border-radius: 10px;
      overflow: hidden;
    }

    .table-striped td:nth-child(1) {
      min-width: 250px;
      padding-bottom: 7px;
    }

    .pname {
      display: flex;
      gap: 13px;
    }

    
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #6a6e51;

    }
    .wg-box h5 {
    font-size: 1.25rem;
    border-bottom: 2px solid #6a6e51;
    padding-bottom: 10px;
    margin-bottom: 15px;
    color: #333;
    }

    .table {
        border: 1px solid #e0e0e0;
        font-size: 14px;
    }

    .table th {
        background-color: #f7f7f7;
        color: #333;
        font-weight: 600;
        text-transform: capitalize;
    }

    .table td {
        vertical-align: middle;
        color: #555;
        background-color: #fff;
    }

    .table td.text-dark {
        font-weight: 500;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }
    .shipping-details {
    font-size: 14px;
    line-height: 1.5;
    background-color: #f8f9fa;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    }

    .shipping-details span {
        display: block;
    }

    .shipping-details .text-muted {
        color: #6c757d;
    }

    .wg-box h5 {
        border-bottom: 2px solid #6a6e51;
        padding-bottom: 8px;
        margin-bottom: 15px;
        font-size: 16px;
        color: #333;
        text-transform: uppercase;
    }


  </style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Details</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="row">
                            <div class="col-6">
                                <h5>Order Details</h5>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-sm btn-danger" href="{{route('user.orders')}}">Back</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @if(Session::has('status'))
                                <p class="alert alert-success">{{Session::get('status')}}</p>
                            @endif
                            <table class="table table-bordered table-striped table-transaction">
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
                                    <td>{{$order->delivered_date ?? 'N/A'}}</td>
                                    <th>Cancelled Date</th>
                                    <td>{{$order->canceled_date ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td colspan="5">
                                        @if($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-secondary">Ordered</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="wg-box">
                    <h5 class="text-uppercase mb-4">Ordered Items</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Artist</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tracking Number</th>
                                    <th class="text-center">Shipping Company</th>
                                    <th class="text-center">Rate & Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                <tr>
                                    <!-- Product Image and Name -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img src="{{ asset('uploads/products/thumbnails/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                            </div>
                                            <div>
                                                <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}" 
                                                   class="text-decoration-none fw-semibold" target="_blank">
                                                    {{ $item->product->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="text-center">₱{{ number_format($item->price, 2) }}</td>
                                    
                                    <!-- Quantity -->
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    
                                    <!-- Category -->
                                    <td class="text-center">{{ $item->product->category->name }}</td>
                                    
                                    <!-- Artist -->
                                    <td class="text-center">{{ $item->product->artist->name }}</td>
                                    
                                    <!-- Status -->
                                    <td class="text-center">
                                        <span class="badge 
                                            @if($order->status == 'delivered') bg-success
                                            @elseif($order->status == 'shipped') bg-info
                                            @elseif($order->status == 'canceled') bg-danger
                                            @elseif($order->status == 'pending') bg-warning
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Tracking Number -->
                                    <td class="text-center">
                                        {{ $order->tracking_number ?? 'Not Available' }}
                                    </td>
                                    
                                    <!-- Shipping Company -->
                                    <td class="text-center">
                                        {{ $order->shipping_company ?? 'Not Available' }}
                                    </td>
                                    
                                    <!-- Rate & Review -->
                                    <td class="text-center">
                                        @if ($item->status == 'delivered')
                                        <form action="{{ route('product.rate', $order->id) }}" method="POST" class="p-2 border rounded bg-light">
                                            @csrf
                                            <div class="mb-2">
                                                <label for="rating" class="fw-semibold mb-1" style="font-size: 14px;">Rating:</label>
                                                <select name="rating" id="rating" class="form-select form-select-sm">
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Good</option>
                                                    <option value="3">3 - Average</option>
                                                    <option value="2">2 - Poor</option>
                                                    <option value="1">1 - Very Poor</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="review" class="fw-semibold mb-1" style="font-size: 14px;">Review:</label>
                                                <textarea name="review" id="review" class="form-control form-control-sm" 
                                                          rows="2" placeholder="Write your review..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>Not Available</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$orderItems->links('pagination::bootstrap-5')}}
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Shipping Address</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p><strong>Artist Details:</strong></p>
                            @if($artist = $orderItems->first()->product->artist ?? null)
                                <p>Name: {{$artist->name}}</p>
                                <p>Address: {{$artist->address}}</p>
                                <p>Email: {{$artist->email}}</p>
                                <p>Phone: {{$artist->mobile}}</p>
                            @else
                                <p>Artist details are not available.</p>
                            @endif
                        </div>
                    </div>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p><strong>Customer Details:</strong></p>
                            <p>{{$order->name}}</p>
                            <p>{{$order->address}}</p>
                            <p>{{$order->street}}</p>
                            <p>{{$order->city}}, {{$order->country}}, {{$order->state}}</p>
                            <p>{{$order->barangay}}</p>
                            <p>{{$order->zip_code}}</p>
                            <p>{{$order->house_number}}</p>
                            <br>
                            <p>Mobile: {{$order->phone}}</p>
                        </div>
                    </div>
                </div>
                

                <div class="wg-box mt-5">
                    <div class="wg-box mt-5">
                        <h5>Transactions</h5>
                        <table class="table table-striped table-bordered table-transaction">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>₱{{ number_format($order->subtotal, 2) }}</td>
                                    <th>Total (Tax Included)</th>
                                    <td>₱{{ number_format($order->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Mode</th>
                                    <td>{{ $transaction->mode }}</td>
                                    <th>Status</th>
                                    <td>
                                        @if ($transaction->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($transaction->status == 'declined')
                                            <span class="badge bg-danger">Declined</span>
                                        @elseif ($transaction->status == 'refunded')
                                            <span class="badge bg-secondary">Refunded</span>
                                        @elseif ($transaction->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-info">Processing</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    

                @if($order->status=='ordered' || $order->status == 'pending')
                <div class="wg-box mt-5 text-right">
                    <form action="{{route('user.order.cancel')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{$order->id}}"/>
                        <button type="button" class="btn btn-danger cancel-order">Cancel Order</button>
                    </form>
                </div>
                @endif
                <div class="text-right mt-3">
                    <a href="{{ route('user.order.invoice', $order->id) }}" class="btn btn-primary">
                        <i class="fa fa-file-pdf"></i> Download Invoice
                    </a>
                </div>
                
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(function() {
        $('.cancel-order').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to cancel this order?",
                type: "warning",
                buttons: ["No", "Yes"],
                confirmButtonColor: '#dc3545'
            }).then(function(result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
