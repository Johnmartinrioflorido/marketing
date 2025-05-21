@extends('layouts.layout')

@section('title', 'Customer Registration')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #fceabb, #f8b500);
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .form-control:focus {
        border-color: #ff9800;
        box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
    }
    .form-label {
        font-weight: 600;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 bg-white" style="width: 100%; max-width: 500px; border-radius: 15px;">
        <h2 class="text-center mb-4 fw-bold text-danger">Customer Registration</h2>

        {{-- Show validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success flash message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder=""
                    required
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input
                    type="email"
                    class="form-control form-control-lg rounded-pill"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder=""
                    required
                >
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Home Address</label>
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="address"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder=""
                    required
                >
            </div>

            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number') }}"
                    placeholder=""
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control form-control-lg rounded-pill"
                    id="password"
                    name="password"
                    placeholder=""
                    required
                >
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    class="form-control form-control-lg rounded-pill"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder=""
                    required
                >
            </div>

            {{-- Role dropdown only visible to admins --}}
            @if(auth()->check() && auth()->user()->role == 'admin')
                <div class="mb-4">
                    <label for="role" class="form-label">User Role</label>
                    <select name="role" id="role" class="form-select form-select-lg rounded-pill" required>
                        <option value="admin">Admin</option>
                        <option value="vendor">Vendor</option>
                        <option value="customer" selected>Customer</option>
                        <option value="delivery">Delivery</option> 
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill fw-semibold">
                Register
            </button>
        </form>

        <p class="text-center mt-4 mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-danger fw-semibold">Login here</a>
        </p>
    </div>
</div>
@endsection
