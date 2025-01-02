@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Artworks</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All Artworks</div>
                </li>
            </ul>
        </div>
        <div class="wg-box" style="width: 100%;"> <!-- Adjusted width for wg-box -->
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('status'))
                    <p class="alert-success">{{Session::get('status')}}</p>
                @endif
                <table class="table table-striped table-bordered" style="width: 120%;"> <!-- Adjusted width for table -->
                    <thead>
                        <tr>
                            <th>Item no.</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Artist</th>
                            <th>Medium</th>
                            <th>Style</th>
                            <th>Subject</th>
                            <th>Material</th>
                            <th>Year</th>
                            <th>Featured</th>
                            <th>Quantity</th>
                            <th>COA</th>
                            <th>Framed</th>
                            <th>Signature</th>
                            <th>Edit/Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('uploads\products\thumbnails')}}/{{$product->image}}" alt="{{$product->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                    <div class="text-tiny mt-3">{{$product->slug}}</div>
                                </div>
                            </td>
                            <td>₱{{$product->regular_price}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->artist->name}}</td>
                            <td>{{$product->medium}}</td>
                            <td>{{$product->style}}</td>
                            <td>{{$product->subject}}</td>
                            <td>{{$product->material}}</td>
                            <td>{{$product->year_created}}</td>
                            <td>{{$product->featured}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->COA}}</td>
                            <td>{{$product->framed}}</td>
                            <td>{{$product->signature}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.product.edit',['id'=>$product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete',['id'=>$product->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$products->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('.delete').on('click',function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
                    type: "warning",
                    buttons:["No","Yes"],
                    confirmButtonColor: '#dc3545'
                }).then(function(result) {
                    if(result) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
