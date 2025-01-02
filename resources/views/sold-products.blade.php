@extends('layouts.app')

@section('content')
<div class="container widened-container py-5">
    <h2 class="text-left mb-4">SOLD ARTWORKS</h2>
       <div class="row">
        <div class="col-md-6 col-lg-8 col-xl-80per">
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-left">
                @foreach ($soldProducts as $product)
                <div class="col">
                    <div class="card shadow-lg border-50 h-100" style="border-radius: 12px; transition: transform 0.3s ease;">
                        <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                            <img src="{{ asset('uploads/products/' . $product->image) }}" 
                                 class="card-img-top rounded-top" 
                                 alt="{{ $product->name }}" 
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <p class="text-muted">
                                <strong>Sold For:</strong> ₱{{ number_format($product->price_with_fee, 2) }}<br>
                                <strong>Buyer:</strong> {{ $product->orderItems->first()->order->user->name ?? 'Anonymous' }}<br>
                                <small class="text-secondary">
                                    Sold on {{ $product->orderItems->first()->order->delivered_date ?? 'N/A' }}
                                </small>
                            </p>
                            <a href="{{ route('product.details', ['slug' => $product->slug]) }}" 
                               class="btn btn-outline-primary btn-sm w-100">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-5 text-center">
        {{ $soldProducts->links() }}
    </div>
</div>

<style>
    .widened-container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (min-width: 768px) {
        .widened-container {
            padding-left: 4rem;
            padding-right: 4rem;
        }
    }

    @media (min-width: 1200px) {
        .widened-container {
            padding-left: 8rem;
            padding-right: 8rem;
        }
    }

    .card:hover {
        transform: scale(1.05);
        transition: all 0.3s ease-in-out;
    }
</style>
@endsection
