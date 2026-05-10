@extends('layouts.app')

@section('title', 'Verifica tu email')

@section('content')

<section style="min-height: 80vh; display:flex; align-items:center; justify-content:center; background:#F7F7F7;">
    <div style="width: 100%; max-width: 520px; background:#fff; padding:40px; text-align:center;">

        <h2 class="mb-3">Verifica tu correo electrónico</h2>

        <p class="mb-4" style="font-size:0.95rem; color:#555;">
            Antes de continuar, revisa tu correo electrónico y haz clic en el enlace de verificación que te hemos enviado.
            Si no lo has recibido, podemos enviarte otro.
        </p>

        {{-- Mensaje de estado --}}
        @if (session('status') == 'verification-link-sent')
            <div style="background:#dcfce7; padding:10px; margin-bottom:15px;">
                <p style="margin:0; font-size:0.9rem;">
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </p>
            </div>
        @endif

        {{-- Formulario para reenviar email --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="btn btn-dark w-100">
                Reenviar correo de verificación
            </button>
        </form>

        <div class="mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none">
                    Cerrar sesión
                </button>
            </form>
        </div>

    </div>
</section>

@endsection