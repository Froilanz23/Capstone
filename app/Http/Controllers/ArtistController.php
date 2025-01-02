<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PayoutRequest;
use App\Models\ProductFee;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\User;

class ArtistController extends Controller
{

    public function __construct()
        {
            $this->middleware(function ($request, $next) {
                $artist = Auth::user()->artist;

                if ($artist) {
                    view()->share('artist', $artist);
                }

                return $next($request);
            });
        }

    
    public function index()
    {
        $artist = Auth::user()->artist;
    
        if (!$artist) {
            return redirect()->route('artist.add_artist')->with('error', 'Please complete your artist profile.');
        }
    
        $artistId = $artist->id; // Get the logged-in artist's ID
    
        // Fetch Recent Orders for the Artist
        $orders = Order::whereHas('orderItems.product', function ($query) use ($artistId) {
            $query->where('artist_id', $artistId);
        })
        ->with(['orderItems.product'])
        ->orderBy('created_at', 'DESC')
        ->take(10)
        ->get();
    
        // Dashboard Metrics for the Artist (using regular_price)
        $dashboardDatas = DB::select("
            SELECT 
                SUM(oi.quantity * pf.regular_price) AS TotalAmount, -- Total earnings based on regular_price
                SUM(IF(o.status='ordered', oi.quantity * pf.regular_price, 0)) AS TotalOrderedAmount,
                SUM(IF(o.status='delivered', oi.quantity * pf.regular_price, 0)) AS TotalDeliveredAmount,
                SUM(IF(o.status='canceled', oi.quantity * pf.regular_price, 0)) AS TotalCanceledAmount,
                COUNT(DISTINCT o.id) AS TotalOrders,
                SUM(IF(o.status='ordered', 1, 0)) AS TotalPendingOrders,
                SUM(IF(o.status='delivered', 1, 0)) AS TotalDeliveredOrders,
                SUM(IF(o.status='canceled', 1, 0)) AS TotalCanceledOrders
            FROM orders o
            INNER JOIN order_items oi ON o.id = oi.order_id
            INNER JOIN products p ON oi.product_id = p.id
            INNER JOIN product_fees pf ON p.id = pf.product_id -- Join product_fees for regular_price
            WHERE p.artist_id = :artistId
        ", ['artistId' => $artistId]);
    
        // Monthly Metrics for the Artist (using regular_price)
        $monthlyDatas = DB::select("
            SELECT 
                M.id AS MonthNo, 
                M.name AS MonthName,
                IFNULL(D.TotalAmount, 0) AS TotalAmount,
                IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
            FROM month_names M
            LEFT JOIN (
                SELECT 
                    MONTH(o.created_at) AS MonthNo,
                    SUM(oi.quantity * pf.regular_price) AS TotalAmount,
                    SUM(IF(o.status='ordered', oi.quantity * pf.regular_price, 0)) AS TotalOrderedAmount,
                    SUM(IF(o.status='delivered', oi.quantity * pf.regular_price, 0)) AS TotalDeliveredAmount,
                    SUM(IF(o.status='canceled', oi.quantity * pf.regular_price, 0)) AS TotalCanceledAmount
                FROM orders o
                INNER JOIN order_items oi ON o.id = oi.order_id
                INNER JOIN products p ON oi.product_id = p.id
                INNER JOIN product_fees pf ON p.id = pf.product_id -- Use regular_price from product_fees
                WHERE p.artist_id = :artistId AND YEAR(o.created_at) = YEAR(CURRENT_DATE())
                GROUP BY YEAR(o.created_at), MONTH(o.created_at)
            ) D ON D.MonthNo = M.id
        ", ['artistId' => $artistId]);
    
        // Chart Data Preparation
        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());
    
        // Totals
        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');
    
        return view('artist.index', compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));

    }
    
    public function products()
    {
        $artist = Auth::user()->artist;

        if (!$artist) {
            return redirect()->route('artist.index')->withErrors('You are not authorized to view products.');
        }

        $products = Product::with(['artist', 'category'])
            ->where('artist_id', $artist->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('artist.products', compact('products', 'artist'));
    }

    public function product_view($id)
    {
        $product = Product::with(['artist', 'category', 'productFee'])->findOrFail($id);
        // Logic to fetch and return product data
        return view('artist.product-view', compact('product')); // Ensure you have this Blade file
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $artist = Auth::user()->artist; // Retrieve the artist linked to the logged-in user

        if (!$artist || $artist->verification_status !== 'approved') {
            return redirect()->route('artist.index')->withErrors('You are not authorized to add products.');
        }

        return view('artist.product-add', compact('categories', 'artist'));
    }


    public function product_store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'year_created' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'medium' => 'nullable|in:Acrylic,Charcoal,Coffee,Digital,Oil,Watercolor,Graphite,Ink,Marker,Mixed Media,Enamel,Pastel,Gouache,Others',
            'style' => 'nullable|in:3D Art,Abstract,Abstract Expressionism,Art Deco,Avant-garde,Classicism,Conceptual,Contemporary,Constructivism,Cubism,Dada,Documentary,Expressionism,Fauvism,Figurative,Fine Art,Folk,Futurism,Illustration,Impressionism,Installation Art,Minimalism,Photorealism,Pointillism,Pop Art,Portraiture,Realism,Street Art,Surrealism,Others',
            'subject' => 'nullable|in:Animals and Plants,Dreams and Fantasies,Everyday Life,Faith and Mythology,Figures and Patterns,History and Legend,Land Sea and Cityscapes,Portraits,Still Life,Others',
            'material' => 'nullable|in:Board,Bronze,Canvas,Cardboard,Glass,Panel,Paper,Soft (Fabrics),Special Paper,Wood,Fabric,Fine Art Paper',
            'COA' => 'nullable|boolean',
            'framed' => 'nullable|boolean',
            'signature' => 'nullable|boolean',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = new Product();
        $product->artist_id = Auth::user()->artist->id;
        // Set the artist ID to the logged-in artist
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->quantity = $request->quantity;
        $product->dimensions = $request->dimensions;
        $product->year_created = $request->year_created;
        $product->category_id = $request->category_id;

        $product->medium = $request->medium;
        $product->style = $request->style;
        $product->subject = $request->subject;
        $product->material = $request->material;

        $product->COA = $request->COA ?? 0;
        $product->framed = $request->framed ?? 0;
        $product->signature = $request->signature ?? 0;
        $product->featured = 0;

        $current_timestamp = Carbon::now()->timestamp;

        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handle gallery images
        $gallery_arr = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $current_timestamp . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $this->GenerateProductThumbnailsImage($file, $filename);
                $gallery_arr[] = $filename;
            }
        }

        $product->images = implode(',', $gallery_arr); // Store as comma-separated string
        $product->save();

        // Fee Calculation
        $feePercentage = 0.15; // 12% fee
        $fee = $product->regular_price * $feePercentage;
        $priceWithFee = $product->regular_price + $fee;

        // Store fee details in ProductFee
        ProductFee::create([
            'product_id' => $product->id,
            'regular_price' => $product->regular_price, // Artist's earning
            'fee' => $fee, // Admin's commission
            'price_with_fee' => $priceWithFee, // Displayed price
        ]);

        return redirect()->route('artist.products')->with('status', 'Product has been added successfully.');
    }
    // Thumbnail Generation Function for Products
    public function GenerateProductThumbnailsImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');

        $img = Image::read($image->path());
        $img->resize(340, 489, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }


    public function product_edit($id)
    {
        $artist = Auth::user()->artist;

        // Check if the logged-in user is an artist and verified
        if (!$artist || $artist->verification_status !== 'approved') {
            return redirect()->route('artist.index')->withErrors('You are not authorized to edit products.');
        }

        // Retrieve the product belonging to the logged-in artist
        $product = Product::where('id', $id)->where('artist_id', $artist->id)->first();

        if (!$product) {
            return redirect()->route('artist.products')->withErrors('Product not found or you are not authorized to edit it.');
        }

        // Fetch required data for the edit form
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $subject = ['Animals and Plants', 'Dreams and Fantasies', 'Everyday Life', 'Faith and Mythology', 'Figures and Patterns', 'History and Legend', 'Land Sea and Cityscapes', 'Portraits', 'Still Life', 'Others'];
        $medium = ['Acrylic', 'Charcoal', 'Coffee', 'Digital', 'Oil', 'Watercolor', 'Graphite', 'Ink', 'Marker', 'Mixed Media', 'Enamel', 'Pastel', 'Gouache', 'Others'];
        $styles = ['3D Art', 'Abstract', 'Abstract Expressionism', 'Art Deco', 'Avant-garde', 'Classicism', 'Conceptual', 'Contemporary', 'Constructivism', 'Cubism', 'Dada', 'Documentary', 'Expressionism', 'Fauvism', 'Figurative', 'Fine Art', 'Folk', 'Futurism', 'Illustration', 'Impressionism', 'Installation Art', 'Minimalism', 'Photorealism', 'Pointillism', 'Pop Art', 'Portraiture', 'Realism', 'Street Art', 'Surrealism', 'Others'];
        $material = ['Board', 'Bronze', 'Canvas', 'Cardboard', 'Glass', 'Panel', 'Paper', 'Soft (Fabrics)', 'Special Paper', 'Wood', 'Fabric', 'Fine Art Paper'];

        return view('artist.product-edit', compact('product', 'categories', 'subject', 'medium', 'styles', 'material', 'artist'));
    }



    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'artist_id' => 'required',
            'regular_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'year_created' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'medium' => 'nullable|in:Acrylic,Charcoal,Coffee,Digital,Oil,Watercolor,Graphite,Ink,Marker,Mixed Media,Enamel,Pastel,Gouache,Others',
            'style' => 'nullable|in:3D Art,Abstract,Abstract Expressionism,Art Deco,Avant-garde,Classicism,Conceptual,Contemporary,Constructivism,Cubism,Dada,Documentary,Expressionism,Fauvism,Figurative,Fine Art,Folk,Futurism,Illustration,Impressionism,Installation Art,Minimalism,Photorealism,Pointillism,Pop Art,Portraiture,Realism,Street Art,Surrealism,Others',
            'subject' => 'nullable|in:Animals and Plants,Dreams and Fantasies,Everyday Life,Faith and Mythology,Figures and Patterns,History and Legend,Land Sea and Cityscapes,Portraits,Still Life,Others',
            'material' => 'nullable|in:Board,Bronze,Canvas,Cardboard,Glass,Panel,Paper,Soft (Fabrics),Special Paper,Wood,Fabric,Fine Art Paper',
            'COA' => 'nullable|boolean',
            'framed' => 'nullable|boolean',
            'signature' => 'nullable|boolean',
        ]);

        $product = Product::find($request->id);

        // Update all product fields
        $product->artist_id = Auth::user()->artist->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->artist_id = $request->artist_id;
        $product->dimensions = $request->dimensions;
        $product->year_created = $request->year_created;
        $product->medium = $request->medium;
        $product->style = $request->style;
        $product->subject = $request->subject;
        $product->material = $request->material;
        $product->COA = $request->has('COA') ? $request->COA : 0;
        $product->framed = $request->has('framed') ? $request->framed : 0;
        $product->signature = $request->has('signature') ? $request->signature : 0;
        $product->featured = 0;

        $current_timestamp = Carbon::now()->timestamp;

        // MAIN IMAGE Handling
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
                File::delete(public_path('uploads/products') . '/' . $product->image);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImage($image, $imageName);
            $product->image = $imageName;
        }

        // GALLERY IMAGES Handling
        $gallery_arr = array_filter(explode(',', $product->images), function ($image) use ($request) {
            return !in_array($image, explode(',', $request->input('removed_images', '')));
        });

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, ['jpg', 'png', 'jpeg'])) {
                    $filename = $current_timestamp . '-' . uniqid() . '.' . $extension;
                    $this->GenerateProductThumbnailsImage($file, $filename);
                    $gallery_arr[] = $filename;
                }
            }
        }

        // Convert array to comma-separated string of filenames
        $product->images = implode(',', $gallery_arr);

        // Save the product after all updates
        $product->save();

        $feePercentage = 0.15; // 12% fee
        $fee = $product->regular_price * $feePercentage;
        $priceWithFee = $product->regular_price + $fee;

        ProductFee::updateOrCreate(
            ['product_id' => $product->id],
            [
                'regular_price' => $product->regular_price,
                'fee' => $fee,
                'price_with_fee' => $priceWithFee,
            ]
        );

        return redirect()->route('artist.products')->with('status', 'Product has been updated successfully');
    }

    public function product_delete($id)
    {
        // Retrieve the artist linked to the logged-in user
        $artist = Auth::user()->artist;
    
        // Check if the artist exists and is verified
        if (!$artist) {
            return redirect()->route('artist.products')->withErrors('You are not authorized to delete products.');
        }
    
        // Find the product and ensure it belongs to the logged-in artist
        $product = Product::where('id', $id)->where('artist_id', $artist->id)->first();
    
        if (!$product) {
            return redirect()->route('artist.products')->withErrors('Product not found or you are not authorized to delete it.');
        }
    
        // Delete the product's main image if it exists
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }
    
        // Delete the product's gallery images if they exist
        foreach (explode(',', $product->images) as $image) {
            if (File::exists(public_path('uploads/products') . '/' . $image)) {
                File::delete(public_path('uploads/products') . '/' . $image);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $image)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $image);
            }
        }
    
        // Finally, delete the product record
        $product->delete();
    
        return redirect()->route('artist.products')->with('status', 'Product has been deleted successfully!');
    }
    

    public function artists()
    {
        $artistId = Auth::id(); // Get the authenticated artist's ID
        $artists = Artist::where('user_id', $artistId)->withCount('products')->orderBy('id', 'DESC')->paginate(10);
        return view('artist.artists', compact('artists'));
    }

    public function add_artist()
    {
        $existingArtist = Artist::where('user_id', Auth::id())->first();
        if ($existingArtist) {
            return redirect()->route('artist.artists')
                ->with('status', 'You have already filled out the verification form.');
        }

        return view('artist.artist-add');
    }


    public function artist_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'nullable',
            'mobile' => 'required|string|max:11',
            'slug' => 'required|unique:artists,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'art_practice' => 'required|in:Painting,Drawing,Digital Art,Sculpture,Photography',
            'email' => 'required|email|max:255',
            'artist_description' => 'nullable|string',
            'valid_id' => 'required|mimes:png,jpg,jpeg|max:2048',
            'workplace_photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'portfolio_url' => 'nullable|url|max:2048',
            'address' => 'required|string|max:255', // Validate address field
        ]);

        $artist = new Artist();
        $artist->user_id = Auth::id();
        $artist->name = $request->name;
        $artist->mobile = $request->mobile;
        $artist->slug = Str::slug($request->name);
        $artist->address = $request->address; // Add address field

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = 'profile_' . Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateArtistThumbnailsImage($image, $file_name);
            $artist->image = $file_name;
        }

        if ($request->hasFile('workplace_photo')) {
            $workplace_photo = $request->file('workplace_photo');
            $workplace_photo_extension = $workplace_photo->extension();
            $workplace_photo_name = 'workplace_photo_' . Carbon::now()->timestamp . '.' . $workplace_photo_extension;
            $this->GenerateArtistThumbnailsImage($workplace_photo, $workplace_photo_name);
            $artist->workplace_photo = $workplace_photo_name;
        }

        if ($request->hasFile('valid_id')) {
            $valid_id = $request->file('valid_id');
            $valid_id_extension = $valid_id->extension();
            $valid_id_name = 'valid_id_' . Carbon::now()->timestamp . '.' . $valid_id_extension;
            $this->GenerateArtistThumbnailsImage($valid_id, $valid_id_name);
            $artist->valid_id = $valid_id_name;
        }


        // Set additional artist fields
        $artist->art_practice = $request->art_practice;
        $artist->email = $request->email;
        $artist->artist_description = $request->artist_description;
        $artist->portfolio_url = $request->portfolio_url;

        // Save the artist and redirect
        $artist->save();
        return redirect()->route('artist.artists')->with('success', 'Your registration form has been sent, wait for confirmation.');
    }

    public function artist_edit($id)
    {
        $artist = Artist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('artist.artist-edit', compact('artist'));
    }

    public function update_artist(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:artists,slug,' . $request->id,
            'mobile' => 'required|string|max:11',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'art_practice' => 'required|in:Painting,Drawing,Digital Art,Sculpture,Photography',
            'email' => 'required|email|max:255',
            'artist_description' => 'nullable|string',
            'valid_id' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'workplace_photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'portfolio_url' => 'nullable|url',
            'address' => 'required|string|max:255', // Validate address field
        ]);

        $artist = Artist::where('id', $request->id)->where('user_id', Auth::id())->firstOrFail();
        $artist->name = $request->name;
        $artist->slug = Str::slug($request->name);
        $artist->mobile = $request->mobile;
        $artist->address = $request->address; // Add address field


        // Set additional artist fields
        $artist->art_practice = $request->art_practice;
        $artist->email = $request->email;
        $artist->artist_description = $request->artist_description;
        $artist->portfolio_url = $request->portfolio_url;

        // Handle workplace picture upload
        if ($request->hasFile('workplace_photo')) {
            // Delete existing workplace image if it exists
            if (File::exists(public_path('uploads/artists') . '/' . $artist->workplace_photo)) {
                File::delete(public_path('uploads/artists') . '/' . $artist->workplace_photo);
            }

            // Process new workplace image upload
            $workplace_photo = $request->file('workplace_photo');
            $workplace_photo_extension = $workplace_photo->extension();
            $workplace_photo_name = 'workplace_' . Carbon::now()->timestamp . '.' . $workplace_photo_extension;
            $this->GenerateArtistThumbnailsImage($workplace_photo, $workplace_photo_name);
            $artist->workplace_photo = $workplace_photo_name;
        }

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            // Delete existing profile image if it exists
            if (File::exists(public_path('uploads/artists') . '/' . $artist->image)) {
                File::delete(public_path('uploads/artists') . '/' . $artist->image);
            }

            // Process new profile image upload
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = 'profile_' . Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateArtistThumbnailsImage($image, $file_name);
            $artist->image = $file_name;
        }

        // Handle profile valid id upload
        if ($request->hasFile('valid_id')) {
            // Delete existing profile image if it exists
            if (File::exists(public_path('uploads/artists') . '/' . $artist->valid_id)) {
                File::delete(public_path('uploads/artists') . '/' . $artist->valid_id);
            }

            // Process new profile image upload
            $valid_id = $request->file('valid_id');
            $file_extension = $valid_id->extension();
            $file_name = 'valid_id_' . Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateArtistThumbnailsImage($valid_id, $file_name);
            $artist->valid_id = $file_name;
        }

        $artist->save();
        return redirect()->route('artist.artists')->with('status', 'Record has been updated successfully!');
    }

    public function artistProfile($id)
    {
        $artist = Artist::where('id', $id)
            ->where('verification_status', 'approved') // Ensure artist is verified
            ->firstOrFail();

        // Fetch artworks with verification_status = approved
        $artworks = Product::join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->select('products.*', 'product_fees.price_with_fee') // Include price_with_fee
            ->where('products.artist_id', $id)
            ->where('products.verification_status', 'approved') // Only approved artworks
            ->get();

        // Fetch sold artworks with verification_status = approved
        $soldArtworks = Product::join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->select('products.*', 'product_fees.price_with_fee') // Include price_with_fee
            ->where('products.artist_id', $id)
            ->where('products.verification_status', 'approved') // Only approved artworks
            ->whereHas('orderItems', function ($query) {
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->where('status', 'delivered');
                });
            })
            ->get();

        // Determine if the logged-in user has purchased from the artist
        $hasPurchased = false;
        if (Auth::check()) {
            $hasPurchased = OrderItem::whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 'delivered');
            })
                ->whereHas('product', function ($query) use ($id) {
                    $query->where('artist_id', $id)
                        ->where('verification_status', 'approved'); // Only approved products
                })
                ->exists();
        }
        

        // Pass all necessary variables to the view
        return view('profile', compact('artist', 'artworks', 'soldArtworks', 'hasPurchased'));
    }


    public function publicArtists()
    {
        // Fetch only verified artists
        $artists = Artist::where('verification_status', 'approved') // Ensure artist is verified
            ->withCount(['products' => function ($query) {
                $query->where('verification_status', 'approved'); // Count only approved artworks
            }])
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('artists', compact('artists'));
    }


    public function GenerateArtistThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/artists');
        $img = Image::read($image->path());
        $img->cover(258, 313, "top");
        $img->resize(258, 313, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function artist_delete($id)
    {
        // Optionally, check if the admin has the right to delete artists
        $artist = Artist::findOrFail($id);
        if (File::exists(public_path('uploads/artists') . '/' . $artist->image)) {
            File::delete(public_path('uploads/artists') . '/' . $artist->image);
        }
        $artist->delete();
        return redirect()->route('artist.artists')->with('status', 'Artist deleted successfully');
    }

    public function orders()
    {
        $artistId = Auth::user()->artist->id;
        $artist = Auth::user()->artist;

        $orders = Order::whereHas('orderItems.product', function ($query) use ($artistId) {
            $query->where('artist_id', $artistId);
        })
            ->with(['orderItems.product', 'transaction']) // Include transactions
            ->distinct()
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('artist.orders', compact('orders', 'artist'));
    }

    public function order_details($order_id)
    {
        $artistId = Auth::user()->artist->id;
        $artist = Auth::user()->artist;

        $order = Order::where('id', $order_id)
        ->whereHas('orderItems.product', function ($query) use ($artistId) {
            $query->where('artist_id', $artistId);
        })
        ->with(['orderItems.product', 'transaction'])
        ->select('id', 'tracking_number', 'shipping_company', 'status', 'created_at', 'delivered_date', 'canceled_date', 'phone', 'zip_code', 'name', 'house_number', 'street', 'barangay', 'city', 'state', 'country')
        ->firstOrFail();
    

        $orderItems = OrderItem::where('order_id', $order->id)
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->paginate(10);

        $transaction = Transaction::where('order_id', $order_id)->first();

        return view('artist.order-details', compact('order', 'orderItems', 'transaction', 'artist'));
    }

        public function addTrackingDetails(Request $request, $orderId)
        {
            $request->validate([
                'tracking_number' => 'required|string|max:255',
                'shipping_company' => 'required|string|max:255',
            ]);

            $order = Order::findOrFail($orderId);

            // Ensure the order belongs to the artist's product
            $artistId = Auth::user()->artist->id;
            $hasArtistProduct = $order->orderItems->contains(function ($item) use ($artistId) {
                return $item->product->artist_id == $artistId;
            });

            if (!$hasArtistProduct) {
                return redirect()->back()->with('error', 'Unauthorized to update this order.');
            }

            $order->update([
                'tracking_number' => $request->tracking_number,
                'shipping_company' => $request->shipping_company,
                'status' => 'shipped', // Automatically set status to shipped
            ]);

            return redirect()->back()->with('success', 'Tracking details added successfully.');
        }




    public function update_order_item_status(Request $request)
    {
        $artistId = Auth::user()->artist->id; // Get the authenticated artist's ID

        // Validate the input
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'status' => 'required|in:pending,ordered,shipped,delivered,canceled',
        ]);

        // Fetch the order item and ensure it belongs to the artist
        $orderItem = OrderItem::where('id', $request->order_item_id)
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->firstOrFail();

        // Update the order item's status
        $orderItem->status = $request->status;
        $orderItem->save();

        // Fetch the order
        $order = $orderItem->order;

        // Check if all items in the order have the same status
        $uniqueStatuses = $order->orderItems->pluck('status')->unique();

        if ($uniqueStatuses->count() === 1) {
            $order->status = $uniqueStatuses->first();

            if ($order->status == 'delivered') {
                $order->delivered_date = Carbon::now();
            } elseif ($order->status == 'canceled') {
                $order->canceled_date = Carbon::now();
            }

            $order->save();
        }

        return back()->with('status', 'Order item status updated successfully!');
    }

    public function update_order_status(Request $request)
    {
        $artistId = Auth::user()->artist->id; // Get the authenticated artist's ID

        // Validate the input
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_status' => 'required|in:pending,ordered,shipped,delivered,canceled',
        ]);

        // Fetch the order
        $order = Order::where('id', $request->order_id)->firstOrFail();

        // Fetch the order items owned by the artist
        $orderItems = OrderItem::where('order_id', $request->order_id)
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->get();

        if ($orderItems->isEmpty()) {
            return back()->withErrors('No items found for this order belonging to you.');
        }

        // Update the status for the order items owned by the artist
        foreach ($orderItems as $item) {
            $item->status = $request->order_status;
            $item->save();
        }

        // Check if all items in the order (regardless of artist) have the same status
        $allItems = $order->orderItems;
        $uniqueStatuses = $allItems->pluck('status')->unique();

        if ($uniqueStatuses->count() === 1) {
            $order->status = $uniqueStatuses->first();

            if ($order->status == 'delivered') {
                $order->delivered_date = Carbon::now();
            } elseif ($order->status == 'canceled') {
                $order->canceled_date = Carbon::now();
            }

            $order->save();
        }

        return back()->with('status', 'Order status updated successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function settings()
    {
        $artist = Auth::user()->artist;
        $user = Auth::user();
        return view('artist.settings', compact('user', 'artist'));
    }

    public function edit()
    {
        $artist = Auth::user()->artist;
        $user = Auth::user();
        return view('artist.settings', compact('user', 'artist'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id); // Get the authenticated user

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:11',
            'email' => 'required|email|unique:users,email,' . $user->id, // Use $user->id for unique validation
            'old_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic information
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['old_password' => 'The old password does not match.']);
            }
        }

        $user->save();

        return redirect()->route('artist.settings')->with('success', 'Your Profile has been updated successfully.');
    }

        public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password does not match.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user_id = Auth::user()->id;
        $user = User::find($user_id); // Ge
        $user->save();

        return redirect()->route('admin.settings')->with('success', 'Password updated successfully.');
    }

    public function salesReport(Request $request)
    {
        $artist = Auth::user()->artist;
    
        if (!$artist) {
            return redirect()->route('artist.index')->withErrors('You are not authorized to view sales reports.');
        }
    
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();
    
        // Individual Orders (only Regular Price)
        $orders = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.artist_id', $artist->id)
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.delivered_date', [$startDate, $endDate])
            ->select(
                'orders.id as order_id',
                'products.name as product_name',
                DB::raw('products.regular_price as total_price') // Use only the regular price
            )
            ->get();
    
        // Artist Sales Summary (only Regular Price)
        $salesSummary = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.artist_id', $artist->id)
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.delivered_date', [$startDate, $endDate])
            ->selectRaw('
                SUM(products.regular_price) as total_regular_price
            ')
            ->first();
    
        return view('artist.reports-sales', compact('artist','orders', 'salesSummary', 'startDate', 'endDate'));
    }


    public function payoutIndex()
    {
        $artist = Auth::user()->artist;
        $artistId = Auth::user()->artist->id;

        $totalEarnings = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->sum(DB::raw('products.regular_price * order_items.quantity'));

        $approvedPayouts = PayoutRequest::where('artist_id', $artistId)
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = $totalEarnings - $approvedPayouts;

        $payoutRequests = PayoutRequest::where('artist_id', $artistId)->orderBy('created_at', 'DESC')->get();

        return view('artist.payout', compact('availableBalance', 'payoutRequests', 'artist'));
    }



    public function requestPayout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1', // Ensure amount is positive
            'payment_method' => 'required|string', // Validate payment method
            'payment_details' => 'required|string', // Validate payment details
        ]);

        $artistId = Auth::user()->artist->id;

        // Calculate total sales for delivered orders
        $totalSales = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered'); // Only include delivered orders
        })
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId); // Filter by artist
            })
            ->sum(DB::raw('price * quantity'));

        // Check if the requested amount exceeds total sales
        if ($request->amount > $totalSales) {
            return back()->withErrors(['amount' => 'The requested amount exceeds your total sales.']);
        }

        // Create a new payout request
        PayoutRequest::create([
            'artist_id' => $artistId,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
        ]);



        // Redirect back with success message
        return redirect()->route('artist.payout')->with('success', 'Payout request submitted successfully.');
    }

    public function payout_edit($id)
    {
        $payoutRequest = PayoutRequest::findOrFail($id);
        $artistId = Auth::user()->artist->id;
        $artist = Auth::user()->artist;

        // Calculate total earnings from delivered orders
        $totalEarnings = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->sum(DB::raw('price * quantity'));

        // Subtract approved payouts
        $approvedPayouts = PayoutRequest::where('artist_id', $artistId)
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = $totalEarnings - $approvedPayouts;

        return view('artist.payout-edit', compact('payoutRequest', 'availableBalance', 'artist'));
    }

    public function payout_update(Request $request, $id)
    {
        $payoutRequest = PayoutRequest::findOrFail($id);

        // Ensure the payout request is still pending
        if ($payoutRequest->status != 'pending') {
            return redirect()->route('artist.payout')->withErrors('You can only edit pending payout requests.');
        }

        $artistId = Auth::user()->artist->id;

        // Recalculate available balance
        $totalEarnings = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })
            ->whereHas('product', function ($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->sum(DB::raw('products.regular_price * order_items.quantity'));

        $approvedPayouts = PayoutRequest::where('artist_id', $artistId)
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = $totalEarnings - $approvedPayouts;

        $request->validate([
            'amount' => "required|numeric|min:1|max:$availableBalance",
            'payment_method' => 'required|string',
            'payment_details' => 'required|string',
        ]);

        // Update the payout request
        $payoutRequest->update([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
        ]);

        return redirect()->route('artist.payout')->with('success', 'Payout request updated successfully.');
    }

    public function payout_delete($id)
    {
        $payoutRequest = PayoutRequest::findOrFail($id);

        if ($payoutRequest->status != 'pending') {
            return redirect()->route('artist.payout')->withErrors('You can only delete pending payout requests.');
        }

        $payoutRequest->delete();

        return redirect()->route('artist.payout')->with('success', 'Payout request deleted successfully.');
    }

    // public function reviews()
    
    // {
    //     $artist = Auth::user()->artist;
    //     $artistId = Auth::user()->artist->id;
    //     if (!$artist) {
    //         return redirect()->route('artist.index')->withErrors('You are not authorized to view reviews.');
    //     }
    
    //     $reviews = DB::table('product_ratings')
    //     ->join('products', 'product_ratings.product_id', '=', 'products.id')
    //     ->where('products.artist_id', $artist->id)
    //     ->select('product_ratings.*', 'products.name as product_name')
    //     ->orderBy('product_ratings.created_at', 'DESC')
    //     ->paginate(10);
    
    //  return view('artist.reviews', compact('artist', 'artworks', 'soldArtworks', 'reviews'));
    
    // }
    

}
