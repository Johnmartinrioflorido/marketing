@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(90deg, #ff2e63 0%, #ffbd69 100%);
        color: white;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        text-align: center;
    }

    .dashboard-header h1 {
        margin-bottom: 0.5rem;
        font-weight: 700;
        font-size: 2.5rem;
    }

    .dashboard-header span {
        font-weight: 600;
        color: #ffe4e1;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-weight: 600;
    }

    .btn {
        font-weight: 500;
    }

    .btn-info, .btn-success, .btn-warning {
        color: white !important;
    }

    .btn-info:hover {
        background-color: #17a2b8;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }
</style>

<div class="container">
    <div class="dashboard-header">
        <h1>Welcome, <span>{{ Auth::user()->name }}</span></h1>
        <p class="lead">Here’s a quick overview of your vendor activity.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white fs-5">
                    Your Products
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productCount }} Product(s)</h5>
                    <a href="{{ route('vendor.products') }}" class="btn btn-info w-100 mt-2">
                        Manage Products
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fs-5">
                    Orders
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $orderCount }} Order(s)</h5>
                    <a href="{{ route('vendor.orders') }}" class="btn btn-success w-100 mt-2">
                        View Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fs-5">
                    Total Sales
                </div>
                <div class="card-body">
                    <h5 class="card-title">₱{{ number_format($totalSales, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
