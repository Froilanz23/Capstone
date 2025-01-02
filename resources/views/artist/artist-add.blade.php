@extends('layouts.artist')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>ENTER YOUR INFORMATION</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('artist.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('artist.artists')}}">
                        <div class="text-tiny">Artists</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Register now</div>
                </li>
            </ul>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="wg-box">
            <form class="tf-section-1 form-new-product form-style-1" action="{{route('artist.artist.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- SCREEN NAME -->
                <fieldset class="name">
                    <div class="body-title mb-10">Artist Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Fill up artist name" name="name"
                        tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <!-- SLUG -->
                 <fieldset class="slug">
                    <div class="body-title">Artist unique name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="auto-fill" name="slug"
                        tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="mobile">
                    <div class="body-title">Phone no. <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Phone Number" name="mobile"
                        tabindex="0" value="{{old('mobile')}}" aria-required="true" required="">
                </fieldset>
                @error('mobile') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="address">
                    <div class="body-title"> Address <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Enter your address here" name="address"
                        tabindex="0" value="{{old('address')}}" aria-required="true" required="">
                </fieldset>
                @error('address') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
               
                <!-- ARTIST CATEGORY -->
                <fieldset class="art_practice">
                    <div class="body-title">Artist Category <span class="tf-color-1">*</span></div>
                    <select name="art_practice" tabindex="0">
                        <option value="" disabled selected>Select Visual Arts Category</option>
                        <option value="Painting">Painting</option>
                        <option value="Drawing">Drawing</option>
                        <option value="Digital Art">Digital Art</option>
                        <option value="Sculpture">Sculpture</option>
                        <option value="Photography">Photography</option>
                    </select>
                </fieldset>
                @error('art_practice')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                @enderror


               <!-- PROFILE PICTURE -->
                <fieldset>
                    <div class="body-title">Upload the artist's profile image <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreviewProfile" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text"> To upload, <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                

                <!-- DESCRIPTION -->
                <fieldset class="artist_description">
                    <div class="body-title">Artist Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="artist_description" placeholder="Do not exceed to 150 words when entering the artist description." tabindex="0" aria-required="true" required="">{{old('description')}}</textarea>
                </fieldset>
                @error('artist_description') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <!-- EMAIL -->
                <fieldset class="email">
                    <div class="body-title">Email <span class="tf-color-1"></span></div>
                    <input class="flex-grow" type="text" placeholder="Fill up with the artist's email address" name="email"
                        tabindex="0" value="{{old('email')}}" aria-required="true">
                </fieldset>
                @error('email') <span class="alert alert-danger text-center">{{$message}}</span> @enderror


                <!-- PortFolio URL -->
                <fieldset class="portfolio_url">
                    <div class="body-title">Portfolio URL <span class="tf-color-1"></span></div>
                    <input class="flex-grow" type="text" placeholder="Fill up with a URL of the artist's portfolio" name="portfolio_url"
                        tabindex="0" value="{{old('portfolio_url')}}" aria-required="true">
                </fieldset>
                @error('portfolio_url') <span class="alert alert-danger text-center">{{$message}}</span> @enderror


                <!-- WORKPLACE PICTURE -->
                <fieldset>
                    <div class="body-title">Upload a photo of the artist in the workplace <span class="tf-color-1"></span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreviewWorkplace" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="wFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text"> To upload, <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="wFile" name="workplace_photo" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('workplace_photo') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title">Upload a photo of your Valid ID <span class="tf-color-1"></span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreviewValidId" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="idFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text"> To upload, <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="idFile" name="valid_id" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('valid_id') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push("scripts")
    <script>
             $(function(){
        // Handle Profile Picture Upload
        $("#myFile").on("change", function(e){
            const [file] = this.files;
            if (file) {
                $("#imgpreviewProfile img").attr('src', URL.createObjectURL(file));
                $("#imgpreviewProfile").show();                        
            }
        });


        // Handle Workplace Picture Upload
        $("#wFile").on("change", function(e){
            const [file] = this.files;
            if (file) {
                $("#imgpreviewWorkplace img").attr('src', URL.createObjectURL(file));
                $("#imgpreviewWorkplace").show();                        
            }
        });

        $("#idFile").on("change", function(e){
            const [file] = this.files;
            if (file) {
                $("#imgpreviewValidId img").attr('src', URL.createObjectURL(file));
                $("#imgpreviewValidId").show();                        
            }
        });


   // Slug generation
    $("input[name ='name']").on("change", function () {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });


        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }

    </script>
@endpush
