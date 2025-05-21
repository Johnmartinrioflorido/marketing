<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Online Public Market')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: #ff2e63 !important;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #555 !important;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem;
        }

        .nav-link:hover {
            color: #ff2e63 !important;
            background-color: rgba(255, 46, 99, 0.1);
            border-radius: 0.375rem;
        }

        .btn-link.nav-link {
            color: #dc3545 !important;
        }

        .container {
            max-width: 960px;
        }

        .navbar-text {
            margin-left: 1rem;
        }

        /* Cart Button Styling */
        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border: none;
            font-size: 1.1rem;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .badge.bg-danger {
            font-size: 0.75rem;
            padding: 0.35em 0.6em;
        }

        form button.nav-link {
            font-weight: 500;
            transition: all 0.2s ease;
        }

        form button.nav-link:hover {
            color: #a71d2a !important;
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .navbar-text {
                font-size: 1rem !important;
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Marketing
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'customer')
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-text fw-semibold fs-5 text-primary">
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.dashboard') }}">
                                Orders
                            </a>
                        </li>

                        {{-- 🛒 Yellow Cart Icon Button --}}
                        @php
                            $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->count();
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="btn btn-warning position-relative">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="border: none; padding: 0;">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
