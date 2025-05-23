@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> 
    </a>
</div>
    <div class="container">
        <h2>Welcome, {{ auth()->user()->name }}</h2>

        <h3>Your Orders</h3>

        @if ($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Delivery Status</th>
                        <th>Delivery Person</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name ?? 'Product deleted' }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ number_format($order->total, 2) }}</td>
                            <td>{{ ucfirst($order->delivery_status ?? 'Not set') }}</td>
                            <td>{{ optional($order->deliveryPerson)->name ?? 'Not assigned' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
