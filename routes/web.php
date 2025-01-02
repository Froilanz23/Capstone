<?php

use App\Http\Controllers\Admin\AdminPayoutController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
//Guess Routes
Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::get('/about-LikhaTala', [HomeController::class, 'about'])->name('about.likhatala');
Route::get('/buyerfaq', [HomeController::class, 'buyer'])->name('buyer.faq');
Route::get('/sellerfaq', [HomeController::class, 'seller'])->name('seller.faq');
Route::get('/term', [HomeController::class, 'term'])->name('term.likhatala');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy.likhatala');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ShopController::class, 'product_details'])->name('product.details');
Route::post('/product/{id}/rate', [ShopController::class, 'store'])->name('product.rate');
Route::get('/sold-products', [ShopController::class, 'soldProducts'])->name('products.sold');





Route::get('/adminlog', [UserController::class, 'showAdminLog'])->name('adminlog');


Route::get('errors/401', function () {
    return view('errors.401');
});

//Customer Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['RoleManager:customer'])->group(function () {
    Route::get('/customer', [UserController::class, 'index'])->name('user.index');
    Route::get('/customer-account-details', [UserController::class, 'account_details'])->name('user.account.details');
    Route::get('/customer-account-address', [UserController::class, 'account_address'])->name('user.account.address');

    Route::get('/account/edit', [UserController::class, 'edit'])->name('account.edit');
    Route::post('/account/update-password', [UserController::class, 'updatePassword'])->name('account.update.password');
    Route::post('/account/update', [UserController::class, 'update'])->name('account.update');
    Route::get('/order/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('user.order.invoice');


    Route::get('/addresses', [UserController::class, 'account_address'])->name('user.addresses');
    Route::get('/addresses/create', [UserController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [UserController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [UserController::class, 'edit_address'])->name('addresses.edit');
    Route::put('/addresses/{id}', [UserController::class, 'update_address'])->name('addresses.update');

    Route::delete('/addresses/{id}', [UserController::class, 'delete_address'])->name('addresses.delete');

    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-order/{order_id}/details', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/account-order/cancel-order', [UserController::class, 'order_cancel'])->name('user.order.cancel');

    Route::get('/contact', [HomeController::class, 'contacts'])->name('home.contacts');
    Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');

    Route::get('/search', [HomeController::class, 'search'])->name('home.search');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::post('/cart/shipping', [CartController::class, 'updateShippingOption'])->name('cart.shipping.update');

    Route::post('/cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
    Route::delete('/cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');

    Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
    Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
    Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');

    Route::post('/artist/{id}/rate', [UserController::class, 'rateArtist'])->name('artist.rate');
    
});

    Route::middleware(['RoleManager:artist', 'verified.artist'])->group(function () {
        Route::get('/artist', [ArtistController::class, 'index'])->name('artist.index');
        Route::get('/artist/products', [ArtistController::class, 'products'])->name('artist.products');
        Route::get('/artist/product/add', [ArtistController::class, 'product_add'])->name('artist.product.add');
        Route::post('/artist/product/store', [ArtistController::class, 'product_store'])->name('artist.product.store');
        Route::get('/artist/product/{id}/view', [ArtistController::class, 'product_view'])->name('artist.product.view');
        Route::get('/artist/product/{id}/edit', [ArtistController::class, 'product_edit'])->name('artist.product.edit');
        Route::put('/artist/product/update', [ArtistController::class, 'product_update'])->name('artist.product.update');
        Route::delete('/artist/product{id}/delete', [ArtistController::class, 'product_delete'])->name('artist.product.delete');

        Route::get('/artist/categories', [ArtistController::class, 'categories'])->name('artist.categories');
        Route::get('/artist/category/add', [ArtistController::class, 'category_add'])->name('artist.category.add');
        Route::post('/artist/category/store', [ArtistController::class, 'category_store'])->name('artist.category.store');
        Route::get('/artist/category/{id}/edit', [ArtistController::class, 'category_edit'])->name('artist.category.edit');
        Route::put('/artist/category/update', [ArtistController::class, 'category_update'])->name('artist.category.update');
        Route::delete('/artist/category/{id}/delete', [ArtistController::class, 'category_delete'])->name('artist.category.delete');

        Route::get('/artist/slides', [ArtistController::class, 'slides'])->name('artist.slides');
        Route::get('/artist/slide/add', [ArtistController::class, 'slide_add'])->name('artist.slide.add');
        Route::post('/artist/slide/store', [ArtistController::class, 'slide_store'])->name('artist.slide.store');
        Route::get('/artist/slide/{id}/edit', [ArtistController::class, 'slide_edit'])->name('artist.slide.edit');
        Route::put('/artist/slide/update', [ArtistController::class, 'slide_update'])->name('artist.slide.update');
        Route::delete('/artist/slide/{id}/delete', [ArtistController::class, 'slide_delete'])->name('artist.slide.delete');

        Route::get('/artist/contact', [ArtistController::class, 'contacts'])->name('artist.contacts');
        Route::delete('/artist/contact/{id}/delete', [ArtistController::class, 'contact_delete'])->name('artist.contact.delete');
        Route::get('/artist/search', [ArtistController::class, 'search'])->name('artist.search');

        Route::get('/artist/orders', [ArtistController::class, 'orders'])->name('artist.orders');
        Route::get('/artist/order/{order_id}/details', [ArtistController::class, 'order_details'])->name('artist.order.details');
        Route::put('/artist/order/update-status', [ArtistController::class, 'update_order_status'])->name('artist.order.status.update');
        Route::post('/artist/order-item/status', [ArtistController::class, 'update_order_item_status'])->name('artist.order_item.status.update');
        Route::post('/artist/order/status', [ArtistController::class, 'update_order_status'])->name('artist.order.status.update');

        Route::post('/artist/orders/{orderId}/add-tracking', [ArtistController::class, 'addTrackingDetails'])->name('artist.orders.addTracking');
        Route::get('/order/{orderId}/artist-invoice', [OrderController::class, 'downloadInvoiceForArtist'])->name('artist.invoice');


        Route::get('/artist/sales-report', [ArtistController::class, 'salesReport'])->name('artist.sales.report');

        Route::get('/artist/payout', [ArtistController::class, 'payoutIndex'])->name('artist.payout');
        Route::post('/artist/payout/request', [ArtistController::class, 'requestPayout'])->name('artist.payout.request');
        Route::get('/artist/payout/edit/{id}', [ArtistController::class, 'payout_edit'])->name('artist.payout.edit');
        Route::put('/artist/payout/update/{id}', [ArtistController::class, 'payout_update'])->name('artist.payout.update');
        Route::delete('/artist/payout/delete/{id}', [ArtistController::class, 'payout_delete'])->name('artist.payout.delete');


        Route::get('/artist/search', [ArtistController::class, 'search'])->name('artist.search');
    });

        Route::get('/artist/artists', [ArtistController::class, 'artists'])->name('artist.artists');
        Route::get('/artist/artist/fill-up', [ArtistController::class, 'add_artist'])->name('artist.artist.add');
        Route::post('/artist/artist/store', [ArtistController::class, 'artist_store'])->name('artist.artist.store');
        Route::get('/artist/artist/edit/{id}', [ArtistController::class, 'artist_edit'])->name('artist.artist.edit');
        Route::put('/artist/artist/update', [ArtistController::class, 'update_artist'])->name('artist.artist.update');
        // Route::delete('/artist/artist/{id}/delete', [ArtistController::class, 'artist_delete'])->name('artist.artist.delete');

        Route::get('/artist/settings', [ArtistController::class, 'settings'])->name('artist.settings');
        Route::get('/artist/edit', [ArtistController::class, 'edit'])->name('artist.settings.edit');
        Route::post('/artist/update', [ArtistController::class, 'update'])->name('artist.settings.update');
        Route::post('/artist/update-password', [ArtistController::class, 'updatePassword'])->name('artist.settings.password.update');

        Route::get('/artists', [ArtistController::class, 'publicArtists'])->name('artists.index');
        Route::get('/artist/{id}', [ArtistController::class, 'artistProfile'])->name('artist.profile');

        Route::get('/artist/reviews', [ArtistController::class, 'reviews'])->name('artist.reviews');


    //Admin Routes
        Route::middleware(['RoleManager:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/products/pending', [AdminController::class, 'pendingProducts'])->name('admin.products.pending');
        Route::get('/admin/product/{id}/view', [AdminController::class, 'viewProduct'])->name('admin.product.view');
        Route::post('/admin/product/{id}/approve', [AdminController::class, 'approveProduct'])->name('admin.product.approve');
        Route::post('/admin/product/{id}/reject', [AdminController::class, 'rejectProduct'])->name('admin.product.reject');
        Route::get('/admin/product/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.product.edit');
        Route::put('/admin/product/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.product.update');

        Route::get('/admin/artists/pending', [AdminController::class, 'pendingArtists'])->name('admin.artists.pending');
        Route::put('/admin/artist/{id}/approve', [AdminController::class, 'approveArtist'])->name('admin.artist.approve');
        Route::delete('/admin/artist/{id}/reject', [AdminController::class, 'rejectArtist'])->name('admin.artist.reject');

        Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
        Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
        Route::get('/admin/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
        Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
        Route::delete('/admin/product{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

        Route::get('/admin/artists', [AdminController::class, 'artists'])->name('admin.artists');
        Route::get('/admin/artist/add', [AdminController::class, 'add_artist'])->name('admin.artist.add');
        Route::post('/admin/artist/store', [AdminController::class, 'artist_store'])->name('admin.artist.store');
        Route::get('/admin/artist/edit/{id}', [AdminController::class, 'artist_edit'])->name('admin.artist.edit');
        Route::put('/admin/artist/update', [AdminController::class, 'update_artist'])->name('admin.artist.update');
        Route::delete('/admin/artist/{id}/delete', [AdminController::class, 'artist_delete'])->name('admin.artist.delete');

        Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
        Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
        Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
        Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
        Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

        Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
        Route::get('/admin/slide/add', [AdminController::class, 'slide_add'])->name('admin.slide.add');
        Route::post('/admin/slide/store', [AdminController::class, 'slide_store'])->name('admin.slide.store');
        Route::get('/admin/slide/{id}/edit', [AdminController::class, 'slide_edit'])->name('admin.slide.edit');
        Route::put('/admin/slide/update', [AdminController::class, 'slide_update'])->name('admin.slide.update');
        Route::delete('/admin/slide/{id}/delete', [AdminController::class, 'slide_delete'])->name('admin.slide.delete');

        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::get('/admin/edit', [AdminController::class, 'edit'])->name('admin.settings.edit');
        Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/update-password', [AdminController::class, 'updatePassword'])->name('admin.settings.password.update');


        Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/admin/order/{order_id}/details', [AdminController::class, 'order_details'])->name('admin.order.details');
        Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
        Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

        Route::get('/admin/reports/artist-sales', [AdminController::class, 'artistSalesReport'])->name('admin.artist.sales.report');
        
        Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
        Route::get('/admin/coupon/add', [AdminController::class, 'coupon_add'])->name('admin.coupon.add');
        Route::post('/admin/coupon/store', [AdminController::class, 'coupon_store'])->name('admin.coupon.store');
        Route::get('/admin/coupon/{id}/edit', [AdminController::class, 'coupon_edit'])->name('admin.coupon.edit');
        Route::put('/admin/coupon/update', [AdminController::class, 'coupon_update'])->name('admin.coupon.update');
        Route::delete('/admin/coupon/{id}/delete', [AdminController::class, 'coupon_delete'])->name('admin.coupon.delete');

        Route::get('/admin/contact', [AdminController::class, 'contacts'])->name('admin.contacts');
        Route::delete('/admin/contact/{id}/delete', [AdminController::class, 'contact_delete'])->name('admin.contact.delete');
        Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

        Route::get('/users/create', [AdminController::class, 'create'])->name('admin.user.create');
        Route::post('/users/store', [AdminController::class, 'user_store'])->name('admin.user.store');
        Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

        Route::resource('payment_methods', PaymentMethodController::class);
        Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('admin.payment-methods');
        Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('admin.payment-methods.create');
        Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('admin.payment-methods.store');
        Route::get('/payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('admin.payment-methods.edit');
        Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('admin.payment-methods.update');
        Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('admin.payment-methods.destroy');
        
        Route::get('/admin/payout-requests', [AdminPayoutController::class, 'index'])->name('admin.payout.requests');
        Route::get('/admin/payout-history', [AdminPayoutController::class, 'history'])->name('admin.payout.history');
        Route::post('/admin/payout-requests/{id}/approve', [AdminPayoutController::class, 'approve'])->name('admin.payout.approve');
        Route::post('/admin/payout-requests/{id}/decline', [AdminPayoutController::class, 'decline'])->name('admin.payout.decline');

        Route::get('/admin/reviews', [AdminController::class, 'manageReviews'])->name('admin.manage.reviews');
        Route::post('/admin/reviews/product/{id}/approve', [AdminController::class, 'approveProductReview'])->name('admin.reviews.product.approve');
        Route::post('/admin/reviews/product/{id}/reject', [AdminController::class, 'rejectProductReview'])->name('admin.reviews.product.reject');
        Route::post('/admin/reviews/artist/{id}/approve', [AdminController::class, 'approveArtistReview'])->name('admin.reviews.artist.approve');
        Route::post('/admin/reviews/artist/{id}/reject', [AdminController::class, 'rejectArtistReview'])->name('admin.reviews.artist.reject');
        
        Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::post('/admin/transactions/{id}/approve', [AdminController::class, 'approveTransaction'])->name('admin.transactions.approve');
        Route::post('/admin/transactions/{id}/decline', [AdminController::class, 'declineTransaction'])->name('admin.transactions.decline');
        Route::get('/admin/transaction-history', [AdminController::class, 'transactionHistory'])->name('admin.transaction-history');
        Route::get('/order/{orderId}/admin-invoice', [OrderController::class, 'downloadInvoiceForAdmin'])->name('admin.invoice');

    });

});