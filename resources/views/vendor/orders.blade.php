@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Welcome Message --}}
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-muted">Here is a summary of all your orders.</p>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Delivery Status</th>
                                <th>Delivery Person</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->product->name ?? 'Product deleted' }}</td>
                                    <td>₱{{ number_format($order->total, 2) }}</td>
                                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $order->customer->address ?? 'N/A' }}</td>
                                    <td>{{ $order->customer->contact_number ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($order->delivery_status ?? 'Not set') }}
                                        </span>
                                    </td>
                                    <td>{{ optional($order->deliveryPerson)->name ?? 'Not assigned' }}</td>
                                    <td>
                                        <!-- Edit Form -->
                                        <form action="{{ route('vendor.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-2">
                                                <select name="delivery_status" class="form-select form-select-sm" required>
                                                    <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="out_for_delivery" {{ $order->delivery_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <select name="delivery_person_id" class="form-select form-select-sm">
                                                    <option value="">-- Assign Delivery Person --</option>
                                                    @foreach ($deliveryPeople as $person)
                                                        <option value="{{ $person->id }}" {{ $order->delivery_person_id == $person->id ? 'selected' : '' }}>
                                                            {{ $person->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-sm btn-primary w-100">Update</button>
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
@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Welcome Message --}}
    <div class="mb-4">
        <h2 class="fw-bold text-primary">Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-muted">Here is a summary of all your orders.</p>
    </div>

    {{-- Orders Section --}}
    <div class="card shadow border-0">
        <div class="card-header bg-gradient bg-primary text-white">
            <h5 class="mb-0">Your Orders</h5>
        </div>
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    You have no orders yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Delivery Status</th>
                                <th>Delivery Person</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $order->id }}</span></td>
                                    <td>{{ $order->product->name ?? 'Product deleted' }}</td>
                                    <td><strong class="text-success">₱{{ number_format($order->total, 2) }}</strong></td>
                                    
                                    {{-- Customer Info --}}
                                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td><span class="text-info">{{ $order->customer->address ?? 'N/A' }}</span></td>
                                    <td>{{ $order->customer->contact_number ?? 'N/A' }}</td>

                                    {{-- Delivery Status --}}
                                    <td>
                                        @php
                                            $statusColor = match($order->delivery_status) {
                                                'pending' => 'warning',
                                                'out_for_delivery' => 'info',
                                                'delivered' => 'success',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}">
                                            {{ ucfirst($order->delivery_status ?? 'Not set') }}
                                        </span>
                                    </td>

                                    {{-- Delivery Person --}}
                                    <td><span class="text-primary">{{ optional($order->deliveryPerson)->name ?? 'Not assigned' }}</span></td>

                                    {{-- Actions --}}
                                    <td>
                                        <form action="{{ route('vendor.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-2">
                                                <select name="delivery_status" class="form-select form-select-sm" required>
                                                    <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="out_for_delivery" {{ $order->delivery_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <select name="delivery_person_id" class="form-select form-select-sm">
                                                    <option value="">-- Assign Delivery Person --</option>
                                                    @foreach ($deliveryPeople as $person)
                                                        <option value="{{ $person->id }}" {{ $order->delivery_person_id == $person->id ? 'selected' : '' }}>
                                                            {{ $person->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="bi bi-check2-circle me-1"></i> Update
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
