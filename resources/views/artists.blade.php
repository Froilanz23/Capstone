@extends('layouts.app')

@section('content')
<div class="container widened-container py-5">
    
    <!-- Hero Section -->
    <section class="text-center mb-5">
        <h1 class="text-primary font-weight-bold mb-3">Discover the Artists of A Salty Project</h1>
        <p class="text-muted">Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
            Voluptatibus placeat voluptatem modi itaque quas blanditiis. Fugit optio architecto ex numquam. 
            Blanditiis tempora laborum accusamus obcaecati quos id tenetur aliquid doloremque..</p>
    </section>

    <!-- Artists Section -->
    <section>
        <h2 class="text-center mb-4 text-dark font-weight-bold">Artists</h2>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 md-3">
            @foreach($artists as $artist)
            <div class="col">
                <div class="card shadow-sm border-0 rounded overflow-hidden">
                    <div class="pc__img-wrapper position-relative">
                        <a href="{{ route('artist.profile', ['id' => $artist->id]) }}">
                            <img loading="lazy" src="{{ asset('uploads/artists') }}/{{$artist->image}}" alt="{{$artist->name}}" class="pc__img">
                        </a>


                    </div>

                    <div class="card-body text-center p-2">
                        <h6 class="card-title font-weight-bold text-dark mb-1">{{ $artist->name }}</h6>
                        <p class="card-text text-muted mb-0" style="font-size: 0.8rem;">{{ $artist->art_practice }}</p>
                        <p class="card-text text-muted mb-0" style="font-size: 0.8rem;">{{ $artist->city }}{{ $artist->province }}</p>
                    </div>
                    <div class=" w-100 h-100 top-0 start-0 d-flex justify-content-center align-items-center opacity-0">
                        <a href="{{ route('artist.profile', ['id' => $artist->id]) }}">View Profile</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </section>


    <div class="d-flex justify-content-center mt-4">
        {{ $artists->links() }}
    </div>
</div>

<style>
    
    .widened-container {
        padding-left: 8rem; 
        padding-right: 8rem;
    }

    .pc__img {
        width: auto;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .pc__img:hover {
        transform: scale(1.05);
    }

    .card {
        border-radius: 10px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 0.5rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .view-more-overlay {
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .pc__img-wrapper:hover .view-more-overlay {
        opacity: 1;
    }

    h1, h2 {
        font-family: 'Arial', sans-serif;
    }

    section.text-center {
        padding: 3rem 1.5rem;
        border-radius: 15px;
    }

    section.text-center h1 {
        font-size: 2.2rem;
    }

    section.text-center p {
        font-size: 1rem;
    }


    .pagination {
        justify-content: center;
    }

</style>
@endsection