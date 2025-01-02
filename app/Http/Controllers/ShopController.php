<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 12);
        $order = $request->query('order', -1);
        $f_artists = $request->query('artists', '');
        $f_categories = $request->query('categories', '');
        $min_price = $request->query('min', 0);
        $max_price = $request->query('max', 200000);

        // Define sorting options
        $sortingOptions = [
            1 => ['column' => 'created_at', 'order' => 'DESC'], // Newest
            2 => ['column' => 'created_at', 'order' => 'ASC'],  // Oldest
            3 => ['column' => 'regular_price', 'order' => 'ASC'], // Price Low to High
            4 => ['column' => 'regular_price', 'order' => 'DESC'], // Price High to Low
            -1 => ['column' => 'id', 'order' => 'DESC'], // Default
        ];

        $sort = $sortingOptions[$order] ?? $sortingOptions[-1];

        // Get filtered and paginated products
        $products = Product::join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->select('products.*', 'product_fees.price_with_fee')
            ->where('products.verification_status', 'approved')
            ->where('products.is_sold', false)
            ->where('products.quantity', '>', 0)
            ->when($f_artists, function ($query) use ($f_artists) {
                $artistIds = explode(',', $f_artists);
                $query->whereIn('products.artist_id', $artistIds);
            })
            ->when($f_categories, function ($query) use ($f_categories) {
                $categoryIds = explode(',', $f_categories);
                $query->whereIn('products.category_id', $categoryIds);
            })
            ->whereBetween('product_fees.price_with_fee', [$min_price, $max_price])
            ->orderBy($sort['column'], $sort['order'])
            ->paginate($size);

        // Artists and categories used for filters
        $artists = Artist::whereHas('products', function ($query) {
            $query->where('verification_status', 'approved');
        })->orderBy('name', 'ASC')->get();

        $categories = Category::whereHas('products', function ($query) {
            $query->where('verification_status', 'approved');
        })->orderBy('name', 'ASC')->get();

        return view('shop', compact('products', 'size', 'order', 'artists', 'f_artists', 'categories', 'f_categories', 'min_price', 'max_price'));
    }

    public function product_details($product_slug)
    {
        $product = Product::join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->select('products.*', 'product_fees.price_with_fee')
            ->where('products.slug', $product_slug)
            ->where('products.verification_status', 'approved')
            ->with([
                'artist' => function ($query) {
                    $query->withCount(['products' => function ($q) {
                        $q->where('verification_status', 'approved');
                    }]);
                },
                'ratings' => function ($query) {
                    $query->where('verification_status', 'approved'); // Fetch only verified reviews
                }
            ])
            ->firstOrFail();
    
        $relatedProducts = Product::join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->select('products.*', 'product_fees.price_with_fee')
            ->where('products.slug', '<>', $product_slug)
            ->where('products.verification_status', 'approved')
            ->get()
            ->take(8);
    
        // Determine if the user can rate the product
        $canRate = false;
        if (Auth::check()) {
            $canRate = OrderItem::whereHas('order', function ($query) {
                    $query->where('user_id', Auth::id())->where('status', 'delivered');
                })
                ->where('product_id', $product->id)
                ->exists();
        }
    
        $alreadyRated = false;
        if (Auth::check()) {
            $alreadyRated = ProductRating::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
    
        return view('details', compact('product', 'relatedProducts', 'canRate', 'alreadyRated'));
    }
    
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);

        // Check if the user has purchased this product and it has been delivered
        $hasPurchased = $product->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())->where('status', 'delivered');
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors('You can only rate a product that you have purchased and has been delivered.');
        }

        // Check if the user has already rated this product
        $existingRating = ProductRating::where('product_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRating) {
            return back()->withErrors('You have already rated this product.');
        }

        // Save the rating
        ProductRating::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ]);

        return back()->with('success', 'Your review has been submitted.');
    }

    public function soldProducts()
    {
        $soldProducts = Product::with(['orderItems.order.user', 'ratings.user']) // Include buyer and reviews
            ->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('avg(rating)'));
            }])
            ->join('product_fees', 'products.id', '=', 'product_fees.product_id') // Join to include price
            ->select('products.*', 'product_fees.price_with_fee') // Include price_with_fee
            ->where('is_sold', true) // Ensure it's sold
            ->where('products.verification_status', 'approved') // Ensure it's approved
            ->paginate(12); // Paginate results
    
        return view('sold-products', compact('soldProducts'));
    }
    
}
