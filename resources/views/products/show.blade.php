@extends('layouts.layout')

@section('content')
<div class="card">
    <div class="card-body">
        <h2>{{ $product->name }}</h2>
        <p class="text-muted">{{ $product->description }}</p>
        <p class="fw-bold">Precio: {{ number_format((float) $product->price, 2) }} EUR</p>
        <p>Stock: {{ $product->stock }}</p>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Volver</a>

            @auth
                <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">Favorito</button>
                </form>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Eliminar</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
