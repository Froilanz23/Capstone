@extends('layouts.app')
@section('content')
    <main>
        
        <div class="container">
            <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow"
                data-settings='{
                          "autoplay": {
                            "delay": 5000
                          },
                          "slidesPerView": 1,
                          "effect": "fade",
                          "loop": true
                        }'>
                <div class="swiper-wrapper">
                    @foreach ($slides as $slide)
                        <div class="swiper-slide">
                            <div class="overflow-hidden position-relative h-100">
                                <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                                    <img loading="lazy" src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt="Likhatala"
                                        class="slideshow-character__img animate animate_fade animate_btt animate_delay-9" />
                                    <div class="character_markup type2">
                                        <p
                                            class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                                            {{ $slide->tagline }}
                                        </p>
                                    </div>
                                </div>
                                <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                                    <h6
                                        class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                        Announcement
                                    </h6>
                                    <h2 class="h1 fw-bold mb-0 animate animate_fade animate_btt animate_delay-5">
                                        {{ $slide->title }}</h2>
                                    <h2 class="h1 fw-normal animate animate_fade animate_btt animate_delay-5">
                                        {{ $slide->subtitle }}</h2>
                                    <a href="{{ $slide->link }}"
                                        class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="container">
                    <div
                        class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                    </div>
                </div>
            </section>
            <div class="container mw-1620 bg-white border-radius-10">


                <!--Featured Products-->
                <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

                <section class="feature-grid container">
                    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                    <div class="position-relative">
                        <div class="swiper-container js-swiper-slider"
                            data-settings='{
                                      "autoplay": {
                                        "delay": 5000
                                      },
                                      "slidesPerView": 4,
                                      "slidesPerGroup": 4,
                                      "effect": "none",
                                      "loop": false,
                                      "navigation": {
                                        "nextEl": ".products-carousel__prev",
                                        "prevEl": ".products-carousel__next"
                                      },
                                      "breakpoints": {
                                        "320": {
                                          "slidesPerView": 2,
                                          "slidesPerGroup": 2,
                                          "spaceBetween": 15
                                        },
                                        "768": {
                                          "slidesPerView": 2,
                                          "slidesPerGroup": 3,
                                          "spaceBetween": 15
                                        },
                                        "992": {
                                          "slidesPerView": 3,
                                          "slidesPerGroup": 1,
                                          "spaceBetween": 15,
                                          "pagination": false
                                        },
                                        "1200": {
                                          "slidesPerView": 4,
                                          "slidesPerGroup": 1,
                                          "spaceBetween": 15,
                                          "pagination": false
                                        }
                                      }
                                    }'>
                            <div class="swiper-wrapper">
                                @foreach ($fproducts as $fproduct)
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $fproduct->slug]) }}">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products') }}/{{ $fproduct->image }}"
                                                    width="330" height="400" alt="{{ $fproduct->name }}"
                                                    class="pc__img">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="details.html">{{ $fproduct->name }}</a></h6>
                                            <div class="product-card__price d-flex align-items-center">
                                                <span class="money price text-secondary">
                                                    ₱{{ number_format($fproduct->price_with_fee, 2) }} </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div><!-- /.swiper-wrapper -->
                        </div>

                        <div
                            class="products-carousel__prev products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg>
                        </div><!-- /.products-carousel__prev -->
                        <div
                            class="products-carousel__next products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg>
                        </div><!-- /.products-carousel__next -->

                        <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    </div><!-- /.position-relative -->
                </section>

                  <!--Explore Visual Arts-->
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Explore Visual Arts Categories</h2>

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                                    "autoplay": {
                                      "delay": 5000
                                    },
                                    "slidesPerView": 8,
                                    "slidesPerGroup": 1,
                                    "effect": "none",
                                    "loop": true,
                                    "navigation": {
                                      "nextEl": ".products-carousel__next-1",
                                      "prevEl": ".products-carousel__prev-1"
                                    },
                                    "breakpoints": {
                                      "320": {
                                        "slidesPerView": 2,
                                        "slidesPerGroup": 2,
                                        "spaceBetween": 15
                                      },
                                      "768": {
                                        "slidesPerView": 4,
                                        "slidesPerGroup": 4,
                                        "spaceBetween": 30
                                      },
                                      "992": {
                                        "slidesPerView": 6,
                                        "slidesPerGroup": 1,
                                        "spaceBetween": 45,
                                        "pagination": false
                                      },
                                      "1200": {
                                        "slidesPerView": 8,
                                        "slidesPerGroup": 1,
                                        "spaceBetween": 60,
                                        "pagination": false
                                      }
                                    }
                                  }'>
                                  <div class="swiper-wrapper">
                                    @foreach ($categories as $category)
                                        <div class="swiper-slide">
                                            <a href="{{ route('shop.index', ['categories' => $category->id]) }}">
                                                <img loading="lazy" class="w-100 h-auto mb-3" 
                                                    src="{{ asset('uploads/categories') }}/{{ $category->image }}" 
                                                    width="124" height="124" alt="{{ $category->name }}" />
                                            </a>
                                            <div class="text-center">
                                                <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                                    class="menu-link fw-medium">{{ $category->name }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4"> Top Rated Artists </h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <h2>Discover Exceptional</h2>
                        <h2 class="fw-bold">Talents</h2>
                        <!-- Link to all artists -->
                        <a href="{{ route('artists.index') }}"
                            class="btn-link default-underline text-uppercase fw-medium mt-3">View All Artists</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider"
                                data-settings='{
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "effect": "none",
                    "loop": false,
                    "breakpoints": {
                        "320": {
                            "slidesPerView": 2,
                            "slidesPerGroup": 2,
                            "spaceBetween": 15
                        },
                        "768": {
                            "slidesPerView": 2,
                            "slidesPerGroup": 3,
                            "spaceBetween": 15
                        },
                        "992": {
                            "slidesPerView": 3,
                            "slidesPerGroup": 1,
                            "spaceBetween": 15,
                            "pagination": false
                        },
                        "1200": {
                            "slidesPerView": 4,
                            "slidesPerGroup": 1,
                            "spaceBetween": 15,
                            "pagination": false
                        }
                    }
                }'>
                <div class="swiper-wrapper">
                    @foreach ($topArtists as $artist)
                        <div class="swiper-slide product-card product-card_style3">
                            <div class="pc__img-wrapper">
                                <a href="{{ route('artist.profile', ['id' => $artist->id]) }}">
                                    <img loading="lazy"
                                        src="{{ asset('uploads/artists/' . $artist->image) }}"
                                        width="258" height="313" alt="{{ $artist->name }}"
                                        class="pc__img">
                                </a>
                            </div>
                            <div class="pc__info position-relative">
                                <h6 class="pc__title fw-bold">
                                    <a href="{{ route('artist.profile', ['id' => $artist->id]) }}">
                                        {{ $artist->name }}
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    <strong>Rating:</strong>
                                    {{ number_format($artist->average_rating, 1) }} / 5<br>
                                    <strong>Sold Artworks:</strong>
                                    @if ($artist->sold_artworks_count > 0)
                                        Sold {{ $artist->sold_artworks_count }} artwork/s
                                    @else
                                        No sold artworks yet. Buy Now!
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
    </div>
</div>
</section>

<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

<section class="hot-deals container">
<h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Sold Artworks</h2>
<div class="row">
    <div
        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
        <h2>Admired and</h2>
        <h2 class="fw-bold">ACQUIRED</h2>
        <a href="{{ route('products.sold') }}"
            class="btn-link default-underline text-uppercase fw-medium mt-3">View All Artworks</a>
    </div>
    <div class="col-md-6 col-lg-8 col-xl-80per">
        <div class="position-relative">
            <div class="swiper-container js-swiper-slider"
                data-settings='{
                  "autoplay": { "delay": 5000 },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                      "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 15 },
                      "768": { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 15 },
                      "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 15, "pagination": false },
                      "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 15, "pagination": false }
                  }
              }'>
              <div class="swiper-wrapper">
                @foreach ($topProducts as $product)
                    <div class="swiper-slide product-card product-card_style3">
                        <div class="pc__img-wrapper">
                            <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                <img loading="lazy"
                                    src="{{ asset('uploads/products/' . $product->image) }}"
                                    width="258" height="313" alt="{{ $product->name }}"
                                    class="pc__img">
                            </a>
                        </div>
                        <div class="pc__info position-relative">
                            <h6 class="pc__title fw-bold">
                                <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <p class="text-muted">
                                <!-- Display the artist's name -->
                                 {{ $product->artist->name ?? 'Unknown' }}<br>
                                Sold for
                                ₱{{ number_format($product->price_with_fee, 2) }}<br>
                                Acquired by
                                {{ $product->orderItems->first()->order->user->name ?? 'Anonymous' }}<br>
                                <small class="text-secondary">
                                    Sold on
                                    @if ($product->orderItems->first()->order->delivered_date)
                                        {{ \Carbon\Carbon::parse($product->orderItems->first()->order->delivered_date)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </small>
                            </p>
                            <!-- Display reviews -->
                            @if ($product->ratings->count() > 0)
                                <div class="mt-2">
                                    <h6>Reviews:</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($product->ratings as $rating)
                                            <li>
                                                {{-- {{ $rating->review }} --}}
                                                ({{ $rating->rating }}/5)
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="text-muted">No ratings yet.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            </div><!-- /.swiper-container js-swiper-slider -->
        </div><!-- /.position-relative -->
    </div>
</div>
</section>

<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

                  <section class="hot-deals container">
                      <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4"> Browse Artworks by Artist </h2>
                      <div class="row">
                          <div
                              class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                              <h2>Explore all Artist's</h2>
                              <h2 class="fw-bold">CREATIONS</h2>
                          </div>
                          <div class="col-md-6 col-lg-8 col-xl-80per">
                              <div class="position-relative">
                                  <div class="swiper-container js-swiper-slider"
                                      data-settings='{
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "effect": "none",
                    "loop": false,
                    "breakpoints": {
                      "320": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2,
                        "spaceBetween": 15
                      },
                      "768": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 3,
                        "spaceBetween": 15
                      },
                      "992": {
                        "slidesPerView": 3,
                        "slidesPerGroup": 1,
                        "spaceBetween": 15,
                        "pagination": false
                      },
                      "1200": {
                        "slidesPerView": 4,
                        "slidesPerGroup": 1,
                        "spaceBetween": 15,
                        "pagination": false
                      }
                    }
                  }'>

                <div class="swiper-wrapper">
                    @foreach ($artists as $artist)
                        <div class="swiper-slide product-card product-card_style3">
                            <div class="pc__img-wrapper">
                                <a href="{{ route('shop.index', ['artists' => $artist->id]) }}">
                                    <img loading="lazy"
                                        src="{{ asset('uploads/artists') }}/{{ $artist->image }}"
                                        width="258" height="313" alt="{{ $artist->name }}"
                                        class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title fw-bold"><a
                                        href="{{ route('shop.index', ['artists' => $artist->id]) }}">{{ $artist->name }}</a>
                                </h6>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.swiper-wrapper -->
            </div><!-- /.swiper-container js-swiper-slider -->
        </div><!-- /.position-relative -->
    </div>
</div>
</section>

          
        </div>
        </div>

    </main>
@endsection
