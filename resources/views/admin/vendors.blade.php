@extends('layouts.app')

@section('title', 'Vendor List')

@section('content')

<div class="container mt-4">

    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-4">
        ← 
        <i class="fas fa-arrow-left"></i> 
    </a>

    <h2 class="mb-4" style="color: #dc3545; font-weight: 700;">Registered Vendors</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-danger text-white">
                <tr>
                    <th scope="col" style="width: 5%;">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Registered At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No vendors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $vendors->links() }}
    </div>
</div>

@endsection
