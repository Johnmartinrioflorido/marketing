@extends('layouts.layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-5" style="width: 100%; max-width: 420px; border-radius: 20px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e88e5;">Welcome Back</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror" 
                    placeholder="Enter your email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                >
            </div>

            <div class="form-group mb-4">
                <label for="password" class="form-label fw-medium">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror" 
                    placeholder="Enter your password" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-semibold" style="background-color: #1e88e5; border-color: #1e88e5;">
                Log In
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="mb-0">Don't have an account? 
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #1e88e5;">Register here</a>
            </p>
        </div>
    </div>
</div>

{{-- SweetAlert2 Popup --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Welcome!',
            text: 'Please log in to continue.',
            icon: 'info',
            confirmButtonColor: '#1e88e5',
            confirmButtonText: 'Got it!'
        });
    });
</script>
@endsection
