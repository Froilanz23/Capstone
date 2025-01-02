@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <h3>Pending Artists</h3>
    
            <div class="wg-box">
                <div class="wg-table table-all-user">
                    @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                     @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Artist Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Portfolio</th>
                                <th>Profile Image</th>
                                <th>Valid ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingArtists as $artist)
                                <tr>
                                    <td>{{ $artist->name }}</td>
                                    <td>{{ $artist->art_practice }}</td>
                                    <td>{{ $artist->address }}</td>
                                    <td><a href="{{ $artist->portfolio_url }}" target="_blank">View Portfolio</a></td>
                                    <td>
                                        @if($artist->image)
                                            <img src="{{ asset('uploads/artists/' . $artist->image) }}" alt="Profile Image" width="50">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($artist->valid_id)
                                            <a href="{{ asset('uploads/artists/' . $artist->valid_id) }}" target="_blank">View ID</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.artist.approve', $artist->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT') <!-- This line tells Laravel to treat the request as a PUT request -->
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.artist.reject', $artist->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE') <!-- This tells Laravel to treat the request as a DELETE request -->
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>                            
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    {{ $pendingArtists->links() }}
                </div>
            </div>
        </div>

        
    </div>
@endsection
