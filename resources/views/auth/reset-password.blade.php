@extends('layouts.app')

@section('title', 'Restablecer contraseña')

@section('content')

<section style="min-height: 80vh; display:flex; align-items:center; justify-content:center; background:#F7F7F7;">
    <div style="width: 100%; max-width: 420px; background:#fff; padding:40px;">

        <h2 class="mb-4">Restablecer contraseña</h2>

        <p style="font-size:0.9rem; color:#666; margin-bottom:20px;">
            Introduce tu nueva contraseña para completar el cambio.
        </p>

        {{-- Errores --}}
        @if ($errors->any())
            <div style="background:#fee2e2; padding:10px; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <p style="margin:0; font-size:0.85rem;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            {{-- Email --}}
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', request()->email) }}"
                       required autofocus>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label>Nueva contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- Confirmación --}}
            <div class="mb-3">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Restablecer contraseña
            </button>
        </form>

        <p class="mt-3 text-center" style="font-size:0.85rem;">
            <a href="{{ route('login') }}">Volver al login</a>
        </p>

    </div>
</section>

@endsection