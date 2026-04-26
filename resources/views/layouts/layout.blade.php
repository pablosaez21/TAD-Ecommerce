<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SportStore') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-magenta: #ff00ff;
            --brand-magenta-dark: #cc00cc;
        }
        .navbar-brand,
        .brand-text {
            color: var(--brand-magenta) !important;
            font-weight: 700;
        }
        .btn-primary,
        .bg-primary,
        .btn-outline-primary:hover {
            background-color: var(--brand-magenta) !important;
            border-color: var(--brand-magenta) !important;
        }
        .btn-primary:hover {
            background-color: var(--brand-magenta-dark) !important;
            border-color: var(--brand-magenta-dark) !important;
        }
        .btn-outline-primary {
            color: var(--brand-magenta);
            border-color: var(--brand-magenta);
        }
        .text-primary {
            color: var(--brand-magenta) !important;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">SportStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Productos</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.addresses') }}">Direcciones</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.orders') }}">Pedidos</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
