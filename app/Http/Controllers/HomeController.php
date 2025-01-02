<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $artists = Artist::orderBy('created_at', 'desc')->get();

        // Fetch top products based on price for sold products
        $topProducts = Product::with(['orderItems.order.user', 'ratings.user']) // Include buyer and reviews
        ->withCount(['ratings as average_rating' => function ($query) {
            $query->select(DB::raw('avg(rating)'));
        }])
        ->withCount(['orderItems as sold_count' => function ($query) {
            $query->whereHas('order', function ($orderQuery) {
                $orderQuery->where('status', 'delivered');
            });
        }])
        ->join('product_fees', 'products.id', '=', 'product_fees.product_id') // Join to include price
        ->select('products.*', 'product_fees.price_with_fee') // Include price_with_fee
        ->where('is_sold', true) // Ensure it's sold
        ->where('products.verification_status', 'approved') // Ensure it's approved
        ->orderByDesc('price_with_fee') // Order by price
        ->take(5) // Limit the number of items
        ->get();
    


    $fproducts = Product::select('products.*', 'product_fees.price_with_fee')
        ->join('product_fees', 'products.id', '=', 'product_fees.product_id')
        ->where('products.featured', 1)
        ->where('products.verification_status', 'approved')
        ->where('products.is_sold', false)
        ->get()
        ->take(8);

        $topArtists = Artist::withCount(['ratings as average_rating' => function ($query) {
            $query->select(DB::raw('avg(rating)'));
        }])
        ->withCount(['ratings']) // Count the total number of ratings
        ->withCount(['products as sold_artworks_count' => function ($query) {
            $query->whereHas('orderItems.order', function ($orderQuery) {
                $orderQuery->where('status', 'delivered'); // Only include delivered orders
            });
        }])
        ->where('verification_status', 'approved') // Ensure only approved artists
        ->orderByDesc('average_rating') // Order by average rating
        ->orderByDesc('sold_artworks_count') // Order by sold artworks count
        ->take(5)
        ->get();
    
    

    return view('index', compact('slides', 'categories', 'fproducts', 'topArtists', 'artists', 'topProducts'));
}



    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:11',
            'comment' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success','Your message has been sent Successfully :)');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name','LIKE',"%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function about()
    {
        return view('about');
    }

    
    public function buyer()
    {
        return view('buyerfaq');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function term()
    {
        return view('term');
    }

    public function error401()
    {
        return view('errors.401');
    }

    public function seller()
    {
        return view('sellerfaq');
    }

}
