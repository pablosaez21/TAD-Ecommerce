<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - SportStore</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #F7F7F7;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

    <main style="min-height:100vh; display:flex; align-items:center; justify-content:center;">
        @yield('content')
    </main>

</body>
</html>