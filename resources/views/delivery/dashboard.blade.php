@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Welcome, {{ auth()->user()->name }}</h2>
            <p class="text-muted fs-5">Here’s your delivery dashboard with real-time order updates.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">📦 Assigned Orders</h5>
            </div>

            <div class="card-body p-4">
                @if ($orders->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-inbox-fill me-2"></i> No assigned deliveries at the moment.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Delivery Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->product->name ?? 'Product deleted' }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $order->customer->address ?? 'N/A' }}</td>
                                        <td>{{ $order->customer->contact_number ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $order->delivery_status == 'delivered' ? 'success' :
                                                ($order->delivery_status == 'out_for_delivery' ? 'warning' : 'secondary') 
                                            }}">
                                                {{ ucfirst($order->delivery_status ?? 'Not set') }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('delivery.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
                                                @csrf
                                                @method('PUT')
                                                <select name="delivery_status" class="form-select form-select-sm" required>
                                                    <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="out_for_delivery" {{ $order->delivery_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
