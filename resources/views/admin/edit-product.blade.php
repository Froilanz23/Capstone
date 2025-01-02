@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Page Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.products.pending') }}">
                        <div class="text-tiny">Pending Artworks</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Edit Product</div>
                </li>
            </ul>
        </div>

        <!-- Edit Product Form -->
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="wg-box p-6 rounded-lg bg-white shadow-lg mb-6">
                <h4 class="text-2xl font-semibold mb-4">Edit Artwork Information</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <fieldset>
                        <label class="block mb-2 font-semibold">Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border rounded" required>
                    </fieldset>
                    
                    <fieldset>
                        <label class="block mb-2 font-semibold">Slug</label>
                        <input type="text" name="slug" value="{{ $product->slug }}" class="w-full p-2 border rounded" required>
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded">{{ $product->description }}</textarea>
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Price</label>
                        <input type="number" step="0.01" name="regular_price" value="{{ $product->regular_price }}" class="w-full p-2 border rounded" required>
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Quantity</label>
                        <input type="number" name="quantity" value="{{ $product->quantity }}" class="w-full p-2 border rounded" required>
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Year Created</label>
                        <input type="number" name="year_created" value="{{ $product->year_created }}" class="w-full p-2 border rounded">
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Dimensions</label>
                        <input type="text" name="dimensions" value="{{ $product->dimensions }}" class="w-full p-2 border rounded">
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Category</label>
                        <select name="category_id" class="w-full p-2 border rounded">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset>
                        <label class="block mb-2 font-semibold">Artist</label>
                        <select name="artist_id" class="w-full p-2 border rounded">
                            <option value="">Select Artist</option>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->id }}" {{ $product->artist_id == $artist->id ? 'selected' : '' }}>
                                    {{ $artist->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow-md">
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
