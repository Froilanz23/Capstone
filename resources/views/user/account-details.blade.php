@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Account Details</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__edit">

                    <!-- Update Account Information -->
                    <div class="my-account__edit-form mb-4">
                        <h4>Update Account Information</h4>
                        <form name="account_update_form" action="{{ route('account.update') }}" method="POST">
                            @csrf
                            @if(session('success_info'))
                                <div class="alert alert-success">{{ session('success_info') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name', $user->name) }}" required>
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                                        <label for="mobile">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email', $user->email) }}" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Save Information</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="my-account__edit-form">
                        <h4>Change Password</h4>
                        <form name="password_change_form" action="{{ route('account.update.password') }}" method="POST">
                            @csrf
                            @if(session('success_password'))
                                <div class="alert alert-success">{{ session('success_password') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old password" required>
                                        <label for="old_password">Old password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password" required>
                                        <label for="new_password">New password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" required>
                                        <label for="new_password_confirmation">Confirm new password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
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
