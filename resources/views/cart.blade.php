@extends('layouts.app')
@section('content')

<style>
  .text-success{
    color: rgb(0, 230, 0) !important;
  }

  .text-danger{
    color: rgb(255, 0, 0) !important;
  }
</style>
    
<main>
    <div class="pb-4"></div>
    <section class="shop-checkout container">
      <h3 class="page-title">Cart</h3>
      <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Payment</span>
            <em>Pay for your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Order Review</span>
            <em>Review your order and await for verification</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        @if($items->count()>0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{asset('uploads/products/thumbnails')}}/{{$item->model->image}}" width="120" height="120" alt="{{$item->name}}" />
                  </div>
                </td>
                <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4>{{$item->name}}</h4>
                    <ul class="shopping-cart__product-item__options">
                      <li><strong>Artist:</strong> {{ $item->model->artist->name }}</li>
                      <li><strong>{{ $item->model->category->name ?? 'Uncategorized' }}:</strong> {{ $item->model->medium ?? 'Uncategorized' }} on {{ $item->model->material ?? 'Uncategorized' }}</li>
                  </ul>
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__product-price">₱{{$item->price}}</span>
                </td>
                <td>
                  <div class="qty-control position-relative">
                    <input type="number" name="quantity" value="{{$item->qty}}" readonly class="qty-control__number text-center">
                  </div>
                </td>
                
                
                <td>
                  <span class="shopping-cart__subtotal">₱{{$item->subTotal()}}</span>
                </td>
                <td>
                  <form method="POST" action="{{route('cart.item.remove',['rowId'=>$item->rowId])}}">
                    @csrf
                    @method('DELETE')
                    <a href="javascript:void(0)" class="remove-cart">
                      <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                      </svg>
                  </a>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">

            @if(!Session::has('coupon'))
            <form action="{{route('cart.coupon.apply')}}" method="POST" class="position-relative bg-body">
              @csrf
              <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="">
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                value="APPLY COUPON">
            </form>

            @else
             <form action="{{route('cart.coupon.remove')}}" method="POST" class="position-relative bg-body">
              @csrf
              @method('DELETE')
              <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="@if(Session::has('coupon')) {{Session::get('coupon')['code']}} Applied! @endif">
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                value="REMOVE COUPON">
            </form>
            @endif

            <form action="{{route('cart.empty')}}" method="POST">
              @csrf
              @method('DELETE')
            <button class="btn btn-light" type="submit">REMOVE ALL ITEMS</button>
            </form>
          </div>

        </div>
        <div class="shopping-cart__totals-wrapper">
          <div class="sticky-content">
              <div class="shopping-cart__totals">
                  <h3>Cart Totals</h3>
                  <table class="cart-totals">
                      <tbody>
                          @if(Session::has('discounts'))
                              <tr>
                                  <th>Subtotal</th>
                                  <td class="text-right">₱{{ Cart::instance('cart')->subtotal() }}</td>
                              </tr>
                              <tr>
                                  <th>Discount ({{ Session("coupon")["code"] }})</th>
                                  <td class="text-right">- ₱{{ Session("discounts")["discount"] }}</td>
                              </tr>
                              <tr>
                                  <th>Subtotal After Discount</th>
                                  <td class="text-right">₱{{ Session("discounts")["subtotal"] }}</td>
                              </tr>
                              <tr>
                                  <th>Shipping</th>
                                  <td class="text-right">
                                      @if(session('shipping_option') == 'pickup')
                                          Free (Pick-up)
                                      @elseif(session('shipping_option') == 'shipping')
                                          Free (Within Pangasinan)
                                      @else
                                          Select a delivery option below
                                      @endif
                                  </td>
                              </tr>
                              <tr class="cart-total">
                                  <th>Total (Tax Included)</th>
                                  <td class="text-right">₱{{ Session("discounts")["total"] }}</td>
                              </tr>
                          @else
                              <tr>
                                  <th>Subtotal</th>
                                  <td class="text-right">₱{{ Cart::instance('cart')->subtotal() }}</td>
                              </tr>
                              <tr>
                                  <th>Shipping</th>
                                  <td class="text-right">
                                      @if(session('shipping_option') == 'pickup')
                                          Free (Pick-up)
                                      @elseif(session('shipping_option') == 'shipping')
                                          Free (Within Pangasinan)
                                      @else
                                      Select a delivery option below
                                      @endif
                                  </td>
                              </tr>
                              <tr class="cart-total">
                                  <th>Total (Tax Included)</th>
                                  <td class="text-right">₱{{ Cart::instance('cart')->total() }}</td>
                              </tr>
                          @endif
                      </tbody>
                  </table>
                  
                  <div class="cart-shipping-options mb-4">
                      <h3>Delivery Options</h3>
                      <form action="{{ route('cart.shipping.update') }}" method="POST">
                          @csrf
                          <div>
                              <input type="radio" id="pickup" name="shipping_option" value="pickup"
                                  {{ session('shipping_option') == 'pickup' ? 'checked' : '' }}>
                              <label for="pickup">Pick-up (contact via Phone or Email)</label>
                          </div>
                          <div>
                              <input type="radio" id="shipping" name="shipping_option" value="shipping"
                                  {{ session('shipping_option') == 'shipping' ? 'checked' : '' }}>
                              <label for="shipping">Ship (Free within Pangasinan)</label>
                          </div>
                          <button type="submit" class="btn btn-primary mt-2">Save delivery option</button>
                      </form>
                  </div>
                  <div>
                    @if(Session::has('success'))
                    <p class="text-success">{{Session::get('success')}}</p>
                    @elseif(Session::has('error'))
                    <p class="text-danger">{{Session::get('error')}}</p>
                    @endif 
                  </div>
              </div>
      
              <div class="mobile_fixed-btn_wrapper">
                  <div class="button-wrapper container">
                      <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                  </div>
              </div>
          </div>
      </div>
      
      
        @else
            <div class="row">
                <div class = "col-md-12 text-center pt-5 bp-5">
                    <p>No item found in your Cart</p>
                    <a href="{{route('shop.index')}}" class="btn btn-info">Shop Now</a>
                </div>
            </div>
        @endif
      </div>
    </section>
  </main>
@endsection

@push('scripts')

<script>
  $(function(){
    $(".remove-cart").on("click",function(){
      $(this).closest('form').submit();
    });
  })
</script>

@endpush