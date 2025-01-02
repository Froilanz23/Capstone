@extends('layouts.app')

@section('content')

<style>
    .form-floating > .form-select {
    height: calc(3.5rem + 2px); /* Adjust height to match inputs */
    padding: 0.75rem 1rem;
}

</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>

    <!-- Status Message -->
    @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
    @endif
    <section class="login-register container">
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
                   href="#tab-item-register" role="tab" aria-controls="tab-item-register" aria-selected="true">Register Here</a>
            </li>
        </ul>
        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel" aria-labelledby="register-tab">
                <div class="register-form">
                    <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation" novalidate>
                        @csrf

                        <!-- NAME -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control form-control_gray @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <label for="name">Name</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="form-floating mb-3">
                            <input type="email" id="email" class="form-control form-control_gray @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            <label for="email">Email address *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- MOBILE NUMBER -->
                        <div class="form-floating mb-3">
                            <input type="text" id="mobile" class="form-control form-control_gray @error('mobile') is-invalid @enderror" 
                                   name="mobile" value="{{ old('mobile') }}" required pattern="\d{11}" title="Please enter exactly 11 digits" autocomplete="mobile">
                            <label for="mobile">Mobile number*</label>
                            <small class="form-text text-muted">Please enter exactly 11 digits.</small>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- SEX -->
                        <div class="form-floating mb-3">
                            <select id="sex" class="form-select form-control_gray @error('sex') is-invalid @enderror" name="sex" required>
                                <option disabled selected>Select</option>
                                <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                            <label for="sex">Sex *</label>
                            @error('sex')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- BIRTHDATE -->
                        <div class="form-floating mb-3">
                            <input type="date" id="birthdate" class="form-control form-control_gray @error('birthdate') is-invalid @enderror" 
                                   name="birthdate" value="{{ old('birthdate') }}" required>
                            <label for="birthdate">Birthdate *</label>
                            @error('birthdate')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- ROLE SELECTION -->
                        <div class="form-floating mb-3">
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Select</option>
                                <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Artist</option>
                                <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>Customer</option>
                            </select>
                            <label for="role" class="form-label">Register as *</label>
                            @error('role')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>                        

                        <!-- PASSWORD -->
                        <div class="form-floating mb-3">
                            <input type="password" id="password" class="form-control form-control_gray @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            <label for="password">Password *</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="form-floating mb-3">
                            <input type="password" id="password-confirm" class="form-control form-control_gray" 
                                   name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm">Confirm Password *</label>
                        </div>

                        <button class="btn btn-primary w-100 text-uppercase" type="submit">Register</button>

                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">Have an account?</span>
                            <a href="{{ route('login') }}" class="btn-text js-show-register">Login to your Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
