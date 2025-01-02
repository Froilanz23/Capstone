<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LikhaTala') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images\likhatala.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images\likhatala.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    @stack('styles')

</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('home.index') }}" id="site-logo-inner">
                            <img id="logo_header_1" alt="" src="{{ asset('images/logo/likhalogo.png') }}"
                                data-light="{{ asset('images/logo/likhalogo.png') }}"
                                data-dark="{{ asset('images/logo/likhalogo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{ route('artist.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Artworks</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('artist.product.add') }}" class="">
                                                <div class="text">Add Artworks</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('artist.products') }}" class="">
                                                <div class="text">Artworks</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            
                                <li class="menu-item">
                                      <a href="{{ route('artist.artists') }}" class="">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                      <div class="text">Artist Information</div>
                                      </a>
                                 </li>
                                  
                           
                                <li class="menu-item">
                                    <a href="{{ route('artist.orders') }}" class="">
                                        <div class="icon"><i class="icon-box"></i></div>
                                        <div class="text">Orders</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('artist.sales.report') }}">
                                        <div class="icon"><i class="icon-credit-card"></i></div>
                                        <div class="text">Sales Report</div>
                                    </a>
                                </li>
                                
                                <li class="menu-item">
                                    <a href="{{ route('artist.payout') }}" class="">
                                        <div class="icon"><i class="icon-credit-card"></i></div>
                                        <div class="text">Payout</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('artist.settings') }}" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a href="javascript:void(0);" class=""
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <div class="icon"><i class="icon-settings"></i></div>
                                            <div class="text">Logout</div>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt=""
                                        src="{{ asset('\images\logo\likhalogo.png') }}"
                                        data-light="{{ asset('\images\logo\likhalogo.png') }}"
                                        data-dark="{{ asset('\images\logo\likhalogo.png') }}" data-width="154px"
                                        data-height="52px" data-retina="{{ asset('\images\logo\likhalogo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." class="show-search"
                                            name="name" id="search-input" tabindex="2" value=""
                                            aria-required="true" required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">
                                        <ul id="box-content-search">

                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <div class="popup-wrap user type-header">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="header-user wg-user d-flex align-items-center">
                                            <!-- Circular Profile Image -->
                                            <span class="image" style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; margin-right: 10px;">
                                                @if(isset($artist) && $artist->image)
                                                <img src="{{ asset('uploads/artists/' . $artist->image) }}"
                                                     alt="Profile Image"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                <img src="{{ asset('default-profile.png') }}"
                                                     alt="Default Profile"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </span>
                                            <!-- User Details -->
                                            <span class="flex flex-column">
                                                <span class="body-title mb-1 font-weight-bold" style="font-size: 1.25rem;">{{ Auth::user()->name ?? 'User' }}</span>
                                                <span class="text-tiny text-muted" style="font-size: 1.2rem;">
                                                    @if (Auth::user()->role == 1)
                                                        Admin
                                                    @elseif (Auth::user()->role == 2)
                                                        Artist
                                                    @else
                                                        Not Authorized
                                                    @endif
                                                </span>
                                            </span>
                                        </span>
                                    </button>
                            
                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        @if(isset($artist))
                                        <li><a class="dropdown-item" href="{{ route('artist.profile', ['id' => $artist->id]) }}">View Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('artist.settings') }}">Profile Settings</a></li>
                                        <li><a class="dropdown-item" href="{{ route('artist.products') }}">My Products</a></li>
                                      @endif
                                    
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                               Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>                       
                        </div>
                    </div>
                    <div class="main-content">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                         @endif
                        @yield('content')
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 LikhaTala</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function() {
            let searchTimer; // Timer for debouncing

            $("#search-input").on("keyup", function() {
                clearTimeout(searchTimer);
                let searchQuery = $(this).val();

                if (searchQuery.length > 2) {
                    searchTimer = setTimeout(function() {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('artist.search') }}",
                            data: {
                                query: searchQuery
                            },
                            dataType: 'json',
                            success: function(data) {
                                $("#box-content-search").html('');
                                if (data.length > 0) {
                                    $.each(data, function(index, item) {
                                        let url =
                                            "{{ route('artist.product.edit', ['id' => 'product_id']) }}";
                                        let link = url.replace('product_id',
                                            item.id);

                                        $("#box-content-search").append(`
                                            <li class="product-item gap14 mb-10">
                                                <div class="image no-bg">
                                                    <img src="{{ asset('uploads/products/thumbnails') }}/${item.image}" alt="${item.name}">
                                                </div>
                                                <div class="flex items-center justify-between gap20 flex-grow">
                                                    <div class="name">
                                                        <a href="${link}" clasfs="body-text">${item.name}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-10">
                                                <div class="divider"></div>
                                            </li>
                                        `);
                                    });
                                } else {
                                    $("#box-content-search").append(
                                        '<li>No products found.</li>');
                                }
                            }
                        });
                    }, 300); // Wait 300ms before making the request
                }
            });
        });
    </script>
    @stack('scripts')

</body>

</html>
