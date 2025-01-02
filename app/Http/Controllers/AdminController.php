<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Slide;
use App\Models\Transaction;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\ProductFee;
use App\Models\ProductRating;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch Recent Orders
        $orders = Order::with('orderItems')->orderBy('created_at', 'DESC')->take(10)->get();

        // Count Pending Transactions
        $pendingTransactionsCount = Transaction::where('status', 'pending')->count();

        // Dashboard Metrics
        $dashboardDatas = DB::select("
            SELECT 
                SUM(total) AS TotalAmount,
                SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
                COUNT(*) AS TotalOrders,
                SUM(IF(status='ordered', 1, 0)) AS TotalPendingOrders,
                SUM(IF(status='delivered', 1, 0)) AS TotalDeliveredOrders,
                SUM(IF(status='canceled', 1, 0)) AS TotalCanceledOrders
            FROM orders
        ");

        // Monthly Metrics
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
                    MONTH(created_at) AS MonthNo,
                    SUM(total) AS TotalAmount,
                    SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                    SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                    SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount
                FROM orders
                WHERE YEAR(created_at) = YEAR(CURRENT_DATE())
                GROUP BY YEAR(created_at), MONTH(created_at)
            ) D ON D.MonthNo = M.id
        ");

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

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount',
            'pendingTransactionsCount'
        ));
    }


      // PRODUCT MANAGEMENT
      public function products()
      {
          $products = Product::orderBy('created_at', 'DESC')->paginate(10);
          return view('admin.products', compact('products'));
      }
  
      public function product_add()
      {
          $categories = Category::select('id', 'name')->orderBy('name')->get();
          $artists = Artist::select('id', 'name')->orderBy('name')->get();
          return view('admin.product-add', compact('categories', 'artists'));
      }
  
      public function product_store(Request $request)
      {
          // Validation
              $request->validate([
                  'name' => 'required',
                  'slug' => 'required|unique:products,slug,' . $request->id,
                  
                  'category_id' => 'required',
                  'artist_id' => 'required',
                  
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
                  'featured' => 'required|boolean',
      
                  'image' => 'required|mimes:png,jpg,jpeg|max:2048',
                  'images' => 'nullable|array',
                  'images.*' => 'mimes:png,jpg,jpeg|max:2048',
              ]);
  
              $product = new Product();
              $product->name = $request->name;
              $product->slug = Str::slug($request->name);
              $product->description = $request->description;
              $product->regular_price = $request->regular_price;
              $product->quantity = $request->quantity;
              $product->dimensions = $request->dimensions;
              $product->year_created = $request->year_created;
      
              $product->category_id = $request->category_id;
              $product->artist_id = $request->artist_id;
      
              $product->medium = $request->medium;
              $product->style = $request->style;
              $product->subject = $request->subject;
              $product->material = $request->material;
              
              $product->COA = $request->COA;
              $product->framed = $request->framed;
              $product->signature = $request->signature;
              $product->featured = $request->featured;
      
              $current_timestamp = Carbon::now()->timestamp;
      
              //Handles main image
              if ($request->hasFile('image')) {
                  $image = $request->file('image');
                  $imageName = $current_timestamp . '.' . $image->extension();
                  $this->GenerateProductThumbnailsImage($image, $imageName);
                  $product->image = $imageName;
              }
          
              // Handle gallery images
              $gallery_arr = [];
              if ($request->hasFile('images')) {
                  $counter = 1;
                  $allowedExtensions = ['jpg', 'png', 'jpeg'];
                  foreach ($request->file('images') as $file) {
                      $extension = $file->getClientOriginalExtension();
                      if (in_array($extension, $allowedExtensions)) {
                          $filename = $current_timestamp . "-" . $counter . "." . $extension;
                          $this->GenerateProductThumbnailsImage($file, $filename);
                          $gallery_arr[] = $filename;
                          $counter++;
                      }
                  }
              }
          
              // Store gallery images as a comma-separated string
              $product->images = implode(',', $gallery_arr);
              $product->save();

                        // Calculate Fee Logic
            $feePercentage = 0.15; // 12% admin fee
            $fee = $product->regular_price * $feePercentage;
            $priceWithFee = $product->regular_price + $fee;

            // Store ProductFee
            ProductFee::create([
                'product_id' => $product->id,
                'regular_price' => $product->regular_price,
                'fee' => $fee,
                'price_with_fee' => $priceWithFee,
            ]);
          
              return redirect()->route('admin.products')->with('Status', 'Product has been added successfully');
          }
      // Thumbnail Generation Function for Products
      public function GenerateProductThumbnailsImage($image, $imageName)
      {
          $destinationPathThumbnail = public_path('uploads/products/thumbnails');
          $destinationPath = public_path('uploads/products');
          $img= Image::read($image->path());
  
          $img->cover(540,689,"top");
          $img->resize(540,689,function($constraint) {
              $constraint->aspectRatio();
          })->save($destinationPath.'/'.$imageName);
  
          $img->resize(104,104,function($constraint) {
              $constraint->aspectRatio();
          })->save($destinationPathThumbnail.'/'.$imageName);
      }
  
      public function product_edit($id)
      {
          $product = Product::find($id);
          $categories = Category::select('id','name')->orderBy('name')->get();
          $artists = Artist::select('id','name')->orderBy('name')->get();
          $subject = ['Animals and Plants', 'Dreams and Fantasies', 'Everyday Life', 'Faith and Mythology', 'Figures and Patterns', 'History and Legend', 'Land Sea and Cityscapes', 'Portraits', 'Still Life', 'Others'];
          $medium = ['Acrylic', 'Charcoal', 'Coffee', 'Digital', 'Oil', 'Watercolor', 'Graphite', 'Ink', 'Marker', 'Mixed Media', 'Enamel', 'Pastel', 'Gouache', 'Others'];
          $styles = ['3D Art', 'Abstract', 'Abstract Expressionism', 'Art Deco', 'Avant-garde', 'Classicism', 'Conceptual', 'Contemporary', 'Constructivism', 'Cubism', 'Dada', 'Documentary', 'Expressionism', 'Fauvism', 'Figurative', 'Fine Art', 'Folk', 'Futurism', 'Illustration', 'Impressionism', 'Installation Art', 'Minimalism', 'Photorealism', 'Pointillism', 'Pop Art', 'Portraiture', 'Realism', 'Street Art', 'Surrealism', 'Others'];
          $material = ['Board', 'Bronze', 'Canvas', 'Cardboard', 'Glass', 'Panel', 'Paper', 'Soft (Fabrics)', 'Special Paper', 'Wood', 'Fabric', 'Fine Art Paper'];
  
          return view('admin.product-edit', compact('product', 'categories', 'artists', 'subject', 'medium', 'styles', 'material'));
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
              'featured' => 'required|boolean',
              'COA' => 'nullable|boolean',
              'framed' => 'nullable|boolean',
              'signature' => 'nullable|boolean',
          ]);
      
          $product = Product::find($request->id);
      
          // Update all product fields
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
          $product->featured = $request->featured;
      
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
          $feePercentage = 0.15;
          $fee = $product->regular_price * $feePercentage;
          $priceWithFee = $product->regular_price + $fee;
      
          // Update ProductFee
          ProductFee::updateOrCreate(
              ['product_id' => $product->id],
              [
                  'regular_price' => $product->regular_price,
                  'fee' => $fee,
                  'price_with_fee' => $priceWithFee,
              ]
          );
      
      
          return redirect()->route('admin.products')->with('status', 'Product updated successfully');
      }
      
  
      public function product_delete($id)
      {
          $product = Product::find($id);
          if(File::exists(public_path('uploads/products').'/'.$product->image))
              {
              File::delete(public_path('uploads/products').'/'.$product->image);
              }
          if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->name))
              {
              File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
              }
  
          foreach(explode(',',$product->images) as $ofile)
              {
                  if(File::exists(public_path('uploads/products').'/'.$ofile))
                  {
                      File::delete(public_path('uploads/products').'/'.$ofile);
                  }
                  if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile))
                  {
                      File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                  }
              }
              
          $product->delete();
          return redirect()->route('admin.products')->with('status','Product has been deleted successfully!');
      
           }
  
        // Display all pending products
        public function pendingProducts()
        {
            $pendingProducts = Product::where('verification_status', 'pending')->orderBy('created_at', 'DESC')->paginate(10);
            return view('admin.pending-products', compact('pendingProducts'));
        }

        public function viewProduct($id)
        {
            $product = Product::with(['artist', 'category'])->findOrFail($id);
            return view('admin.product-view', compact('product'));
        }
        

        // AdminController.php

        public function editProduct($id)
        {
            $product = Product::findOrFail($id);
            $artists = Artist::orderBy('name')->get();
            $categories = Category::orderBy('name')->get();
            
            return view('admin.edit-product', compact('product', 'artists', 'categories'));
        }

        // Update the product with edited details
        public function updateProduct(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:products,slug,' . $id,
                'description' => 'required|string',
                'regular_price' => 'required|numeric',
                'quantity' => 'required|integer',
                'year_created' => 'nullable|integer',
                'dimensions' => 'nullable|string',
                'category_id' => 'nullable|integer',
                'artist_id' => 'nullable|integer',
            ]);

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->regular_price = $request->regular_price;
            $product->quantity = $request->quantity;
            $product->year_created = $request->year_created;
            $product->dimensions = $request->dimensions;
            $product->category_id = $request->category_id;
            $product->artist_id = $request->artist_id;
            $product->save();

            return redirect()->route('admin.products.pending')->with('status', 'Product updated successfully.');
        }

            public function pendingArtists()
        {
            // Fetch artists where verification status is 'pending'
            $pendingArtists = Artist::where('verification_status', 'pending')->orderBy('created_at', 'DESC')->paginate(10);

            return view('admin.pending-artists', compact('pendingArtists'));
        }

            public function approveArtist($id)
        {
            // Find the artist by ID
            $artist = Artist::findOrFail($id);

            // Set the artist's verification status to 'approved'
            $artist->verification_status = 'approved';
            $artist->save();

            // Redirect back to the pending artists page with a success message
            return redirect()->route('admin.artists.pending')->with('status', 'Artist approved successfully.');
        }

        public function verifyArtist(Request $request, $id)
        {
            $artist = Artist::findOrFail($id);
            $artist->verification_status = $request->status; // e.g., pending, approved, rejected
            $artist->save();
        
            // Optionally, notify the artist of the verification decision
            if ($request->status == 'approved') {
                // Send notification for approved status
            } elseif ($request->status == 'rejected') {
                // Send notification for rejection
            }
        
            return redirect()->route('admin.artists.pending')->with('status', 'Artist status updated.');
        }
        

        public function handle($request, Closure $next)
        {
            if (Auth::check() && Auth::user()->verified == 2) {
                Auth::logout(); // Log the user out
                return redirect()->route('register')->with('error', 'Your account has been rejected. Please register again.');
            }
    
            return $next($request);
        }
        
    
        // Approve a product
        public function approveProduct($id)
        {
            $product = Product::findOrFail($id);
            $product->verification_status = 'approved';
            $product->save();
    
            return redirect()->route('admin.products.pending')->with('status', 'Product approved successfully.');
        }
    
        // Reject a product
        public function rejectProduct($id)
        {
            $product = Product::findOrFail($id);
            $product->verification_status = 'rejected';
            $product->save();
    
            return redirect()->route('admin.products.pending')->with('status', 'Product rejected successfully.');
        }



    public function artists() 
    {
        $artists = Artist::withCount('products')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.artists',compact('artists'));
    }

    public function add_artist()
    {
        return view('admin.artist-add');
    }

    public function artist_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:11',
            'slug' => 'required|unique:artists,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'art_practice' => 'required|in:Painting,Drawing,Digital Art,Sculpture,Photography',
            'email' => 'required|email|max:255',
            'artist_description' => 'required|string',
            'valid_id' => 'required|mimes:png,jpg,jpeg|max:2048',
            'workplace_photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'portfolio_url' => 'nullable|url|max:2048',
            'address' => 'required|string|max:255',
        ]);
    
        $artist = new Artist();
        $artist->name = $request->name;
        $artist->mobile = $request->mobile;
        $artist->slug = Str::slug($request->name);
        $artist->address = $request->address;
    
        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = 'profile_' . Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateArtistThumbnailsImage($image, $file_name);
            $artist->image = $file_name;
        }
    
        // Handle workplace photo upload
        if ($request->hasFile('workplace_photo')) {
            $workplace_photo = $request->file('workplace_photo');
            $file_name = 'workplace_photo_' . Carbon::now()->timestamp . '.' . $workplace_photo->extension();
            $this->GenerateArtistThumbnailsImage($workplace_photo, $file_name);
            $artist->workplace_photo = $file_name;
        }
    
        // Handle valid ID upload
        if ($request->hasFile('valid_id')) {
            $valid_id = $request->file('valid_id');
            $file_name = 'valid_id_' . Carbon::now()->timestamp . '.' . $valid_id->extension();
            $this->GenerateArtistThumbnailsImage($valid_id, $file_name);
            $artist->valid_id = $file_name;
        }
    
        $artist->art_practice = $request->art_practice;
        $artist->email = $request->email;
        $artist->artist_description = $request->artist_description;
        $artist->portfolio_url = $request->portfolio_url;
    
        $artist->save();
    
        return redirect()->route('admin.artists')->with('status', 'Artist has been added successfully!');
    }
    

    public function artist_edit($id)
    {
        $artist = Artist::find($id);
        return view('admin.artist-edit',compact('artist'));
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
        
        $artist = new Artist();
        $artist->name = $request->name;
        $artist->slug = Str::slug($request->name);
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

    
    public function GenerateArtistThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/artists');
        $img= Image::read($image->path());
        $img->cover(258,313,"top");
        $img->resize(258,313,function($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function artist_delete($id) 
    {
        $artist = Artist::find($id);
        if (File::exists(public_path('uploads/artists').'/'.$artist->image))
        {
            File::delete(public_path('uploads/artists').'/'.$artist->image);
        }
        $artist->delete();
        return redirect()->route('admin.artists')->with('status','artist has been deleted successfully');
    }


    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateCategoryThumbnailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully!');
    }
    public function GenerateCategoryThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
                File::delete(public_path('uploads/categories') . '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateCategoryThumbnailsImage($image, $file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Record has been updated successfully !');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully');
    }

    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

    public function slide_add()
    {
        return view('admin.slide-add');
    }

    public function slide_store(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);
        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateSlideThumbnailsImage($image, $file_name);
        $slide->image = $file_name;
        $slide->save();
        return redirect()->route('admin.slides')->with("status", "Slide Added Successfully");
    }

    public function GenerateSlideThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/slides');
        $img = Image::read($image->path());
        $img->cover(400, 690, "top");
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function slide_edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide-edit', compact('slide'));
    }

    public function slide_update(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $slide = Slide::find($request->id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
                File::delete(public_path('uploads/slides') . '/' . $slide->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSlideThumbnailsImage($image, $file_name);
            $slide->image = $file_name;
        }
        $slide->save();
        return redirect()->route('admin.slides')->with("status", "Slide Updated Successfully");
    }

    public function slide_delete($id)
    {
        $slide = Slide::find($id);
        if (File::exists(public_path('uploads/slides') . '/' . $slide->image)); {
            File::delete(public_path('uploads/slides') . '/' . $slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides')->with("status", "Slide Deleted Successfully");
    }

    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with("status", "Message Deleted Successfully");
    }
    
        // COUPON FUNCTION
        public function coupons()
        {
            $coupons = Coupon::orderby('expiry_date', 'DESC')->paginate(12);
            return view('admin.coupons', compact('coupons'));
        }

        public function coupon_add()
        {
            return view('admin.coupon-add');
        }

        public function coupon_store(Request $request)
        {
            $request->validate([
                'code' => 'required',
                'type' => 'required', 
                'value' => 'required|numeric',
                'cart_value' => 'required|numeric',
                'expiry_date' => 'required|date',
            ]);

            $coupon = new Coupon();
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->value = $request->value;
            $coupon->cart_value = $request->cart_value;
            $coupon->expiry_date = $request->expiry_date;
            $coupon->save();
            return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
        }

        public function coupon_edit($id)
        {
            $coupon = Coupon::find($id);
            return view('admin.coupon-edit', compact('coupon'));
        } 

        public function coupon_update(Request $request)
        {
            $request->validate([
                'code' => 'required',
                'type' => 'required', 
                'value' => 'required|numeric',
                'cart_value' => 'required|numeric',
                'expiry_date' => 'required|date',
            ]);  

            $coupon = Coupon::find($request->id);
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->value = $request->value;
            $coupon->cart_value = $request->cart_value;
            $coupon->expiry_date = $request->expiry_date;
            $coupon->save();
            return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
        }

        public function coupon_delete($id)
        {
            $coupon = Coupon::find($id);
            $coupon->delete();
            return  redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
        } 


    // ORDER MANAGEMENT
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function transactions()
    {
        // Only fetch transactions with status 'pending'
        $transactions = Transaction::with(['order', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->paginate(12);
    
        return view('admin.transactions', compact('transactions'));
    }
    
    public function approveTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'approved';
        $transaction->save();
    
        // Update the related order's status
        $order = Order::find($transaction->order_id);
        if ($order) {
            $order->status = 'ordered';
            $order->save();
        }
    
        return redirect()->route('admin.transactions')->with('success', 'Transaction approved successfully.');
    }
    

    public function declineTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
    
        // Delete the receipt file if it exists
        if ($transaction->receipt && Storage::disk('public')->exists($transaction->receipt)) {
            Storage::disk('public')->delete($transaction->receipt);
        }
    
        $transaction->status = 'declined';
        $transaction->save();
    
        // Handle the associated order
        $order = Order::find($transaction->order_id);
        if ($order) {
            $order->status = 'canceled';
            $order->canceled_date = now();
            $order->save();
    
            // Revert product quantities
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $product->quantity += $item->quantity;
                    $product->is_sold = false;
                    $product->save();
                }
            }
        }
    
        return redirect()->route('admin.transactions')->with('error', 'Transaction declined successfully.');
    }
    
    public function transactionHistory(Request $request)
    {
        $query = Transaction::with(['user', 'order']);
    
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // Filter by user name if provided
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }
    
        // Get transactions with pagination
        $transactions = $query->orderBy('created_at', 'DESC')->paginate(12);
    
        return view('admin.transaction-history', compact('transactions'));
    }
    
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }

        return back()->with('status', 'Order status updated successfully');
    }

    public function artistSalesReport(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();
        $artistId = $request->artist_id;
    
        // Individual Orders (without Quantity)
        $ordersQuery = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('artists', 'products.artist_id', '=', 'artists.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.delivered_date', [$startDate, $endDate])
            ->select(
                'orders.id as order_id',
                'products.name as product_name',
                'artists.name as artist_name',
                'order_items.price'
            );
    
        if ($artistId) {
            $ordersQuery->where('products.artist_id', $artistId);
        }
    
        $orders = $ordersQuery->get();
    
        // Artist Sales Summary (unchanged)
        $salesQuery = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('artists', 'products.artist_id', '=', 'artists.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.delivered_date', [$startDate, $endDate])
            ->selectRaw(
                'products.artist_id,
                artists.name as artist_name,
                SUM(products.regular_price) as total_earnings,
                SUM(product_fees.fee) as admin_commission'
            )
            ->join('product_fees', 'products.id', '=', 'product_fees.product_id')
            ->groupBy('products.artist_id', 'artists.name');
    
        if ($artistId) {
            $salesQuery->where('products.artist_id', $artistId);
        }
    
        $sales = $salesQuery->get();
    
        $artists = Artist::all(); // For the artist filter dropdown
    
        return view('admin.reports-artist-sales', compact('orders', 'sales', 'artists'));
    }
    
    // SEARCH FUNCTION
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->take(8)->get();
        return response()->json($results);
    }

    public function create()
    {
        return view('admin.user-create');
    }

    public function user_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:1,2,3', // 1=Admin, 2=Artist, 3=Customer
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User added successfully!');
    }

    public function users(Request $request)
    {
        $query = User::query();
    
        // Search by name
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        // Fetch users with total orders and artist products count
        $users = $query
            ->withCount('orders') // Total orders for all users
            ->with([
                'artist' => function ($query) {
                    $query->withCount('products'); // Count products for artists only
                }
            ])
            ->paginate(10);
    
        return view('admin.user', compact('users'));
    }
    
    public function invoices()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->save();

        return back()->with('success', 'Invoice status updated.');
    }

    

    // Show user edit form
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    // Update user information
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:11',
        ]);

        $user->update($request->only('name', 'email', 'mobile'));
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }


    public function settings()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id); // Get the authenticated user

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
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

        return redirect()->route('admin.settings')->with('success', 'Your Profile has been updated successfully.');
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

    public function manageReviews()
    {
        $productReviews = ProductRating::with('product', 'user')
            ->where('verification_status', 'pending')
            ->get();

        $artistReviews = Rating::with('artist', 'user')
            ->where('verification_status', 'pending')
            ->get();

        return view('admin.manage-reviews', compact('productReviews', 'artistReviews'));
    }

    // Approve a product review
    public function approveProductReview($id)
    {
        $review = ProductRating::findOrFail($id);
        $review->verification_status = 'approved';
        $review->save();

        return redirect()->route('admin.manage.reviews')->with('success', 'Product review approved successfully.');
    }

    // Reject a product review
    public function rejectProductReview($id)
    {
        $review = ProductRating::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.manage.reviews')->with('success', 'Product review rejected successfully.');
    }

    // Approve an artist review
    public function approveArtistReview($id)
    {
        $review = Rating::findOrFail($id);
        $review->verification_status = 'approved';
        $review->save();

        return redirect()->route('admin.manage.reviews')->with('success', 'Artist review approved successfully.');
    }

    // Reject an artist review
    public function rejectArtistReview($id)
    {
        $review = Rating::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.manage.reviews')->with('success', 'Artist review rejected successfully.');
    }


}