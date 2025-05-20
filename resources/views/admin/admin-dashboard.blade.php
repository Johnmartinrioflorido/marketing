@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border-bottom mb-4">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-shop-window fs-4"></i> Online Public Market
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdminContent">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> Hi, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container py-4">
    <h2 class="text-danger mb-4">Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        @php
            $cards = [
                ['title' => 'Vendors', 'count' => $vendors, 'text' => 'Registered vendors', 'link' => route('admin.vendors'), 'icon' => 'bi-people-fill'],
                ['title' => 'Customers', 'count' => $customers, 'text' => 'Registered customers', 'link' => '#', 'icon' => 'bi-person-check-fill'],
                ['title' => 'Products', 'count' => $products, 'text' => 'Listed products', 'link' => route('admin.products.manage'), 'icon' => 'bi-box-seam'],
                ['title' => 'Orders', 'count' => $orders, 'text' => 'Total orders', 'link' => '#', 'icon' => 'bi-basket-fill'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="card shadow-sm border-0 hover-shadow transition rounded">
                <div class="card-body text-center">
                    <div class="text-primary mb-2 fs-3"><i class="bi {{ $card['icon'] }}"></i></div>
                    <h5 class="card-title">{{ $card['title'] }}</h5>
                    <h2 class="fw-bold">{{ $card['count'] }}</h2>
                    <p class="text-muted">{{ $card['text'] }}</p>
                    <a href="{{ $card['link'] }}" class="btn btn-outline-primary btn-sm">View {{ $card['title'] }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <hr class="mb-5">

    <!-- Additional Sections -->
    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-md-6">
            <h4 class="mb-3"><i class="bi bi-clock-history me-2 text-danger"></i>Recent Orders</h4>
            <ul class="list-group shadow-sm">
                @forelse($recentOrders as $order)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Order #{{ $order->id }} by {{ $order->user->name }}</span>
                        <span class="badge bg-danger">{{ $order->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No recent orders</li>
                @endforelse
            </ul>
        </div>

        <!-- New Vendors -->
        <div class="col-md-3">
            <h4 class="mb-3"><i class="bi bi-person-plus me-2 text-danger"></i>New Vendors</h4>
            <ul class="list-group shadow-sm">
                @forelse($vendorList as $vendor)
                    <li class="list-group-item">{{ $vendor->name }}</li>
                @empty
                    <li class="list-group-item text-muted">No vendors yet</li>
                @endforelse
            </ul>
        </div>

        <!-- New Products -->
        <div class="col-md-3">
            <h4 class="mb-3"><i class="bi bi-plus-square me-2 text-danger"></i>New Products</h4>
            <ul class="list-group shadow-sm">
                @forelse($productList as $product)
                    <li class="list-group-item">{{ $product->name }}</li>
                @empty
                    <li class="list-group-item text-muted">No products yet</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
        transition: 0.3s ease-in-out;
    }
    .transition {
        transition: all 0.3s ease-in-out;
    }
</style>

@endsection

