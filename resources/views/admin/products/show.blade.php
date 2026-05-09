@extends('layouts.app')

@section('title', $product->name . ' — Admin')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7;">
    <div class="container">

        <div class="mb-5">
            <a href="{{ route('products.index') }}" style="font-size: 0.82rem; color: var(--dh-muted); text-decoration: none;">
                ← Volver a productos
            </a>
            <p class="mt-3 mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración / Productos</p>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">{{ $product->name }}</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-dh" style="padding: 10px 24px; font-size: 0.88rem;">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                style="padding: 10px 24px; font-size: 0.88rem; border: 1px solid #fee2e2; color: #dc2626; border-radius: 2px; background: transparent; cursor: pointer;"
                                onclick="return confirm('¿Eliminar este producto?')">
                            <i class="bi bi-trash me-1"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-start">

            {{-- Imagen --}}
            <div class="col-lg-4">
                <div style="aspect-ratio: 1/1; background: #fff; overflow: hidden;">
                    @if ($product->image ?? false)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 4rem; color: #D1D5DB;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Detalles --}}
            <div class="col-lg-8">
                <div style="background: #fff; padding: 36px; margin-bottom: 20px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">Detalles</h5>
                    <div class="row g-3" style="font-size: 0.88rem;">
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Precio</span>
                            <span style="font-weight: 700; color: var(--dh-primary); font-size: 1.1rem;">{{ number_format((float) $product->price, 2) }} €</span>
                        </div>
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Stock</span>
                            <span style="color: var(--dh-text); font-weight: 600;">{{ $product->stock }} ud.</span>
                        </div>
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Estado</span>
                            @if ($product->active)
                                <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.75rem; font-weight: 600; background: #D1FAE5; color: #065F46;">Activo</span>
                            @else
                                <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.75rem; font-weight: 600; background: #F3F4F6; color: #374151;">Inactivo</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Categorías</span>
                            @if ($product->categories->isNotEmpty())
                                @foreach ($product->categories as $cat)
                                    <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.75rem; background: var(--dh-primary-light, #FBE9F2); color: var(--dh-primary); margin-right: 4px; font-weight: 500;">{{ $cat->name }}</span>
                                @endforeach
                            @else
                                <span style="color: var(--dh-muted);">Sin categoría</span>
                            @endif
                        </div>
                        @if ($product->description ?? false)
                            <div class="col-12">
                                <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Descripción</span>
                                <p style="color: var(--dh-text); line-height: 1.7; margin-bottom: 0;">{{ $product->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Estadísticas básicas --}}
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">Ventas</h5>
                    <div class="row g-3" style="font-size: 0.88rem;">
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Líneas de pedido</span>
                            <span style="font-size: 1.5rem; font-weight: 700; color: var(--dh-text);">{{ $product->orderLines->count() }}</span>
                        </div>
                        <div class="col-md-6">
                            <span style="color: var(--dh-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Creado</span>
                            <span style="color: var(--dh-text);">{{ $product->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
