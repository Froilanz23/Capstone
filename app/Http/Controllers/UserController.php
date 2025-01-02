<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artist;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function edit()
    {
        return view('user.account-edit', ['user' => Auth::user()]);
    }

    public function showAdminLog()
    {
        return view('auth.adminlog');  // Correct view path based on the location
    }

    public function updatePassword(Request $request)
    {
        // Validate input
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        // Get the authenticated user
        $user_id = Auth::user()->id;
        $user = User::find($user_id);  // Ensure Auth facade is properly imported
    
        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password does not match our records.']);
        }
    
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return back()->with('success_password', 'Your password has been updated successfully.');
    }
    

    public function update(Request $request)
    {
        // Get the authenticated user
        $user_id = Auth::user()->id;
        $user = User::find($user_id); // Ensure Auth facade is properly imported
    
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
    
        // Update user information
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();
    
        return back()->with('success_info', 'Your account information has been updated successfully.');
    }
    
    

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();
        if ($order) {
            $orderItems = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order->id)->first();
            return view('user.order-details', compact('order', 'orderItems', 'transaction'));
        } else {
            return redirect()->route('login');
        }
    }

    public function userOrderDetails($order_id)
    {
        $order = Order::where('id', $order_id)
            ->with(['orderItems.product.artist', 'transaction'])
            ->firstOrFail();

        return view('user.order-details', compact('order'));
    }


    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
    
        if (!$order) {
            return back()->with('error', 'Order not found.');
        }
    
        // Update the order status to 'canceled'
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
    
        // Loop through order items and update the associated products
        foreach ($order->orderItems as $item) {
            $product = $item->product; // Ensure the `OrderItem` model has a `product` relationship
            if ($product && $product->is_sold) {
                $product->is_sold = false; // Mark the product as available
    
                // Increment the quantity by the quantity of the canceled order item
                $product->quantity += $item->quantity;
    
                $product->save();
            }
        }
    
        return back()->with('status', 'Order has been canceled successfully, and artworks have been returned to availability.');
    }
    


    public function account_details()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('user.account-details', compact('user'));
    }
    

    public function account_address()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('user.account-address', compact('addresses'));
    }

    public function create()
    {
        return view('user.create');
    }

        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:11',
            'zip_code' => 'required|numeric|digits:4',
            'state' => 'required',
            'city' => 'required',
            'barangay' => 'required', // Add barangay validation
            'house_number' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);

        $address = new Address();
        $address->fill($request->only([
            'name',
            'phone',
            'zip_code',
            'state',
            'city',
            'barangay', // Ensure barangay is stored
            'house_number',
            'street',
            'country',
        ]));
        $address->user_id = Auth::id();
        $address->isdefault = $request->has('isdefault') ? $request->isdefault : false;
        $address->save();

        return redirect()->route('user.addresses')->with('success', 'Address added successfully.');
    }



    public function edit_address($id)
    {
        $address = Address::findOrFail($id);
        return view('user.edit', compact('address'));
    }

    public function update_address(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:11',
            'zip_code' => 'required|numeric|digits:4',
            'state' => 'required',
            'city' => 'required',
            'barangay' => 'required', // Add barangay validation
            'house_number' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);
    
        $address = Address::findOrFail($id);
        $address->update($request->only([
            'name',
            'phone',
            'zip_code',
            'state',
            'city',
            'barangay', // Ensure barangay is updated
            'house_number',
            'street',
            'country',
        ]));
        $address->isdefault = $request->has('isdefault') ? $request->isdefault : $address->isdefault;
        $address->save();
    
        return redirect()->route('user.addresses')->with('success', 'Address updated successfully.');
    }
    
    

    public function delete_address($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id); // Ensure only the authenticated user's address can be deleted
        $address->delete();
    
        return redirect()->route('user.addresses')->with('success', 'Address deleted successfully.');
    }
    

    public function rateArtist(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);
    
        $artist = Artist::where('verification_status', 'approved') // Ensure artist is approved
        ->with(['ratings' => function ($query) {
            $query->where('verification_status', 'approved'); // Only include approved reviews
        }])
        ->findOrFail($id);
    
    
        // Check if the customer has already rated this artist
        $existingRating = $artist->ratings()->where('user_id', Auth::id())->first();
        if ($existingRating) {
            return back()->withErrors('You have already rated this artist.');
        }
    
        // Check if the user has purchased at least one artwork from the artist
        $hasPurchased = OrderItem::whereHas('order', function ($query) {
                $query->where('user_id', Auth::id()) // Filter by the authenticated user
                      ->where('status', 'delivered'); // Ensure the order is delivered
            })
            ->whereHas('product', function ($query) use ($id) {
                $query->where('artist_id', $id); // Filter by the artist
            })
            ->exists();
    
        if (!$hasPurchased) {
            return back()->withErrors('You can only rate an artist if you have purchased an artwork from them.');
        }
    
        // Save the rating and review
        $artist->ratings()->create([
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ]);
    
        return redirect()->back()->with('success', 'Your review has been submitted.');
    }

    public function rateProduct(Request $request, $productId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:255',
    ]);

    $hasPurchased = Product::findOrFail($productId);

    // Check if the user has purchased and received the product
    $hasPurchased = OrderItem::whereHas('order', function ($query) {
        $query->where('user_id', Auth::id()) // Filter by the authenticated user
              ->where('status', 'delivered'); // Ensure the order is delivered
            })
            ->where('product_id', $productId)
            ->exists();


    if (!$hasPurchased) {
        return back()->withErrors('You can only rate a product if you have purchased and received it.');
    }

    // Check if the user has already rated the product
    $existingRating = ProductRating::where('user_id', Auth::id())
                                   ->where('product_id', $productId)
                                   ->first();

    if ($existingRating) {
        return back()->withErrors('You have already rated this product.');
    }

    // Save the rating and review
    ProductRating::create([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'rating' => $request->input('rating'),
        'review' => $request->input('review'),
    ]);

    return redirect()->back()->with('success', 'Thank you for your review!');
}

}    