@extends('layouts.layout')

@section('title', 'Customer Registration')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px; border-radius: 15px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #d32f2f;">Customer Registration</h2>

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
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Your Name"
                    required
                    autofocus
                >
            </div>

            <div class="mb-3">
                <input
                    type="email"
                    class="form-control form-control-lg rounded-pill"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Your Email"
                    required
                >
            </div>

            <div class="mb-3">
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="address"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder="Your Address"
                    required
                >
            </div>

            <div class="mb-3">
                <input
                    type="text"
                    class="form-control form-control-lg rounded-pill"
                    id="contact_number"
                    name="contact_number"
                    value="{{ old('contact_number') }}"
                    placeholder="Your Contact Number"
                    required
                >
            </div>

            <div class="mb-3">
                <input
                    type="password"
                    class="form-control form-control-lg rounded-pill"
                    id="password"
                    name="password"
                    placeholder="Your Password"
                    required
                >
            </div>

            <div class="mb-4">
                <input
                    type="password"
                    class="form-control form-control-lg rounded-pill"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required
                >
            </div>

            {{-- Role only for Admins --}}
            @if(auth()->check() && auth()->user()->role == 'admin')
                <div class="mb-4">
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
