@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section style="min-height: 80vh; display:flex; align-items:center; justify-content:center; background:#F7F7F7;">
    <div style="width: 100%; max-width: 420px; background:#fff; padding:40px;">

        <h2 class="mb-4">Iniciar sesión</h2>

        {{-- Errores --}}
        @if ($errors->any())
            <div style="background:#fee2e2; padding:10px; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <p style="margin:0; font-size:0.85rem;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input">
                <label class="form-check-label">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Entrar
            </button>
        </form>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        @endif

        <p class="mt-3 text-center" style="font-size:0.85rem;">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Regístrate</a>
        </p>

    </div>
</section>

@endsection