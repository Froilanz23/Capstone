@extends('layouts.admin')
 

@section('content')
<style>
    table {
    table-layout: fixed;
    width: 100%;
}

td, th {
    word-wrap: break-word;
    text-align: left;
    padding: 8px;
}

</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
    <h3>Manage Reviews</h3>

    <!-- Product Reviews -->\
    <div class="wg-box">
    <h3>Product Reviews</h3>
    @if($productReviews->isEmpty())
        <p>No pending product reviews.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productReviews as $review)
                    <tr>
                        <td>{{ $review->product->name }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }}</td>
                        <td>
                            {!! implode('<br>', array_map(function($chunk) {
                                return implode(' ', $chunk);
                            }, array_chunk(explode(' ', e($review->review)), 4))) !!}
                        </td>
                        <td>
                            <form action="{{ route('admin.reviews.product.approve', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.reviews.product.reject', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Artist Reviews -->
    <h3>Artist Reviews</h3>
    @if($artistReviews->isEmpty())
        <p>No pending artist reviews.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Artist</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($artistReviews as $review)
                    <tr>
                        <td>{{ $review->artist->name }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }}</td>
                        <td>
                            {!! implode('<br>', array_map(function($chunk) {
                                return implode(' ', $chunk);
                            }, array_chunk(explode(' ', e($review->review)), 4))) !!}
                        </td>
                        
                        <td>
                            <form action="{{ route('admin.reviews.artist.approve', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.reviews.artist.reject', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        </div>
    </div>
</div>
@endsection
