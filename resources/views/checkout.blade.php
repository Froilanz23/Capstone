@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">

            <div class="">
                <h2 class="page-title">Shipping and Checkout</h2>
            </div>

            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Payment</span>
                        <em>Pay for your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Order Review</span>
                        <em>Review your order and await for verification</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-info">Add New Address</a>
                            </div>
                        </div>
                        @if ($address)
                        <div class="my-account__address-item">
                            <div class="my-account__address-item__detail">
                                <p>{{ $address->name }}</p>
                                <p>{{ $address->house_number }}, {{ $address->street }}</p>
                                <p>{{ $address->barangay }}</p>
                                <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                <p>{{ $address->zip_code }}</p>
                                <p>{{ $address->phone }}</p>
                            </div>                            
                            <div class="my-account__address-actions">
                                <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </div>
                        </div>
                        
                        @else
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required=""
                                            value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required=""
                                            value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="country" required value="{{ old('country') }}">
                                        <label for="country">Country *</label>
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                                
                                <div class="col-md-6">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required=""
                                            value="{{ old('state') }}">
                                        <label for="state">Province *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required=""
                                            value="{{ old('city') }}">
                                        <label for="city">City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="street" required=""
                                            value="{{ old('street') }}">
                                        <label for="street">Street *</label>
                                        @error('street')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="barangay" required value="{{ old('barangay') }}">
                                        <label for="barangay">Barangay *</label>
                                        @error('barangay')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="house_number" required=""
                                            value="{{ old('house_number') }}">
                                        <label for="house_number">House No. *</label>
                                        @error('house_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip_code" required=""
                                            value="{{ old('zip_code') }}">
                                        <label for="zip_code">Zip-code *</label>
                                        @error('zip_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>QUANTITY</th>
                                            <th class="text-right">PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::instance('cart')->content() as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-right">₱{{ $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="checkout-totals">
                                    <tbody>
                                        @if(Session::has('discounts'))
                                            <tr>
                                                <th>Subtotal</th>
                                                <td class="text-right">₱{{ Session::get('discounts')['subtotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                                <td class="text-right">-₱{{ Session::get('discounts')['discount'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Fee</th>
                                                <td class="text-right">
                                                    ₱{{ Session::get('checkout')['shipping_fee'] ?? 0 }}
                                                </td>
                                            </tr>
                                            <tr class="cart-total">
                                                <th>Total (Tax Included)</th>
                                                <td class="text-right">₱{{ Session::get('checkout')['total'] }}</td>
                                            </tr>
                                            
                                        @else
                                            <tr>
                                                <th>Subtotal</th>
                                                <td class="text-right">₱{{ Cart::instance('cart')->subtotal() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td class="text-right">
                                                    @if(session('shipping_option') == 'pickup')
                                                        Free (Pick-up)
                                                    @elseif(session('shipping_option') == 'shipping')
                                                        Free (Within Pangasinan)
                                                    @else
                                                        Not Selected
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="cart-total">
                                                <th>Total (Tax Included)</th>
                                                <td class="text-right">₱{{ Cart::instance('cart')->total() }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="checkout__payment-methods">
                                @foreach ($paymentMethods as $method)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mode" value="{{ $method->name }}" id="mode{{ $loop->index }}">
                                        <label class="form-check-label" for="mode{{ $loop->index }}">
                                            {{ $method->name }} ({{ $method->account_name }}: {{ $method->account_number }})
                                            <p>{{ $method->details }}</p>
                                        </label>
                                    </div>
                                @endforeach
                                <div class="form-group mt-3">
                                    <label for="receipt">Upload Receipt</label>
                                    <input type="file" name="receipt" id="receipt" class="form-control" required accept="image/*">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="transaction_number">Transaction Number</label>
                                    <input type="text" name="transaction_number" id="transaction_number" class="form-control" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-checkout-confirm">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.btn-checkout-confirm').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirm Your Order',
                    text: 'Are you sure you want to place this order?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, place order',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        $('form[name="checkout-form"]').submit();
                    }
                });
            });
        });
    </script>
@endpush
