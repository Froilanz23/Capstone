@extends('layouts.artist')
@section('content')

<style>
    .table td, .table th {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        max-width: 200px; /* Adjust column width as needed */
        vertical-align: middle;
    }

    .table td .name a {
        display: inline-block;
        text-decoration: none;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        max-width: 150px; /* Adjust for artist name column */
    }

    .table img {
        max-width: 50px;
        height: auto;
        border-radius: 50%;
    }

    .table .portfolio-url, .table .description {
        max-width: 150px; /* Adjust width for portfolio and description */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>


<div class="main-content-inner">
    @if(Session::has('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Your Information</h3>
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
                    <div class="text-tiny">Artists</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                @if (!$artists->isEmpty())
                <!-- Do not display Add New button if the artist record exists -->
                @else
                    <a class="tf-button style-1 w208" href="{{ route('artist.artist.add') }}">
                        <i class="icon-plus"></i> Register Here
                    </a>
                @endif
            
            </div>
            
            <!-- Flash Message -->
          

            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                {{-- <th style="width: 80px;">Artist#</th>  --}}
                                <th>Name</th>
                                <th>Artist Category</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Portfolio</th>
                                <th>Artworks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($artists as $artist)
                            <tr>
                                {{-- <td>{{ $artist->id }}</td> --}}
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ asset('uploads/artists/' . $artist->image) }}" alt="{{ $artist->name }}" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{ $artist->name }}</a>
                                    </div>
                                </td>
                                <td>{{ $artist->art_practice }}</td>
                                <td>{{ $artist->address }}</td>
                                <td class="description">{{ $artist->artist_description }}</td>
                                <td class="portfolio-url"><a href="{{ $artist->portfolio_url }}" target="_blank">{{ $artist->portfolio_url }}</a></td>
                                <td>{{ $artist->products_count }} Artwork</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('artist.artist.edit', ['id' => $artist->id]) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                        
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $artists->links('pagination::bootstrap-5')}}
                </div>
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
