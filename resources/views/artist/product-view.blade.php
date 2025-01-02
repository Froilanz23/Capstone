@extends('layouts.artist')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Artwork Details</h3>
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
                    <a href="{{ route('artist.products') }}">
                        <div class="text-tiny">Artworks</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">View Artwork</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
                <!-- Left Side: Artwork Image -->
                <div>
                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; max-width: 400px; margin-top: 20px; border: 1px solid #ccc; border-radius: 8px;">
                    <div class="gallery mt-4">
                        @foreach (explode(',', $product->images) as $galleryImage)
                            <img src="{{ asset('uploads/products/' . trim($galleryImage)) }}" style="width: 100%; max-width: 120px; margin: 5px; border-radius: 4px;" alt="Gallery Image">
                        @endforeach
                    </div>
                </div>

                <!-- Right Side: Artwork Information -->
                <div>
                    <h2 style="font-size: 2.5rem;">{{ $product->name }}</h2>
                    <p><strong>Uploaded:</strong> {{ $product->created_at->format('F d, Y h:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $product->updated_at->format('F d, Y h:i A') }}</p>
                    
                    <h4 class="mt-4">Artist Information</h4>
                    <p><strong>Name:</strong> {{ $product->artist->name ?? 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ $product->artist->address ?? 'N/A' }}</p>
                    
                    <h4 class="mt-4">Artwork Details</h4>
                    <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                    <p><strong>Medium:</strong> {{ $product->medium }}</p>
                    <p><strong>Style:</strong> {{ $product->style ?? 'N/A' }}</p>
                    <p><strong>Subject:</strong> {{ $product->subject ?? 'N/A' }}</p>
                    <p><strong>Material:</strong> {{ $product->material ?? 'N/A' }}</p>
                    <p><strong>Dimensions:</strong> {{ $product->dimensions ?? 'Not specified' }}</p>
                    <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                    <p><strong>Year Created:</strong> {{ $product->year_created ?? 'N/A' }}</p>
                    <p><strong>Authenticity:</strong> {{ $product->COA ? 'Comes with a Certificate of Authenticity (COA)' : 'No COA provided' }}</p>
                    <p><strong>Framed:</strong> {{ $product->framed ? 'Framed' : 'Not Framed' }}</p>
                    <p><strong>Signature:</strong> {{ $product->signature ? 'Signed' : 'Not Signed' }}</p>

                    <h4 class="mt-4">Pricing</h4>
                    <p><strong>Regular Price:</strong> ₱{{ number_format($product->regular_price, 2) }}</p>
                    <p><strong>Admin Fee:</strong> ₱{{ number_format($product->productFee->fee ?? 0, 2) }}</p>
                    <p><strong>Total Price (with Fee):</strong> ₱{{ number_format($product->productFee->price_with_fee ?? $product->regular_price, 2) }}</p>
               

                    

                    <h4 class="mt-4">Description</h4>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
