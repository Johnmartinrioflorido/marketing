@extends('layouts.layout')

@section('title', 'Customer Registration')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #00b4db, #0083b0);
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 20px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
    }
    .form-control, .form-select {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
    h2 {
        font-size: 1.4rem;
    }
    .btn {
        font-size: 0.9rem;
    }
    p, a {
        font-size: 0.85rem;
    }
</style>

<div class="container d-flex justify-content-center align-items-center px-2" style="min-height: 100vh;">
    <div class="card shadow-lg bg-white w-100" style="max-width: 500px; padding: 2rem;">
        <h2 class="text-center mb-4 fw-bold" style="color: #0083b0;">Customer Registration</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="mb-2">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control rounded-pill" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control rounded-pill" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-2">
                <label for="address" class="form-label">Home Address</label>
                <input type="text" class="form-control rounded-pill" id="address" name="address" value="{{ old('address') }}" required>
            </div>

            <div class="mb-2">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control rounded-pill" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control rounded-pill" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control rounded-pill" id="password_confirmation" name="password_confirmation" required>
            </div>

            @if(auth()->check() && auth()->user()->role == 'admin')
                <div class="mb-3">
                    <label for="role" class="form-label">User Role</label>
                    <select name="role" id="role" class="form-select rounded-pill" required>
                        <option value="admin">Admin</option>
                        <option value="vendor">Vendor</option>
                        <option value="customer" selected>Customer</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-lg w-100 rounded-pill fw-semibold text-white" style="background-color: #00b4db;">
                Register
            </button>
        </form>

        <p class="text-center mt-3 mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="fw-semibold" style="color: #00b4db;">Login here</a>
        </p>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            title: 'Register Today!',
            text: 'Fill out your details to get started.',
            icon: 'info',
            confirmButtonColor: '#00b4db',
            confirmButtonText: 'Continue'
        });
    });
</script>
@endsection
