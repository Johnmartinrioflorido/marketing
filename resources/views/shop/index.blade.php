@extends('layouts.app')

@section('title', 'Online Public Market')

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        transition: transform 0.4s ease-in-out;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .btn-success,
    .btn-warning {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-success:hover {
        background-color: #28a745;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
    }

    .btn-warning:hover {
        background-color: #ffc107;
        box-shadow: 0 0 15px rgba(255, 193, 7, 0.5);
    }

    .text-truncate {
        max-width: 100%;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-title,
    .card-text,
    .text-muted {
        transition: color 0.3s ease;
    }

    .card:hover .card-title {
        color: #007bff;
    }

    .card:hover .text-muted {
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to the Online Public Market</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($product->picture)
                        <img src="{{ asset('storage/' . $product->picture) }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}" 
                             style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                             class="card-img-top" 
                             alt="No Image Available" 
                             style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                        <p class="text-muted mb-2">
                            Sold by: 
                            <strong title="{{ $product->seller->name ?? 'Unknown Seller' }}">
                                {{ $product->seller->name ?? 'Unknown Seller' }}
                            </strong>
                        </p>
                        <p class="card-text mb-4 fw-bold">₱{{ number_format($product->price, 2) }}</p>

                        @auth
                            @if(auth()->user()->role === 'customer')
                                <form method="POST" action="{{ route('order.place', $product->id) }}" class="mb-3" novalidate>
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" required class="form-control" placeholder="Quantity" aria-label="Quantity">
                                        <button type="submit" class="btn btn-success" aria-label="Order Now">Order Now</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm px-3" aria-label="Add to Cart">
                                        <i class="bi bi-cart-plus me-1" aria-hidden="true"></i> Add to Cart
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    No products available at the moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
