@extends('layouts.artist')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Artist Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('artist.index') }}"><div class="text-tiny">Dashboard</div></a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('artist.artists') }}"><div class="text-tiny">Artists</div></a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Edit Your Information</div>
                </li>
            </ul>
        </div>

        <!-- Edit Form -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('artist.artist.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" value="{{ $artist->id }}">

                <!-- Artist Name -->
                <fieldset class="name">
                    <div class="body-title">Artist Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Fill up artist name" name="name" tabindex="0" 
                           value="{{ old('name', $artist->name) }}" required>
                </fieldset>
                @error('name') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <!-- Slug -->
                <fieldset class="slug">
                    <div class="body-title">Artist Unique Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="auto-fill" name="slug" tabindex="0" 
                           value="{{ old('slug', $artist->slug) }}" required>
                </fieldset>
                @error('slug') <span class="alert alert-danger">{{ $message }}</span> @enderror
                
                <fieldset class="mobile">
                    <div class="body-title">Phone number <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Phone no" name="mobile" tabindex="0" 
                           value="{{ old('mobile', $artist->mobile) }}" required>
                </fieldset>
                @error('mobile') <span class="alert alert-danger">{{ $message }}</span> @enderror


                <fieldset class="address">
                    <div class="body-title">Address<span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Edit your address" name="address" tabindex="0" 
                           value="{{ old('address', $artist->address) }}" required>
                </fieldset>
                @error('address') <span class="alert alert-danger">{{ $message }}</span> @enderror

    

                <!-- Profile picture -->
                <fieldset>
                    <div class="body-title">Upload Profile Picture <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        @if($artist->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/artists/' . $artist->image) }}" class="effect8" alt="Profile Picture">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myProfile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myProfile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("image") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <!-- Artist Category -->
                <fieldset class="art_practice">
                    <div class="body-title">Artist Category <span class="tf-color-1">*</span></div>
                    <select name="art_practice" tabindex="0" required>
                        <option value="" disabled>Select Visual Arts Category</option>
                        @foreach (['Painting', 'Drawing', 'Digital Art', 'Sculpture', 'Photography'] as $category)
                            <option value="{{ $category }}" {{ old('art_practice', $artist->artist_category) == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
                @error('art_practice') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <!-- Artist Description -->
                <fieldset class="artist_description">
                    <div class="body-title mb-10">Artist Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="artist_description" placeholder="Describe yourself..." required>{{ old('artist_description', $artist->artist_description) }}</textarea>
                </fieldset>
                @error('artist_description') <span class="alert alert-danger">{{ $message }}</span> @enderror
                
                <!-- Email -->
                <fieldset class="email">
                    <div class="body-title">Email <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="email" name="email" value="{{ old('email', $artist->email) }}" required>
                </fieldset>
                @error('email') <span class="alert alert-danger">{{ $message }}</span> @enderror

                  <!-- Portfolio URL -->
                <fieldset class="portfolio_url">
                    <div class="body-title">Portfolio URL <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="url" name="portfolio_url" value="{{ old('portfolio_url', $artist->portfolio_url) }}" required>
                </fieldset>
                @error('portfolio_url') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <!-- Workplace Photo -->
                <fieldset>
                    <div class="body-title">Upload Workplace Photo <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        @if($artist->workplace_photo)
                        <div class="item" id="imgpreviewWorkplace">
                            <img src="{{ asset('uploads/artists/' . $artist->workplace_photo) }}" class="effect8" alt="Workplace Photo">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="wpFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="wpFile" name="workplace_photo" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("workplace_photo") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <!-- Valid ID -->
                <fieldset>
                    <div class="body-title">Upload Valid ID <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        @if($artist->valid_id)
                        <div class="item" id="imgpreviewValidId">
                            <img src="{{ asset('uploads/artists/' . $artist->valid_id) }}" class="effect8" alt="Valid ID">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="idFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="idFile" name="valid_id" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error("valid_id") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror



                <!-- Submit Button -->
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        // Profile picture preview
        $("#myProfile").on("change", function (e) {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        // Workplace photo preview
        $("#wpFile").on("change", function (e) {
            const [file] = this.files;
            if (file) {
                $("#imgpreviewWorkplace img").attr('src', URL.createObjectURL(file));
                $("#imgpreviewWorkplace").show();
            }
        });

        // Valid ID photo preview
        $("#idFile").on("change", function (e) {
            const [file] = this.files;
            if (file) {
                $("#imgpreviewValidId img").attr('src', URL.createObjectURL(file));
                $("#imgpreviewValidId").show();
            }
        });

        // Slug generation
        $("input[name='name']").on("change", function () {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    });
</script>
@endpush