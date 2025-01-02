@extends('layouts.app')

@section('content')
<div class="container vh-90 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-white border-0 text-center">
                <h4 class="font-weight-bold text-primary">{{ __('Verify Your Email Address') }}</h4>
            </div>

            <div class="card-body p-4 text-center">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p class="text-muted mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                
                <p class="text-muted">{{ __('If you did not receive the email, you can request another:') }}</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Request New Link') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
