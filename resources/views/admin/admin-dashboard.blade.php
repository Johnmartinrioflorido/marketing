@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border-bottom mb-4">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-shop-window fs-4"></i> Marketing
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdminContent">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                         <a id="navbarDropdown"
                         class="nav-link dropdown-toggle d-flex align-items-center text-dark fw-semibold px-3 py-2"
                         href="#"
                         role="button"
                         data-bs-toggle="dropdown"
                         aria-expanded="false"
                         style="border-radius: 0.375rem; transition: background-color 0.3s;">
                        <i class="bi bi-person-circle me-2 fs-5 text-primary"></i>
                        <span class="d-none d-md-inline">Hi, {{ Auth::user()->name }}</span>
                        </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
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
    <h2 class="text-danger fw-bold mb-4"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        @php
            $cards = [
                ['title' => 'Vendors', 'count' => $vendors, 'text' => 'Registered vendors', 'link' => route('admin.vendors'), 'icon' => 'bi-people-fill', 'color' => 'primary'],
                ['title' => 'Customers', 'count' => $customers, 'text' => 'Registered customers', 'link' => '#', 'icon' => 'bi-person-check-fill', 'color' => 'success'],
                ['title' => 'Products', 'count' => $products, 'text' => 'Listed products', 'link' => route('admin.products.manage'), 'icon' => 'bi-box-seam', 'color' => 'warning'],
                ['title' => 'Orders', 'count' => $orders, 'text' => 'Total orders', 'link' => '#', 'icon' => 'bi-basket-fill', 'color' => 'danger'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="card shadow border-0 hover-shadow transition rounded-3">
                <div class="card-body text-center">
                    <div class="text-{{ $card['color'] }} fs-2 mb-2"><i class="bi {{ $card['icon'] }}"></i></div>
                    <h6 class="card-title text-uppercase fw-semibold">{{ $card['title'] }}</h6>
                    <h2 class="fw-bold">{{ $card['count'] }}</h2>
                    <p class="text-muted small">{{ $card['text'] }}</p>
                    <a href="{{ $card['link'] }}" class="btn btn-sm btn-outline-{{ $card['color'] }}">View {{ $card['title'] }}</a>
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
            <div class="bg-white shadow-sm rounded p-3 h-100">
                <h5 class="mb-3 text-danger"><i class="bi bi-clock-history me-2"></i>Recent Orders</h5>
                <ul class="list-group list-group-flush">
                    @forelse($recentOrders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-receipt me-2 text-muted"></i>Order #{{ $order->id }} by {{ $order->user->name }}</span>
                            <span class="badge bg-danger rounded-pill">{{ $order->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No recent orders</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- New Vendors -->
        <div class="col-md-3">
            <div class="bg-white shadow-sm rounded p-3 h-100">
                <h5 class="mb-3 text-danger"><i class="bi bi-person-plus me-2"></i>New Vendors</h5>
                <ul class="list-group list-group-flush">
                    @forelse($vendorList as $vendor)
                        <li class="list-group-item"><i class="bi bi-person-circle me-2 text-muted"></i>{{ $vendor->name }}</li>
                    @empty
                        <li class="list-group-item text-muted">No vendors yet</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- New Products -->
        <div class="col-md-3">
            <div class="bg-white shadow-sm rounded p-3 h-100">
                <h5 class="mb-3 text-danger"><i class="bi bi-plus-square me-2"></i>New Products</h5>
                <ul class="list-group list-group-flush">
                    @forelse($productList as $product)
                        <li class="list-group-item"><i class="bi bi-box me-2 text-muted"></i>{{ $product->name }}</li>
                    @empty
                        <li class="list-group-item text-muted">No products yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
        transition: 0.3s ease-in-out;
    }
    .transition {
        transition: all 0.3s ease-in-out;
    }
    .card-title {
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
</style>

@endsection
