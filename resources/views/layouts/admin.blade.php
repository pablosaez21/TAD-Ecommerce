<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div style="width:250px; min-height:100vh; background:#111; color:white; padding:20px;">
        <h4>ADMIN</h4>

        <a href="{{ route('admin.dashboard') }}" class="d-block text-white">Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="d-block text-white">Productos</a>
    </div>

    {{-- CONTENT --}}
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>

</div>

</body>
</html>