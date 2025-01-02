@extends('layouts.artist')


@section('content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">


                <!-- Page Title -->
                <h3>Edit Artwork</h3>


                <!-- Quick Navigation -->
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('artist.index')}}"><div class="text-tiny">Dashboard</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('artist.products')}}"><div class="text-tiny">Artworks</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Artwork</div>
                    </li>
                </ul>
            </div>


            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('artist.product.update')}}" >
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$product->id}}" />

                <!-- Box-1-->
                <div class="wg-box">

                <!-- BASIC INFO -->
                <h5>BASIC INFORMATION</h5>
                    <!-- Title -->
                    <fieldset class="name">
                        <div class="body-title mb-10">Artwork name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter artwork name" name="name" tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                        <div class="text-tiny">Enter your artwork name.</div>
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <!-- Slug -->
                    <fieldset class="slug">
                        <div class="body-title mb-10">Slug (Auto-fill) <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="auto-fill" name="slug" tabindex="0" value="{{ $product->slug }}" aria-required="true" required="">
                        <div class="text-tiny">This is your artwork unique name to avoid duplication.</div>
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                   <!-- ARTIST AND VISUAL ARTS CATEGORY -->
                    <div class="gap22 cols">
                        <!-- Artist (Auto-filled, Hidden Field) -->
                        <input type="hidden" name="artist_id" value="{{ Auth::user()->artist->id }}">

                        <!-- Category: Dropdown -->
                        <fieldset class="category_id">
                            <div class="body-title mb-10">Visual Arts Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="category_id" required>
                                    <option value="" disabled selected>Choose category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach                                                                
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <!-- end of ARTIST AND VISUAL ARTS CATEGORY -->

                    <!-- Description Field -->
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required="">{{$product->description}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <hr>
                <h5>ARTWORK DETAILS</h5>
                <!-- ARTWORK DETAILS -->
               
                <!-- YEAR CREATED AND DIMENSIONS-->
                <div class="gap22 cols">

                    <!-- Year Created -->
                    <fieldset class="year_created">
                        <div class="body-title mb-10">Year Created<span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="e.g., 2024" name="year_created" min="2000" max="{{ date('Y') }}" tabindex="0" value="{{$product->year_created}}" aria-required="true" required>
                    </fieldset>
                    @error("year_created") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <!-- Dimensions Field -->
                    <fieldset class="dimensions">
                        <div class="body-title mb-10">Dimensions</div>
                        <input class="mb-10" type="text" placeholder="e.g., 10x20x15 cm" name="dimensions" tabindex="0" value="{{$product->dimensions}}" aria-required="true" required="">
                    <div class="text-tiny">Enter the dimensions in LxWxH format.</div>
                    </fieldset>
                    @error("dimensions") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </div>
                <!-- end of YEAR CREATED AND DIMENSIONS-->

                <!-- MEDIUM AND STYLE-->
                <div class="cols gap22">
                    
                <!-- MEDIUM -->
                    <fieldset class="medium">
                        <div class="body-title mb-10">Medium<span class="tf-color-1">*</span></div>
                        <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        <div class="select mb-10">
                            <select name="medium" tabindex="0" aria-required="true" required>
                                <option value="" disabled selected>Select a medium</option>
                                <option value="Acrylic" {{ (old('medium', $product->medium) == 'Acrylic') ? 'selected' : '' }}>Acrylic</option>
                                <option value="Charcoal" {{ (old('medium', $product->medium) == 'Charcoal') ? 'selected' : '' }}>Charcoal</option>
                                <option value="Coffee" {{ (old('medium', $product->medium) == 'Coffee') ? 'selected' : '' }}>Coffee</option>
                                <option value="Digital" {{ (old('medium', $product->medium) == 'Digital') ? 'selected' : '' }}>Digital</option>
                                <option value="Oil" {{ (old('medium', $product->medium) == 'Oil') ? 'selected' : '' }}>Oil</option>
                                <option value="Watercolor" {{ (old('medium', $product->medium) == 'Watercolor') ? 'selected' : '' }}>Watercolor</option>
                                <option value="Graphite" {{ (old('medium', $product->medium) == 'Graphite') ? 'selected' : '' }}>Graphite</option>
                                <option value="Ink" {{ (old('medium', $product->medium) == 'Ink') ? 'selected' : '' }}>Ink</option>
                                <option value="Marker" {{ (old('medium', $product->medium) == 'Marker') ? 'selected' : '' }}>Marker</option>
                                <option value="Mixed Media" {{ (old('medium', $product->medium) == 'Mixed Media') ? 'selected' : '' }}>Mixed Media</option>
                                <option value="Enamel" {{ (old('medium', $product->medium) == 'Enamel') ? 'selected' : '' }}>Enamel</option>
                                <option value="Pastel" {{ (old('medium', $product->medium) == 'Pastel') ? 'selected' : '' }}>Pastel</option>
                                <option value="Gouache" {{ (old('medium', $product->medium) == 'Gouache') ? 'selected' : '' }}>Gouache</option>
                                <option value="Others" {{ (old('medium', $product->medium) == 'Others') ? 'selected' : '' }}>Others (Specified in the Description)</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("medium") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <!-- STYLE -->
                    <fieldset class="style">
                        <div class="body-title mb-10">Style<span class="tf-color-1">*</span></div>
                        <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        <div class="select mb-10">
                            <select name="style" tabindex="0" aria-required="true">
                                <option value="" disabled selected>Select a style</option>
                                <option value="3D Art" {{(old('style', $product->style) == '3D Art') ? 'selected' : '' }}>3D Art</option>
                                <option value="Abstract" {{(old('style', $product->style) == 'Abstract Art') ? 'selected' : '' }}>Abstract</option>
                                <option value="Abstract Expressionism" {{(old('style', $product->style) == 'Abstract Expressionism') ? 'selected' : '' }}>Abstract Expressionism</option>
                                <option value="Art Deco" {{(old('style', $product->style) == 'Art Deco') ? 'selected' : '' }}>Art Deco</option>
                                <option value="Avant-garde" {{(old('style', $product->style) == 'Avant-garde') ? 'selected' : '' }}>Avant-garde</option>
                                <option value="Classicism" {{(old('style', $product->style) == 'Classicism') ? 'selected' : '' }}>Classicism</option>
                                <option value="Conceptual" {{(old('style', $product->style) == 'Conceptual') ? 'selected' : '' }}>Conceptual</option>
                                <option value="Contemporary" {{(old('style', $product->style) == 'Contemporary') ? 'selected' : '' }}>Contemporary</option>
                                <option value="Constructivism" {{(old('style', $product->style) == 'Constructivism') ? 'selected' : '' }}>Constructivism</option>
                                <option value="Cubism" {{(old('style', $product->style) == 'Cubism') ? 'selected' : '' }}>Cubism</option>
                                <option value="Dada" {{(old('style', $product->style) == 'Dada') ? 'selected' : '' }}>Dada</option>
                                <option value="Documentary" {{(old('style', $product->style) == 'Documentary') ? 'selected' : '' }}>Documentary</option>
                                <option value="Expressionism" {{(old('style', $product->style) == 'Expressionism') ? 'selected' : '' }}>Expressionism</option>
                                <option value="Fauvism" {{(old('style', $product->style) == 'Fauvism') ? 'selected' : '' }}>Fauvism</option>
                                <option value="Figurative" {{(old('style', $product->style) == 'Figurative') ? 'selected' : '' }}>Figurative</option>
                                <option value="Fine Art" {{(old('style', $product->style) == 'Fine Art') ? 'selected' : '' }}>Fine Art</option>
                                <option value="Folk" {{(old('style', $product->style) == 'Folk') ? 'selected' : '' }}>Folk</option>
                                <option value="Futurism" {{(old('style', $product->style) == 'Futurism') ? 'selected' : '' }}>Futurism</option>
                                <option value="Illustration" {{(old('style', $product->style) == 'Illustration') ? 'selected' : '' }}>Illustration</option>
                                <option value="Impressionism" {{(old('style', $product->style) == 'Impressionism') ? 'selected' : '' }}>Impressionism</option>
                                <option value="Installation Art" {{(old('style', $product->style) == 'Installation Art') ? 'selected' : '' }}>Installation Art</option>
                                <option value="Minimalism" {{(old('style', $product->style) == 'Minimalism') ? 'selected' : '' }}>Minimalism</option>
                                <option value="Photorealism" {{(old('style', $product->style) == 'Photorealism') ? 'selected' : '' }}>Photorealism</option>
                                <option value="Pointillism" {{(old('style', $product->style) == 'Pointillism') ? 'selected' : '' }}>Pointillism</option>
                                <option value="Pop Art" {{(old('style', $product->style) == 'Pop Art') ? 'selected' : '' }}>Pop Art</option>
                                <option value="Portraiture" {{(old('style', $product->style) == 'Portraiture') ? 'selected' : '' }}>Portraiture</option>
                                <option value="Realism" {{(old('style', $product->style) == 'Realism') ? 'selected' : '' }}>Realism</option>
                                <option value="Street Art" {{(old('style', $product->style) == 'Street Art') ? 'selected' : '' }}>Street Art</option>
                                <option value="Surrealism" {{(old('style', $product->style) == 'Surrealism') ? 'selected' : '' }}>Surrealism</option>
                                <option value="Others" {{(old('style', $product->style) == 'Others') ? 'selected' : '' }}>Others (Specified in the Description)</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("style") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
            </div> 
            <!-- end of MEDIUM AND STYLE-->
                
           
            <!-- SUBJECT AND MATERIAL -->
            <div class="cols gap22">

                    <!-- SUBJECT -->
                    <fieldset class="subject">
                        <div class="body-title mb-10">Subject<span class="tf-color-1">*</span></div>
                        <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        <div class="select mb-10">
                            <select name="subject" tabindex="0" required aria-required="true">
                                <option value="" disabled selected>Select a subject</option>
                                <option value="Animals and Plants" {{(old('subject', $product->subject) == 'Animals and Plants') ? 'selected' : '' }}>Animals and Plants</option>
                                <option value="Dreams and Fantasies" {{(old('subject', $product->subject) == 'Dreams and Fantasies') ? 'selected' : '' }}>Dreams and Fantasies</option>
                                <option value="Everyday Life" {{(old('subject', $product->subject) == 'Everyday Life') ? 'selected' : '' }}>Everyday Life</option>
                                <option value="Faith and Mythology" {{(old('subject', $product->subject) == 'Faith and Mythology') ? 'selected' : '' }}>Faith and Mythology</option>
                                <option value="Figures and Patterns" {{(old('subject', $product->subject) == 'Figures and Patterns') ? 'selected' : '' }}>Figures and Patterns</option>
                                <option value="History and Legend" {{(old('subject', $product->subject) == 'History and Legend') ? 'selected' : '' }}>History and Legend</option>
                                <option value="Land Sea and Cityscapes" {{(old('subject', $product->subject) == 'Land Sea and Cityscapes') ? 'selected' : '' }}>Land, Sea, and Cityscapes</option>
                                <option value="Portraits" {{(old('subject', $product->subject) == 'Portraits') ? 'selected' : '' }}>Portraits</option>
                                <option value="Still Life" {{(old('subject', $product->subject) == 'Still Life') ? 'selected' : '' }}>Still Life</option>
                                <option value="Others" {{(old('subject', $product->subject) == 'Others') ? 'selected' : '' }}>Others (Specified in the Description)</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("subject") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
               
                    <!-- MATERIAL -->
                    <fieldset class="material">
                        <div class="body-title mb-10">Material<span class="tf-color-1">*</span></div>
                        <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        <div class="select mb-10">
                            <select name="material" tabindex="0" required aria-required="true">
                                <option value="" disabled selected>Select a material</option>
                                <option value="Board" {{(old('material', $product->material) == 'Board') ? 'selected' : '' }}>Board</option>
                                <option value="Bronze" {{(old('material', $product->material) == 'Bronze') ? 'selected' : '' }}>Bronze</option>
                                <option value="Canvas" {{(old('material', $product->material) == 'Canvas') ? 'selected' : '' }}>Canvas</option>
                                <option value="Cardboard" {{(old('material', $product->material) == 'Cardboard') ? 'selected' : '' }}>Cardboard</option>
                                <option value="Glass" {{(old('material', $product->material) == 'Glass') ? 'selected' : '' }}>Glass</option>
                                <option value="Panel" {{(old('material', $product->material) == 'Panel') ? 'selected' : '' }}>Panel</option>
                                <option value="Paper" {{(old('material', $product->material) == 'Paper') ? 'selected' : '' }}>Paper</option>
                                <option value="Soft (Fabrics)" {{(old('material', $product->material) == 'Soft (Fabrics)') ? 'selected' : '' }}>Soft (Fabrics)</option>
                                <option value="Special Paper" {{(old('material', $product->material) == 'Special Paper') ? 'selected' : '' }}>Special Paper</option>
                                <option value="Wood" {{(old('material', $product->material) == 'Wood') ? 'selected' : '' }}>Wood</option>
                                <option value="Fabric" {{(old('material', $product->material) == 'Fabric') ? 'selected' : '' }}>Fabric</option>
                                <option value="Fine Art Paper" {{(old('material', $product->material) == 'Fine Art Paper') ? 'selected' : '' }}>Fine Art Paper</option>
                                <option value="Others" {{(old('material', $product->material) == 'Others') ? 'selected' : '' }}>Others (Specified in the Description)</option>
                            </select>
                        </div>
                    </fieldset>
                    @error("material") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </div>
                <!-- end of SUBJECT and MATERIAL-->
            </div>
            <!-- end of Box-1--> 
             
            <!-- start of Box-2--> 
            <div class="wg-box">

                    <h5>ARTWORK IMAGES</h5>
                      <!-- Images Field -->

                    <!-- Main Image -->
                    <fieldset>
                        <div class="body-title mb-30">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            @if($product->image)
                            <div class="item" id="imgpreview">                            
                                <img src="{{asset('uploads/products')}}/{{$product->image}}" class="effect8" alt="{{$product->name}}">
                            </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error("image") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <!-- Gallery -->
                    <fieldset>
                        <div class="body-title mb-30">Upload Gallery Images</div>
                        <div class="upload-image mb-16">    
                            @if($product->images)
                            @foreach (explode(',', $product->images) as $img)
                            <div class="item gitems">
                                <img src="{{asset('uploads/products')}}/{{trim($img)}}" alt="">
                                <button type="button" class="remove-btn" onclick="removeGalleryImage(this)">x</button>
                            </div>
                            @endforeach
                            @endif
                   
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>                        
                    </fieldset>
                    @error("images") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <!-- end of images field -->

                    <hr>
                    <!-- PRICE AND QUANTITY -->
                    <h5>PRICING AND AVAILABILITY</h5>

                    <!-- PRICE AND QUANTITY -->
                    <div class="cols gap22">
                        <!-- Price Field  -->
                        <fieldset class="regular_price">                                                
                            <div class="body-title mb-30">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-30" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{$product->regular_price}}" aria-required="true" required="">                                              
                        </fieldset>
                        @error("regular_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                            <!-- Price with Fee Field -->
                        @if(isset($productFee))
                            <input type="hidden" name="price_with_fee" id="price_with_fee" value="{{ $productFee->price_with_fee }}">
                        @else
                            <input type="hidden" name="price_with_fee" id="price_with_fee" value="">
                        @endif

                         <!-- Quantity Field  -->
                        <fieldset class="quantity">
                            <div class="body-title mb-30">Quantity <span class="tf-color-1">*</span></div>
                            <input class="mb-30" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{$product->quantity}}" aria-required="true" required="">                                              
                        </fieldset>
                        @error("quantity") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <!-- end of PRICE AND QUANTITY -->

                    <hr>
                    <!-- ADDITIONAL INFO -->
                    <h5>ADDITIONAL INFORMATION</h5>

                    <!--COA, FRAMED, SIGNATURE -->
                    <div class="cols gap22">
                        <!-- COA -->
                        <fieldset class="COA">
                            <div class="body-title mb-30">Certificate of Authenticity</div>
                            <div class="select mb-30">
                                <select name="COA">
                                    <option value="0" {{$product->COA == "0" ? "selected":""}}>No</option>
                                    <option value="1" {{$product->COA == "1" ? "selected":""}}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("COA") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
           
                        <!-- Framed Field -->
                        <fieldset class="framed">
                            <div class="body-title mb-30">Framed</div>
                            <div class="select mb-30">
                                <select name="framed">
                                    <option value="0" {{$product->framed == "0" ? "selected":""}}>No</option>
                                    <option value="1" {{$product->framed == "1" ? "selected":""}}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("framed") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
           
                        <!-- Signature Field -->
                        <fieldset class="signature">
                            <div class="body-title mb-30">Signature</div>
                            <div class="select mb-30">
                                <select name="signature">
                                    <option value="0" {{$product->signature == "0" ? "selected":""}}>No</option>
                                    <option value="1" {{$product->signature == "1" ? "selected":""}}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("signature") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <!--  COA, FRAMED, SIGNATURE -->

                    <hr>
                        <div class="cols gap-30">
                            <button class="tf-button w-full" type="submit">Update product</button>                                            
                        </div>
            </div>
    </form>
    <!-- /form-add-product -->
    </div>
     <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->
@endsection

@push("scripts")
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photoInp = $("#myFile");                    
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();                        
                }
            }
        );


        // Function to remove single file preview
        function removePreview(id) {
            $(`#${id}`).hide();
            $(`#${id} img`).attr("src", ""); // Clear image source
            $("#myFile").val(""); // Clear file input
        }

        // Handle multiple file preview and remove
        // Array to hold names of images marked for deletion
        let removedImages = [];

        // Function to remove gallery image and mark for deletion
        window.removeGalleryImage = function(button) {
            const imageName = $(button).siblings('img').attr('src').split('/').pop(); // Get the image filename
            removedImages.push(imageName); // Add to removed images array
            $(button).closest('.gitems').remove(); // Remove the image from display
        };

        // Handle new file preview and add remove button
        $("#gFile").on("change", function() {
            const gphotos = this.files;
            $.each(gphotos, function(key, val) {
                $("#galUpload").prepend(`
                    <div class="item gitems">
                        <img src="${URL.createObjectURL(val)}" alt="">
                        <button type="button" class="remove-btn" onclick="removeGalleryImage(this)">x</button>
                    </div>
                `);
            });
        });


        // Pass removed images to the server by appending to the form data
        $('form').on('submit', function(e) {
            $('<input />').attr('type', 'hidden')
                        .attr('name', 'removed_images')
                        .attr('value', removedImages.join(',')) // Send removed images as a comma-separated string
                        .appendTo(this);
        });

        //Slug Name
        $("input[name='name']").on("change",function(){
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });
               
        });
            
        function StringToSlug(Text) {
            return Text.toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-");
        }      
        document.getElementById('regular_price').addEventListener('input', function () {
        const feePercentage = 0.15; // 12% fee
        const regularPrice = parseFloat(this.value) || 0;
        const priceWithFee = regularPrice + (regularPrice * feePercentage);
        document.getElementById('price_with_fee').value = priceWithFee.toFixed(2);
    });
    </script>


    <style>
        /* Style for the "X" button */
        .remove-btn {
        position: absolute;
        top: 5px;   /* Distance from the top */
        right: 5px; /* Distance from the right */
        transform: translateX(-50%);  /* Centers horizontally */
        background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        border-radius: 5px; /* Optional: rounded corners */
        transition: background-color 0.3s;
        }

        .remove-btn:hover {
            background-color: red;
            color: white;
        }

        /* Positioning the image container */
        .gitems {
            position: relative;
            display: inline-block;
            margin: 5px;
        }
    </style>
@endpush
