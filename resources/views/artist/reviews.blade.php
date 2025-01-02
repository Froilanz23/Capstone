@extends('layouts.artist')

@section('content')
<div class="container widened-container py-5">
    <h2 class="page-title text-center mb-5">My Reviews</h2>

    @if($reviews->isEmpty())
        <p class="text-center text-muted">No reviews found for your products.</p>
    @else
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->product_name }}</td>
                                <td>{{ $review->rating }} / 5</td>
                                <td>{{ $review->review ?? 'No review provided.' }}</td>
                                <td>{{ \Carbon\Carbon::parse($review->created_at)->format('F d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination justify-content-center">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
