@extends('layouts.app')

@section('content')
    <style>
        /* Align the image in a square layout */
        .artist-info__image {
            object-fit: cover;
            border-radius: 0;
            /* Ensure no rounded corners */
        }

        /* Style the section heading */
        .artist-info__title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Add spacing for the bio */
        .artist-info__bio {
            margin-top: 15px;
            font-size: 0.95rem;
            color: #555;
        }

        /* Style for the black button */
        .btn-black {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
        }

        .btn-black:hover {
            background-color: #333;
            color: white;
        }

        .product-single__meta-info {
            background-color: #f8f8f8;
            /* Soft background */
            padding: 15px;
            /* Reduced padding for the container */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            max-width: 350px;
            /* Set a maximum width to make it smaller */
            margin-left: 0;
            /* Align to the left */
            /* You can specify a left margin if needed, e.g., margin-left: 20px; */
        }

        .artist-info__bio {
            margin-top: 15px;
            font-size: 0.95rem;
            color: #555;
            overflow: hidden; /* Hides the overflowed text */
            white-space: nowrap; /* Ensures the text doesn't wrap to the next line */
            text-overflow: ellipsis; /* Adds the ellipsis (...) */
            max-width: 100%; /* Ensures it doesn’t overflow the container */
            display: block; /* Ensures block-level behavior for the ellipsis */
        }

        .meta-header {
            border-bottom: 2px solid #ddd;
            /* Underline for the header */
            margin-bottom: 10px;
            /* Reduced space below the header */
        }

        .meta-header h3 {
            font-size: 1.3em;
            /* Smaller header font size */
            color: #333;
            /* Dark text color */
            margin: 0;
            /* No margin */
        }

        .meta-item {
            display: flex;
            /* Use flex for alignment */
            justify-content: space-between;
            /* Space between label and value */
            padding: 8px 0;
            /* Reduced space around each item */
            border-bottom: 1px solid #e1e1e1;
            /* Optional: line between items */
        }

        .meta-item:last-child {
            border-bottom: none;
            /* Remove line for the last item */
        }

        .label {
            font-weight: bold;
            /* Bold label */
            color: #555;
            /* Dark grey for labels */
            font-size: 0.9em;
            /* Smaller font size for labels */
        }

        .value {
            font-size: 0.9em;
            /* Normal size for values */
            color: #333;
            /* Darker text for values */
        }

        .value.status {
            font-weight: bold;
            /* Emphasize YES/NO */
        }

        .value.yes {
            color: green;
            /* Green for YES */
        }

        .value.no {
            color: red;
            /* Red for NO */
        }
    </style>
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products') }}/{{ $product->image }}" width="674"
                                            height="674" alt="" />
                                        <a data-fancybox="gallery"
                                            href="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>

                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products') }}/{{ $gimg }}" width="674"
                                                height="674" alt="" />
                                            <a data-fancybox="gallery"
                                                href="{{ asset('uploads/products') }}/{{ $gimg }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></div>
                                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                            width="104" height="104" alt="" /></div>
                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item"><img loading="lazy"
                                                class="h-auto" src="{{ asset('uploads/products') }}/{{ $gimg }}"
                                                width="104" height="104" alt="" /></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="{{ route('home.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="{{ route('shop.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                            <a href="{{ route('shop.index') }}" class="text-uppercase fw-medium"><svg width="10"
                                    height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_md" />
                                </svg><span class="menu-link menu-link_us-s">Back</span></a>
                        </div><!-- /.shop-acs -->
                    </div>


                    <div class="details">
                        <h2 class="product-single__name" style="margin-bottom: 20px;">{{ $product->name }}</h2>

                        <div class="product-single__meta-info">
                            <div class="meta-item">
                                <label>Artist:</label>
                                <span>{{ $product->artist->name }}</span>
                            </div>
                            <div class="meta-item">
                                <label>Location</label>
                                <span>{{ $product->artist->address ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <label>{{ $product->category->name }}:</label>
                                <span>{{ $product->medium }} on {{ $product->material }}</span>
                            </div>
                            <div class="meta-item">
                                <label>Size:</label>
                                <span>{{ $product->dimensions ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-single__price">
                        @if ($product->is_sold)
                            <span class="badge bg-danger">SOLD</span>
                        @else
                            <div>
                                <span class="current-price" style="font-size: 2rem; font-weight: bold;">
                                    ₱{{ number_format($product->price_with_fee, 2) }}
                                </span>
                            </div>
                            <div style="font-weight: normal; font-size: 0.9rem; color: gray;">Tax included</div>
                        @endif
                    </div>

                    @if ($product->is_sold)
                        <div class="alert alert-warning text-center mt-3">
                            This product is already sold and is no longer available for purchase.
                        </div>
                    @elseif (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                        <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3"
                            style="font-size: 1rem; font-weight: bold;">Added to Cart</a>
                    @else
                        <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="id" value="{{ $product->id }}" />
                            <input type="hidden" name="name" value="{{ $product->name }}" />
                            <input type="hidden" name="price" value="{{ $product->price_with_fee }}" />

                            <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer"> Add to
                                Cart</button>
                        </form>
                        <div class="mt-2" style="font-size: 0.9rem; color: gray;">
                            Have a question? <a href="{{ route('buyer.faq') }}"
                                style="color: black; text-decoration: underline;">Visit our
                                FAQs.</a>
                        </div>
                    @endif

                    <div class="artist-info mt-4">
                        <h2 class="artist-info__title">Meet the Artist</h2>
                        <div class="d-flex align-items-start">
                            <!-- Artist Image -->
                            <img src="{{ asset('uploads/artists/' . $product->artist->image) }}"
                                class="artist-info__image me-3" width="150" height="150"
                                alt="{{ $product->artist->name }}">

                            <!-- Artist Details -->
                            <div>
                                <p class="mb-0" style="font-weight: bold; font-size: 1.5rem">
                                    {{ $product->artist->name }}</p>
                                <p class="text-muted mb-0">{{ $product->artist->address }}</p>
                                <p class="text-muted mb-0">
                                    @if ($product->artist->availableArtworksCount() > 0)
                                        Has {{ $product->artist->availableArtworksCount() }} {{ Str::plural('artwork', $product->artist->availableArtworksCount()) }} available.
                                    @else
                                        Currently, no available artworks.
                                    @endif
                                </p>
                                
                                </p>
                            </div>
                        </div>

                        <!--Hindi ma-adjust kung gaano kahaba bago mag ellipsis-->
                        <p class="artist-info__bio mt-3">
                            {{ Str::limit($product->artist->artist_description, 150, '...') }}
                        </p>
                        <a href="{{ route('artist.profile', $product->artist->id) }}" class="btn btn-black"
                            style="font-size: 1rem;">Visit Profile</a>
                    </div>
                    @if ($alreadyRated)
                    <div class="alert alert-info mt-3">
                        You already rated this product. Thank you for your feedback!
                    </div>
                        @else
                            @if ($canRate)
                                <form action="{{ route('product.rate', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="rating">Rate this Product:</label>
                                        <select name="rating" id="rating" class="form-control" required>
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Good</option>
                                            <option value="3">3 - Average</option>
                                            <option value="2">2 - Poor</option>
                                            <option value="1">1 - Very Poor</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="review">Your Review (optional):</label>
                                        <textarea name="review" id="review" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                                </form>
                            @endif
                        @endif
                </div>
            </div>
            <div class="product-single__details-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                            href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                            aria-selected="false">Additional Information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                            href="#tab-reviews" role="tab" aria-controls="tab-reviews"
                            aria-selected="false">Reviews & Ratings</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Product Description -->
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
            
                    <!-- Additional Information -->
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__addtional-info">
                            <div class="item">
                                <label class="h6">Medium</label>
                                <span>{{ $product->medium }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Style</label>
                                <span>{{ $product->style }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Year Created</label>
                                <span>{{ $product->year_created }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Authenticity</label>
                                <span>{{ $product->COA ? 'Comes with a Certificate of Authenticity (COA)' : 'Does not come with a Certificate of Authenticity (COA)'}}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Signature</label>
                                <span>{{ $product->signature ? 'Signed' : 'Not Signed'}}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Framed</label>
                                <span>{{ $product->framed ? 'Framed' : 'Not Framed' }}</span>
                            </div>
                        </div>
                    </div>
            
                                <!-- Reviews & Ratings -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        <div class="reviews-container mt-3">
                            <h4>Customer Reviews & Ratings</h4>
                            <div class="average-rating mb-3">
                                <strong>Average Rating:</strong> 
                                {{ number_format($product->ratings->avg('rating'), 1) }} / 5 
                                ({{ $product->ratings->count() }} reviews)
                            </div>

                            <!-- Loop through each review -->
                            <ul class="review-list">
                                @forelse ($product->ratings as $rating)
                                    <li class="review-item border-bottom py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>{{ $rating->user->name ?? 'Anonymous' }}</strong>
                                            <span>{{ $rating->rating }} / 5</span>
                                        </div>
                                        <p class="text-muted mb-0">{{ $rating->review ?? 'No review provided.' }}</p>
                                        <small class="text-secondary">{{ $rating->created_at->format('F j, Y') }}</small>
                                    </li>
                                @empty
                                    <li class="text-center text-muted">No reviews yet. Be the first to leave a review!</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>            
        </section>


        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
                    <div class="swiper-wrapper">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <a
                                        href="{{ route('shop.product.details', ['product_slug' => $relatedProduct->slug]) }}">
                                        <img loading="lazy"
                                            src="{{ asset('uploads/products') }}/{{ $relatedProduct->image }}"
                                            width="330" height="400" alt="{{ $relatedProduct->name }}"
                                            class="pc__img">

                                        @foreach (explode(',', $relatedProduct->images) as $gimg)
                                            <img loading="lazy"
                                                src="{{ asset('uploads/products') }}/{{ $gimg }}" width="330"
                                                height="400" alt="{{ $relatedProduct->name }}"
                                                class="pc__img pc__img-second">
                                        @endforeach

                                    </a>

                                    @if (Cart::instance('cart')->content()->where('id', $relatedProduct->id)->count() > 0)
                                        <a href="{{ route('cart.index') }}"
                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">
                                            Added to Cart</a>
                                    @else
                                        <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $relatedProduct->id }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="name" value="{{ $relatedProduct->name }}" />
                                            <input type="hidden" name="price"
                                                value="{{ $relatedProduct->price_with_fee }}" />
                                            <button type="submit"
                                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                                data-aside="cartDrawer" title="Add To Cart"> Added To Cart</button>
                                        </form>
                                    @endif
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $relatedProduct->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $relatedProduct->slug]) }}">{{ $relatedProduct->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            ₱{{ number_format($product->price_with_fee, 2) }}
                                        </span>
                                    </div>

                                    <button
                                        class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                        title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                <!-- /.products-pagination -->
            </div><!-- /.position-relative -->

        </section><!-- /.products-carousel container -->
    </main>
@endsection
