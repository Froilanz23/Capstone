@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Forgot Password</h2>
    <p>Please enter your email address, and we will send you a link to reset your password.</p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
@endsection
