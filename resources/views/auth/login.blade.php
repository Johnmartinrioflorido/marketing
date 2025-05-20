@extends('layouts.layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #d32f2f;">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input 
                    type="email" 
                    name="email" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Email" 
                    required 
                    autofocus
                >
            </div>
            <div class="mb-4">
                <input 
                    type="password" 
                    name="password" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Password" 
                    required
                >
            </div>
            <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill fw-semibold">
                Login
            </button>
        </form>
        <p class="text-center mt-4 mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-danger fw-semibold">Register here</a>
        </p>
    </div>
</div>
@endsection
