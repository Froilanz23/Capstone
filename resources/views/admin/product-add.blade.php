@extends('layouts.admin')

@section('content')

    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add an Artwork</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('admin.products')}}"><div class="text-tiny">Artworks</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add an Artwork</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.store')}}" >
                @csrf
                <div class="wg-box">

                    <!-- BASIC INFO -->
                    <h5>BASIC INFORMATION</h5>

                    <!-- Title -->
                    <fieldset class="name">
                        <div class="body-title mb-10">Artwork name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter artwork name" name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                        <div class="text-tiny">Enter your artwork name.</div>
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <!-- Slug -->
                    <fieldset class="slug">
                        <div class="body-title mb-10">Slug (Auto-fill) <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="auto-fill" name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                        <div class="text-tiny">This is your artwork unique name to avoid duplication.</div>
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <!-- Artist and Category -->
                    <div class="gap22 cols">
                        <!-- Artist -->
                        <fieldset class="artist_id">
                            <div class="body-title mb-10">Artist<span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="artist_id">
                                    <option value="" disabled selected>Choose artist</option>
                                    @foreach ($artists as $artist)
                                    <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach                                      
                                </select>
                            </div>
                        </fieldset>
                        @error("artist_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                         <!-- Category -->
                        <fieldset class="category_id">
                            <div class="body-title mb-10">Visual Arts Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option value="" disabled selected>Choose category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach                                                                
                                </select>
                            </div>
                        </fieldset>
                        @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <!-- End of Artist and Category -->

                    <!-- Description Field -->
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required="">{{old('description')}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror


                    <hr>
                <!-- ARTWORK DETAILS -->
                <h5>ARTWORK DETAILS</h5>

                        <!-- Year Created and Dimensions -->
                        <div class="gap22 cols">

                            <!-- Year Created -->
                            <fieldset class="year_created">
                                <div class="body-title mb-10">Year Created<span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="number" placeholder="e.g., 2024" name="year_created" min="2000" max="{{ date('Y') }}" tabindex="0" value="{{ old('year_created') }}" required>
                            </fieldset>
                            @error("year_created") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                            <!-- Dimensions Field -->
                            <fieldset class="dimensions">
                                <div class="body-title mb-10">Dimensions</div>
                                <input class="mb-10" type="text" placeholder="e.g., 10x20x15 cm" name="dimensions" tabindex="0" value="{{old('dimensions')}}" aria-required="true">
                            <div class="text-tiny">Enter the dimensions in LxWxH format.</div>
                            </fieldset>
                            @error("dimensions") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                        </div>
                        <!-- End of Year Created and Dimensions -->

                    <!-- Medium and Style -->
                    <div class="cols gap22">
                        <!-- MEDIUM -->
                        <fieldset class="medium">
                            <div class="body-title mb-10">Medium<span class="tf-color-1">*</span></div>
                            <div class="select mb-10">
                                <select name="medium" tabindex="0">
                                    <option value="" disabled selected>Select Medium</option>
                                    <option value="Acrylic">Acrylic</option>
                                    <option value="Charcoal">Charcoal</option>
                                    <option value="Coffee">Coffee</option>
                                    <option value="Digital">Digital</option>
                                    <option value="Oil">Oil</option>
                                    <option value="Watercolor">Watercolor</option>
                                    <option value="Graphite">Graphite</option>
                                    <option value="Ink">Ink</option>
                                    <option value="Marker">Marker</option>
                                    <option value="Mixed Media">Mixed Media</option>
                                    <option value="Enamel">Enamel</option>
                                    <option value="Pastel">Pastel</option>
                                    <option value="Gouache">Gouache</option>
                                    <option value="Others">Others (Specified in the Description)</option>
                                </select>
                                <div class="text-tiny">If not within these choices, specify in the description box.</div>
                            </div>
                            </fieldset>
                            @error("medium") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                        <!-- STYLE -->
                        <fieldset class="style">
                            <div class="body-title mb-10">Style<span class="tf-color-1">*</span></div>
                            <div class="select mb-10">
                                <select name="style" tabindex="0">
                                    <option value="" disabled selected>Select Style</option>
                                    <option value="3D Art">3D Art</option>
                                    <option value="Abstract">Abstract</option>
                                    <option value="Abstract Expressionism">Abstract Expressionism</option>
                                    <option value="Art Deco">Art Deco</option>
                                    <option value="Avant-garde">Avant-garde</option>
                                    <option value="Classicism">Classicism</option>
                                    <option value="Conceptual">Conceptual</option>
                                    <option value="Contemporary">Contemporary</option>
                                    <option value="Constructivism">Constructivism</option>
                                    <option value="Cubism">Cubism</option>
                                    <option value="Dada">Dada</option>
                                    <option value="Documentary">Documentary</option>
                                    <option value="Expressionism">Expressionism</option>
                                    <option value="Fauvism">Fauvism</option>
                                    <option value="Figurative">Figurative</option>
                                    <option value="Fine Art">Fine Art</option>
                                    <option value="Folk">Folk</option>
                                    <option value="Futurism">Futurism</option>
                                    <option value="Illustration">Illustration</option>
                                    <option value="Impressionism">Impressionism</option>
                                    <option value="Installation Art">Installation Art</option>
                                    <option value="Minimalism">Minimalism</option>
                                    <option value="Photorealism">Photorealism</option>
                                    <option value="Pointillism">Pointillism</option>
                                    <option value="Pop Art">Pop Art</option>
                                    <option value="Portraiture">Portraiture</option>
                                    <option value="Realism">Realism</option>
                                    <option value="Street Art">Street Art</option>
                                    <option value="Surrealism">Surrealism</option>
                                    <option value="Others">Others (Specified in the Description)</option>
                                </select>
                            </div>
                            <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        </fieldset>
                        @error("style") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div> 
                    <!-- End of Medium and Style -->   

                    <!-- Subject and Material -->
                    <div class="cols gap22">

                        <!-- SUBJECT -->
                        <fieldset class="subject">
                            <div class="body-title mb-10">Subject<span class="tf-color-1">*</span></div>
                            <div class="select mb-10">
                                <select name="subject" tabindex="0">
                                    <option value="" disabled selected>Select a subject</option>
                                    <option value="Animals and Plants">Animals and Plants</option>
                                    <option value="Dreams and Fantasies">Dreams and Fantasies</option>
                                    <option value="Everyday Life">Everyday Life</option>
                                    <option value="Faith and Mythology">Faith and Mythology</option>
                                    <option value="Figures and Patterns">Figures and Patterns</option>
                                    <option value="History and Legend">History and Legend</option>
                                    <option value="Land Sea and Cityscapes">Land, Sea, and Cityscapes</option>
                                    <option value="Portraits">Portraits</option>
                                    <option value="Still Life">Still Life</option>
                                    <option value="Others">Others (Specified in the Description)</option>
                                </select>
                            </div>
                            <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        </fieldset>
                        @error("subject") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                
                        <!-- MATERIAL -->
                        <fieldset class="material">
                            <div class="body-title mb-10">Material<span class="tf-color-1">*</span></div>
                            <div class="select mb-10">
                                <select name="material" tabindex="0">
                                    <option value="" disabled selected>Select a material</option>
                                    <option value="Board">Board</option>
                                    <option value="Bronze">Bronze</option>
                                    <option value="Canvas">Canvas</option>
                                    <option value="Cardboard">Cardboard</option>
                                    <option value="Glass">Glass</option>
                                    <option value="Panel">Panel</option>
                                    <option value="Paper">Paper</option>
                                    <option value="Soft (Fabrics)">Soft (Fabrics)</option>
                                    <option value="Special Paper">Special Paper</option>
                                    <option value="Wood">Wood</option>
                                    <option value="Fabric">Fabric</option>
                                    <option value="Fine Art Paper">Fine Art Paper</option>
                                    <option value="Others">Others (Specified in the Description)</option>
                                </select>
                            </div>
                            <div class="text-tiny">If not within these choices, specify in the description box.</div>
                        </fieldset>
                    @error("material") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <!-- End of Subject and Material -->
                </div>
                <!-- End of Box-1 -->

                <!-- Box 2-->
                <div class="wg-box">

                        <!-- Images Field -->
                        <h5>ARTWORK IMAGES</h5>

                        <!-- Main Image -->
                        <fieldset>
                            <div class="body-title">Upload the main image <span class="tf-color-1">*</span></div>
                            <div class="upload-image flex-grow">
                                <div class="item" id="imgpreview" style="display:none">                            
                                    <img src="{{asset('uploads/products')}}" class="effect8" alt="">
                                </div>
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

                        <!-- Gallery Images -->
                        <fieldset>
                            <div class="body-title mb-10">Upload Gallery Images</div>
                            <div class="upload-image mb-16">                            
                                <div id ="galUpload" class="item up-load">
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
                        <!-- end of Images Field -->

                     <hr>
                     <!-- PRICE AND QUANTITY -->
                     <h5>PRICING AND AVAILABILITY</h5>
                     <div class="cols gap22">
                         <!-- Price Field  -->
                        <fieldset class="regular_price">                                                
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true" required="">                                              
                        </fieldset>
                        @error("regular_price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                         <!-- Quantity Field -->
                         <fieldset class="quantity">
                            <div class="body-title mb-10">Quantity</div>
                            <input readonly class="mb-10" type="text" name="quantity" value="{{ old('quantity', 1) }}" tabindex="0" aria-required="true">
                        </fieldset>
                        @error("quantity")
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                       
                    </div>
                    <!-- end of PRICE AND QUANTITY -->


                    <hr>
                    <!-- ADDITIONAL DETAILS -->
                    <h5>ADDITIONAL INFORMATION</h5>

                    <!-- FEATURED and COA -->
                    <div class="cols gap22">
                        <!-- FEATURED -->
                        <fieldset class="featured">
                            <div class="body-title mb-10">Featured Artwork</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>                                                        
                                </select>
                            </div>
                        </fieldset>
                        @error("featured") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
         
                        <!-- COA -->
                        <fieldset class="COA">
                            <div class="body-title mb-10">Has a Certificate of Authenticity</div>
                            <div class="select mb-10">
                                <select name="COA">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("COA") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
           
                    <!-- FRAMED and SIGNATURE -->
                    <div class="cols gap22">

                        <!-- Framed Field -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Is Framed</div>
                            <div class="select mb-10">
                                <select name="framed">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("framed") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
           
                        <!-- Signature Field -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Has Signature</div>
                            <div class="select mb-10">
                                <select name="signature">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error("signature") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <!-- End of FRAMED and SIGNATURE -->

                    <div class="cols gap10">
                           <button class="tf-button w-full" type="submit">Add product</>                                            
                    </div>
                
                </div>
                <!-- End of Box-2-->
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection

@push("scripts")
<script>
    $(function() {
    // Handle single file preview and remove
    $("#myFile").on("change", function() {
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr("src", URL.createObjectURL(file));
            $("#imgpreview").show();
        }
    });


    // Function to remove single file preview
    function removePreview(id) {
        $(`#${id}`).hide();
        $(`#${id} img`).attr("src", ""); // Clear image source
        $("#myFile").val(""); // Clear file input
    }


    // Handle multiple file preview and remove
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


    // Function to remove gallery images
    window.removeGalleryImage = function(button) {
        $(button).closest(".gitems").remove(); // Remove image container
        $("#gFile").val(""); // Clear file input if needed
    };


    // Slug generation
    $("input[name='name']").on("change", function() {
        $("input[name='slug']").val(StringToSlug($(this).val()));
    });
    });

    function StringToSlug(Text) {
        return Text.toLowerCase()
        .replace(/[^\w ]+/g, "")
        .replace(/ +/g, "-");
    }      
</script>


<style>
    /* Style for the "X" button */
    .remove-btn {
    position: absolute;
    top: 10px;   /* Distance from the top */
    right: 10px; /* Distance from the right */
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