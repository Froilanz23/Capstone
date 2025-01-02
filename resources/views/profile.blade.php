@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Left Section -->
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="{{ asset('uploads/artists/' . $artist->image) }}" 
                     alt="{{ $artist->name }}" 
                     class="rounded-circle shadow-lg"
                     style="width: 180px; height: 180px; object-fit: cover;">
                <h3 class="text-primary mt-3">{{ $artist->name }}</h3>
                <p class="fw-bold text-muted">{{ $artist->art_practice }}</p>
                <p><strong>Location:</strong> {{ $artist->address }}</p>
                <p><strong>Artworks Available:</strong> {{ $artist->products->where('is_sold', false)->count() }}</p>
                <p>
                    <strong>Portfolio:</strong> 
                    <a href="{{ $artist->portfolio_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        View Portfolio
                    </a>
                </p>
            </div>
            
            <div class="mb-4">

            </div>
        </div>

        <!-- Right Section -->
        <div class="col-md-6">
            <div class="workplace-photo mb-4">
                <img src="{{ asset('uploads/artists/' . $artist->workplace_photo) }}" 
                     alt="Workplace Photo" 
                     class="img-fluid rounded shadow-lg" 
                     style="max-height: 300px; object-fit: contain; width: 100%;">
            </div>
            <div>
                <h5 class="text-muted">Artist Description</h5>
                <p>{{ $artist->artist_description ?? 'No description available.' }}</p>
            </div>
        </div>
    </div>
    
    <hr>

    <!-- Tabbed Section -->
    <div class="artist-tabs mx-auto" style="max-width: 900px;">
        <ul class="nav nav-tabs justify-content-center" id="artistTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4" id="artworks-tab" data-bs-toggle="tab" data-bs-target="#artworks" 
                        type="button" role="tab" aria-controls="artworks" aria-selected="true">
                    <i class="bi bi-palette"></i> Artworks
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4" id="sold-tab" data-bs-toggle="tab" data-bs-target="#sold" 
                        type="button" role="tab" aria-controls="sold" aria-selected="false">
                    <i class="bi bi-check-circle"></i> Sold Artworks
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" 
                        type="button" role="tab" aria-controls="reviews" aria-selected="false">
                    <i class="bi bi-star"></i> Reviews & Ratings
                </button>
            </li>
        </ul>
        <div class="tab-content mt-5" id="artistTabContent">
            <!-- Artworks Tab -->
            <div class="tab-pane fade show active" id="artworks" role="tabpanel" aria-labelledby="artworks-tab">
                <div class="row g-4 justify-content-center">
                    @forelse($artworks->where('is_sold', false) as $product)
                        <div class="col-md-4">
                            <div class="card shadow-lg border-0 h-100" style="border-radius: 12px; transition: transform 0.3s ease;">
                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" aria-label="View details for {{ $product->name }}">
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" 
                                         class="card-img-top rounded-top" 
                                         alt="{{ $product->name }}" 
                                         style="height: 300px; object-fit: cover;">
                                </a>
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="fw-bold">₱{{ number_format($product->price_with_fee, 2) }}</p>
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" 
                                       class="btn btn-outline-primary btn-sm w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No artworks available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Sold Artworks Tab -->
            <div class="tab-pane fade" id="sold" role="tabpanel" aria-labelledby="sold-tab">
                <!-- Sold artworks content -->
            </div>

            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <!-- Reviews content -->
            </div>
        </div>
    </div>
</div>
@endsection
