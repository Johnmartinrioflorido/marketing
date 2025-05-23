@extends('layouts.app')

@section('title', 'Online Public Market')

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        transition: transform 0.4s ease-in-out;
    }

    .card:hover .card-img-top {
        transform: scale(1.03);
    }

    .btn-success,
    .btn-warning {
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    .btn-warning:hover {
        background-color: #e0a800;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .price-tag {
        font-size: 1.2rem;
        color: #28a745;
    }

    .stock-badge {
        font-size: 0.85rem;
        padding: 0.25rem 0.6rem;
        background-color: #f8f9fa;
        border-radius: 30px;
    }

    .seller-reputation {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .card:hover .card-title {
        color: #0d6efd;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-center text-danger">Welcome to the Online Public Market</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    @if ($product->picture)
                        <img src="{{ asset('storage/app/public/' . $product->picture) }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}" 
                             style="height: 220px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                             class="card-img-top" 
                             alt="No Image Available" 
                             style="height: 220px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="card-title text-truncate mb-0" title="{{ $product->name }}">{{ $product->name }}</h5>
                            <span class="badge bg-light text-dark stock-badge">{{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}</span>
                        </div>

                        <p class="seller-reputation mb-1">
                            Sold by: <strong>{{ $product->seller->name ?? 'Unknown Seller' }}</strong>
                        </p>

                        <p class="price-tag fw-bold mb-3">₱{{ number_format($product->price, 2) }}</p>

                        @auth
                            @if(auth()->user()->role === 'customer')
                                <form method="POST" action="{{ route('order.place', $product->id) }}" class="mb-2 mt-auto" novalidate>
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" required class="form-control" placeholder="Qty" aria-label="Quantity">
                                        <button type="submit" class="btn btn-success">Buy Now</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm w-100">
                                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                    </button>   
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No products available at the moment.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
