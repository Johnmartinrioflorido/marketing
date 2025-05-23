@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Back to Admin Dashboard --}}
    <a href="{{ route('admin.d  ashboard') }}" class="btn btn-outline-secondary mb-4">
        ← 
        <i class="fas fa-arrow-left"></i> 
    </a>

    <h1 class="mb-4 text-center text-dark font-weight-bold">Manage Products</h1>

    {{-- Create Product Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
        <i class="fas fa-plus"></i> Create Product
    </button>

    {{-- Product Table --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark text-white">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                   @foreach ($orders as $order)
                    <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>₱{{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                    <td>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i> View
            </a>
        </td>
    </tr>
@endforeach

                    </tr>

                    {{-- Edit Product Modal --}}
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control mb-2" value="{{ $product->name }}" placeholder="Product Name" required>
                                        <textarea name="description" class="form-control mb-2" placeholder="Description">{{ $product->description }}</textarea>
                                        <input type="number" name="price" class="form-control mb-2" value="{{ $product->price }}" placeholder="Price" required>
                                        <input type="number" name="stock" class="form-control mb-2" value="{{ $product->stock }}" placeholder="Stock" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Create Product Modal --}}
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                    <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
                    <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" required>
                    <select name="vendor_id" class="form-control mb-2" required>
                        <option value="" disabled selected>Select Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
