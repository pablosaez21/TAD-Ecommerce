@extends('layouts.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Productos</h2>
    @auth
        @if(auth()->user()->role === 'admin')
            <a class="btn btn-primary" href="{{ route('products.create') }}">Nuevo producto</a>
        @endif
    @endauth
</div>

<div class="row g-3">
    @forelse($products as $product)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ $product->description }}</p>
                    <p class="fw-bold">{{ number_format((float) $product->price, 2) }} EUR</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    @empty
        <p>No hay productos disponibles.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
