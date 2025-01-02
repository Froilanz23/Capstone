@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Addresses</h2>
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__address">
                        <div class="row">
                            <div class="col-6">
                                <p class="notice">The following addresses will be used on the checkout page by default.</p>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-info">Add New</a>
                            </div>
                        </div>
                        <div class="my-account__address-list row">
                            @foreach ($addresses as $address)
                                <div class="my-account__address-item col-md-6">
                                    <div class="my-account__address-item__title">
                                        <h5>{{ $address->name }} <i class="fa fa-check-circle text-success"></i></h5>
                                        <a href="{{ route('addresses.edit', $address->id) }}">Edit</a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('addresses.delete', $address->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this address?');">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                    <div class="my-account__address-item__detail">
                                        <p>House No: {{ $address->house_number }}, Street: {{ $address->street }}, Barangay: {{ $address->barangay }}</p>
                                        <p>{{ $address->city }}, {{ $address->state }}</p>
                                        <p>ZIP Code: {{ $address->zip_code }}</p>
                                        <p>Country: {{ $address->country }}</p>
                                        <p>Mobile: {{ $address->phone }}</p>
                                    </div>
                                    
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
