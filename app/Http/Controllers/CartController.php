<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart',compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $product = Product::find($request->id);
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'This product is already sold.');
        }
    
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }
    

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
    
        // Validate coupon code input
        if (!isset($coupon_code) || empty($coupon_code)) {
            return redirect()->back()->with('error', 'Please enter a valid coupon code!');
        }
    
        // Fetch the coupon from the database
        $coupon = Coupon::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
            ->first();
    
        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid or expired coupon code!');
        }
    
        // Get the authenticated user
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
    
        // Check if the coupon has already been used by the authenticated user
        if ($user->coupons()->where('coupon_id', $coupon->id)->exists()) {
            return redirect()->back()->with('error', 'You have already used this coupon!');
        }
    
        // Attach the coupon to the user and handle session data
        try {
            $user->coupons()->attach($coupon->id);
    
            // Store coupon details in the session
            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);
    
            // Recalculate discount
            $this->calculateDiscount();
    
            return redirect()->back()->with('success', 'Coupon has been applied successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while applying the coupon. Please try again.');
        }
    }
    
    
    public function calculateDiscount()
    {
        if (!Session::has('coupon')) {
            return;
        }
    
        $coupon = Session::get('coupon');
        $subtotal = Cart::instance('cart')->subtotal();
    
        if ($subtotal <= 0) {
            Session::forget('coupon');
            Session::forget('discounts');
            return;
        }
    
        $discount = 0;
        if ($coupon['type'] == 'fixed') {
            $discount = min($coupon['value'], $subtotal); // Ensure discount doesn't exceed subtotal
        } else {
            $discount = ($subtotal * $coupon['value']) / 100;
        }
    
        $subtotalAfterDiscount = $subtotal - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;
    
        // Update session with calculated values
        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', ''),
        ]);
    }
    

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return back()->with('success', 'Coupon has been removed!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        $paymentMethods = PaymentMethod::all();
        $shippingOption = Session::get('shipping_option', 'default'); // Retrieve the selected shipping option
    
        return view('checkout', compact('address', 'paymentMethods', 'shippingOption'));
    }
    
    
    public function updateShippingOption(Request $request)
    {
        // Validate the shipping option input
        $request->validate([
            'shipping_option' => 'required|string',
        ]);
    
        // Store the selected shipping option in the session
        Session::put('shipping_option', $request->shipping_option);
    
        // Simply return a blank response or redirect back
        return back()->with('success', 'Shipping option updated successfully!');
    }
    


    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();
    
        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:11',
                'house_number' => 'required',
                'street' => 'required',
                'state' => 'required',
                'city' => 'required',
                'country' => 'required',
                'barangay' => 'required',
                'transaction_number' => 'required',
                'receipt' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                'zip_code' => 'required|numeric|digits:4'
            ]);
    
            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip_code = $request->zip_code;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->house_number = $request->house_number;
            $address->street = $request->street;
            $address->barangay = $request->barangay;
            $address->country = $request->country;
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }
    
        $this->setAmountForCheckout();
    
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->zip_code = $address->zip_code;
        $order->state = $address->state;
        $order->city = $address->city;
        $order->barangay = $address->barangay;
        $order->house_number = $address->house_number;
        $order->street = $address->street;
        $order->country = $address->country;
        $order->save();
    
        foreach (Cart::instance('cart')->content() as $item) {
            $product = Product::find($item->id);
    
            if ($product) {
                $feeOnTop = $product->productFee->fee ?? 0;
    
                $orderItem = new OrderItem();
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->price = $item->price;
                $orderItem->quantity = $item->qty;
                $orderItem->fee_on_top = $feeOnTop;
                $orderItem->save();
    
                $product->is_sold = true;
                $product->quantity = 0;
                $product->save();
            }
        }
    
        if ($request->mode == "BANK" || $request->mode == "Gcash") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->transaction_number = $request->transaction_number;

            if ($request->hasFile('receipt')) {
                $receipt = $request->file('receipt');
                $receiptPath = $receipt->store('receipts', 'public'); // Save to `storage/app/public/receipts`
                $transaction->receipt = $receiptPath;
            }

            $transaction->status = "pending";
            $transaction->save();
        }
    
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
    
        return redirect()->route('cart.order.confirmation', $order->id)->with('success', 'Your order has been placed.');
    }
    
    
  
    public function setAmountForCheckout()
    { 
        if(!Cart::instance('cart')->count() > 0)
        {
            session()->forget('checkout');
            return;
        }    

        if(session()->has('coupon'))
        {
            session()->put('checkout',[
                'discount' => session()->get('discounts')['discount'],
                'subtotal' =>  session()->get('discounts')['subtotal'],
                'tax' =>  session()->get('discounts')['tax'],
                'total' =>  session()->get('discounts')['total']
            ]);
        }
        else
        {
            session()->put('checkout',[
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total()
            ]);
        }
    }


    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
