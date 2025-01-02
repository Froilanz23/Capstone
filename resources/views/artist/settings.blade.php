@extends('layouts.artist')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Settings</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('artist.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Settings</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="col-lg-12">
                <div class="page-content my-account__edit">
                    <div class="my-account__edit-form">

                        <!-- Display success or error messages -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form for updating account information -->
                        <form name="account_edit_form" action="{{ route('artist.settings.update') }}" method="POST" class="form-new-product form-style-1 needs-validation" novalidate>
                            @csrf
                            <h4>Account Information</h4>
                            <fieldset class="name">
                                <div class="body-title">Name <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="text" placeholder="Full Name" name="name"
                                    tabindex="0" value="{{ old('name', $user->name) }}" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="text" placeholder="Mobile Number" name="mobile"
                                    tabindex="0" value="{{ old('mobile', $user->mobile) }}" required>
                            </fieldset>

                            <fieldset class="sex">
                                <div class="body-title">Sex <span class="tf-color-1">*</span></div>
                                <select id="sex" class="flex-grow @error('sex') is-invalid @enderror" name="sex" required>
                                    <option disabled selected>Select</option>
                                    <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex'), $user->sex == 'other' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </fieldset>
                            @error('sex') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
            
                            <fieldset class="birthday">
                                <div class="body-title"> Birthday <span class="tf-color-1">*</span></div>
                                <input type="date" id="birthdate" class="flex-grow @error('birthdate') is-invalid @enderror" 
                                name="birthdate" value="{{ old('birthdate',$user->birthdate) }}" required>
                            </fieldset>
                            @error('birthday') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                            <fieldset class="name">
                                <div class="body-title">Email Address <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="email" placeholder="Email Address" name="email"
                                    tabindex="0" value="{{ old('email', $user->email) }}" required>
                            </fieldset>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary tf-button w208">Save Changes</button>
                            </div>
                        </form>

                        <hr class="my-5">

                        <!-- Form for updating password -->
                        <form name="password_edit_form" action="{{ route('artist.settings.password.update') }}" method="POST" class="form-new-product form-style-1 needs-validation" novalidate>
                            @csrf
                            <h4>Change Password</h4>
                            <fieldset class="name">
                                <div class="body-title pb-3">Old password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="Old password" 
                                    id="old_password" name="old_password" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title pb-3">New password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="New password" 
                                    id="new_password" name="new_password" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title pb-3">Confirm new password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="Confirm new password" 
                                    id="new_password_confirmation" name="new_password_confirmation" required>
                                <div class="invalid-feedback">Passwords did not match!</div>
                            </fieldset>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary tf-button w208">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
