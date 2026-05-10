@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')

<section style="min-height: 80vh; display:flex; align-items:center; justify-content:center; background:#F7F7F7;">
    <div style="width: 100%; max-width: 420px; background:#fff; padding:40px;">

    <h2 class="mb-4">Recuperar contraseña</h2>

    <p style="font-size:0.9rem; color:#666; margin-bottom:20px;">
        Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </p>

    {{-- Status --}}
    @if (session('status'))
        <div style="background:#dcfce7; padding:10px; margin-bottom:15px; font-size:0.85rem;">
            {{ session('status') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div style="background:#fee2e2; padding:10px; margin-bottom:15px;">
            @foreach ($errors->all() as $error)
                <p style="margin:0; font-size:0.85rem;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-dark w-100">
            Enviar enlace de recuperación
        </button>
    </form>

    <p class="mt-3 text-center" style="font-size:0.85rem;">
        <a href="{{ route('login') }}">Volver al login</a>
    </p>

</div>

</section>

@endsection
