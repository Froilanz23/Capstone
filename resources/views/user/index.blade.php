@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="container my-account">
        <h2 class="page-title mb-5">My Account</h2>
        
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card shadow-sm border-0 p-3">
                    @include('user.account-nav')
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="col-lg-9 col-md-8">
                <div class="card shadow-sm border-0 p-4">
                    <div class="my-account__dashboard">
                        <h4 class="mb-3">Welcome, <strong>{{ Auth::user()->name ?? 'User' }}</strong>!</h4>
                        <p class="mb-4 text-muted">
                            Access your account details, view orders, and update your information below.
                        </p>
                        
                        <div class="account-links">
                            <a href="{{ route('user.orders') }}" class="account-link d-flex align-items-center p-3 mb-3 shadow-sm rounded text-dark">
                                <i class="bi bi-bag-check-fill me-3"></i> Recent Orders
                            </a>
                            <a href="{{ route('user.account.address') }}" class="account-link d-flex align-items-center p-3 mb-3 shadow-sm rounded text-dark">
                                <i class="bi bi-geo-alt-fill me-3"></i> Manage Addresses
                            </a>
                            <a href="{{ route('user.account.details') }}" class="account-link d-flex align-items-center p-3 mb-3 shadow-sm rounded text-dark">
                                <i class="bi bi-person-fill-lock me-3"></i> Edit Account Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<style>
/* Custom Styling */
.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    text-align: left; /* Aligns title to the left */
}

.my-account {
    padding: 2rem 0;
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.account-link {
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s, box-shadow 0.2s;
}

.account-link:hover {
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.account-link i {
    font-size: 1.4rem;
    color: #007bff;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    .account-link {
        font-size: 1rem;
        padding: 1rem;
    }
}
</style>
