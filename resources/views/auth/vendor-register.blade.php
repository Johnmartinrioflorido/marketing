@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #80deea);
    }
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .form-control:focus {
        border-color: #00acc1;
        box-shadow: 0 0 0 0.2rem rgba(0, 172, 193, 0.25);
    }
    .form-label {
        font-weight: 600;
    }
    .btn-custom {
        background-color: #00acc1;
        color: white;
        transition: background-color 0.3s ease;
    }
    .btn-custom:hover {
        background-color: #00838f;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg w-100" style="max-width: 500px;">
        <h2 class="text-center mb-4 fw-bold text-info">Vendor Registration</h2>

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('vendor.register.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input
                    id="name"
                    type="text"
                    class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder=""
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input
                    id="email"
                    type="email"
                    class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder=""
                    required
                >
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror"
                    name="password"
                    placeholder=""
                    required
                >
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-control form-control-lg rounded-pill"
                    name="password_confirmation"
                    placeholder=""
                    required
                >
            </div>

            <button type="submit" class="btn btn-custom btn-lg w-100 rounded-pill fw-semibold">
                Register as Vendor
            </button>
        </form>

        <p class="text-center mt-4 mb-0">
            Already registered? 
            <a href="{{ route('login') }}" class="text-info fw-semibold">Login here</a>
        </p>
    </div>
</div>
@endsection
