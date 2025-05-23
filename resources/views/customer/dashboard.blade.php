@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Back Button --}}
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    {{-- Welcome Message --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title mb-0">Welcome, {{ auth()->user()->name }}</h2>
            <p class="text-muted">Here's a summary of your orders.</p>
        </div>
    </div>

    {{-- Orders Section --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Your Orders</h5>
        </div>
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    You have no orders yet.
                </div>
            @else
                <div class="
