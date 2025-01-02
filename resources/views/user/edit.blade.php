@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Edit Address</h2>
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__edit">
                        <div class="my-account__edit-form">
                            <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Full Name" value="{{ $address->name }}" maxlength="100"
                                                required>
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="phone" class="form-control" placeholder="Phone"
                                                value="{{ $address->phone }}" maxlength="11" required>
                                            <label for="phone">Phone</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="zip_code" class="form-control"
                                                placeholder="ZIP Code" value="{{ $address->zip_code }}" maxlength="4"
                                                required>
                                            <label for="zip_code">ZIP Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="state" class="form-control" placeholder="State"
                                                value="{{ $address->state }}" required>
                                            <label for="state">State</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="city" class="form-control" placeholder="City"
                                                value="{{ $address->city }}" required>
                                            <label for="city">City</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="barangay" class="form-control" placeholder="barangay"
                                                value="{{ $address->barangay }}" required>
                                            <label for="barangay">Barangay</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="country" class="form-control" placeholder="Country"
                                                value="{{ $address->country }}" required>
                                            <label for="country">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="house_number" class="form-control"
                                                placeholder="House Number" value="{{ $address->house_number }}" required>
                                            <label for="house_number">House Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" name="street" class="form-control" placeholder="Street"
                                                value="{{ $address->street }}" required>
                                            <label for="street">Street</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-primary">Update Address</button>
                                        </div>
                                    </div>
                                    <div class="form-check my-3">
                                        <input type="checkbox" class="form-check-input" name="isdefault" id="isdefault" value="1" 
                                            {{ isset($address) && $address->isdefault ? 'checked' : '' }}>
                                        <label for="isdefault" class="form-check-label">Set as default address</label>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
