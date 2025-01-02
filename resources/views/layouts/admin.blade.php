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
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/likhatala.ico') }}">
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
                        <a href="{{ route('admin.index') }}" id="site-logo-inner">
                            <img class="" id="logo_header_1" alt=""
                                src="{{ asset('\images\logo\likhalogo.png') }}"
                                data-light="{{ asset('\images\logo\likhalogo.png') }}"
                                data-dark="{{ asset('\images\logo\likhalogo.png') }}">
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
                                    <a href="{{ route('admin.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                            </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Artworks</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.add') }}" class="">
                                                <div class="text">Add Artworks</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products') }}" class="">
                                                <div class="text">All Artworks</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.pending') }}" class="">
                                                <div class="text">Pending Artworks</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers "></i></div>
                                        <div class="text">Pendings</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.pending') }}" class="">
                                                <div class="text">Pending Artworks</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.artists.pending') }}" class="">
                                                <div class="text">Pending Artists</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.transactions') }}" class="">
                                                <div class="text">Pending Transactions</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers "></i></div>
                                        <div class="text">Artists</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.artists') }}" class="">
                                                <div class="text">Artist</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.artist.add') }}" class="">
                                                <div class="text">Add Artists</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.artists.pending') }}" class="">
                                                <div class="text">Pending Artists</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-credit-card"></i></div>
                                        <div class="text">Payouts</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.payout.requests') }}" class="">
                                                <div class="text">Payout Requests</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.payout.history') }}" class="">
                                                <div class="text">Payout History</div>
                                            </a>
                                        </li>
                                    </ul>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-layers"></i></div>
                                            <div class="text">Category</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.category.add') }}" class="">
                                                    <div class="text">New Category</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.categories') }}" class="">
                                                    <div class="text">Categories</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-credit-card"></i></div>
                                        <div class="text">Payment Methods</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('payment_methods.create') }}" class="">
                                                <div class="text">Add Payment Method</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('payment_methods.index') }}" class="">
                                                <div class="text">Manage Payment Methods</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.transactions') }}" class="">
                                                <div class="text">View Transactions</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.transaction-history') }}" class="">
                                                <div class="text">Transactions History</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">User</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.user.create') }}" class="">
                                                <div class="text">New User</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.users') }}" class="">
                                                <div class="text">Users</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.manage.reviews') }}" class="">
                                        <div class="icon"><i class="icon-star"></i></div>
                                        <div class="text">Manage Reviews</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.artist.sales.report') }}" class="">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Artist Reports</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.coupons') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Coupon</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.slides') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slides</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.contacts') }}" class="">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.orders') }}" class="">
                                        <div class="icon"><i class="icon-box"></i></div>
                                        <div class="text">Orders</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.settings') }}" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <form method="POST" action="{{ route('logout') }}" id='logout-form'>
                                        @csrf
                                        <a href="{{ route('logout') }}" class=""
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit()">
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
                        </div>
                    </div>
                    <div class="main-content">
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
    @stack('scripts')

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
                            url: "{{ route('admin.search') }}",
                            data: {
                                query: searchQuery
                            },
                            dataType: 'json',
                            success: function(data) {
                                $("#box-content-search").html('');
                                if (data.length > 0) {
                                    $.each(data, function(index, item) {
                                        let url =
                                            "{{ route('admin.product.edit', ['id' => 'product_id']) }}";
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
</body>

</html>
