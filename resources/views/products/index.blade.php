@extends('layouts.app')

@section('title', 'Productos — Double Helix')

@section('content')

{{-- ─── CABECERA ───────────────────────────────────────────────────── --}}
<section style="padding: 60px 0 40px; background: #fff; border-bottom: 1px solid #F0F0F0;">
    <div class="container">
        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Catálogo</p>
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3">
            <div>
                <h1 style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text); margin-bottom: 0.3rem;">
                    Todos los productos
                </h1>
                <p class="mb-0" style="color: var(--dh-muted); font-size: 0.88rem;">
                    {{ $products->total() }} {{ $products->total() === 1 ? 'resultado' : 'resultados' }}
                </p>
            </div>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="btn btn-dh" style="padding: 10px 28px; font-size: 0.88rem;">
                        <i class="bi bi-plus-lg me-1"></i>Nuevo producto
                    </a>
                @endif
            @endauth
        </div>

        {{-- Filtros visuales (no funcionales) --}}
        <div class="d-flex gap-2 mt-4 flex-wrap">
            <span class="badge py-2 px-3"
                  style="background: var(--dh-primary); border-radius: 2px; font-weight: 400; font-size: 0.78rem; letter-spacing: 0.5px;">
                Todos
            </span>
            @foreach (['Running', 'Training', 'Lifestyle', 'Accesorios'] as $label)
                <button type="button" class="btn btn-sm"
                        style="border: 1px solid #E5E7EB; border-radius: 2px; color: var(--dh-muted); font-size: 0.78rem; background: #fff;">
                    {{ $label }}
                </button> {{-- TODO: filtro por categoría --}}
            @endforeach
        </div>
    </div>
</section>

{{-- ─── GRID DE PRODUCTOS ──────────────────────────────────────────── --}}
<section style="padding: 60px 0 100px; background: #F7F7F7;">
    <div class="container">
        @forelse ($products as $product)
            @if ($loop->first)
                <div class="row g-4">
            @endif
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="text-center" style="padding: 80px 0;">
                <i class="bi bi-bag-x d-block mb-4" style="font-size: 3.5rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; color: var(--dh-text); margin-bottom: 0.5rem;">No hay productos disponibles</h4>
                <p style="color: var(--dh-muted); font-size: 0.9rem;">Vuelve pronto, estamos preparando nuevas colecciones.</p>
                <a href="{{ route('home') }}" class="btn btn-dh-outline mt-3" style="padding: 10px 32px;">
                    Volver al inicio
                </a>
            </div>
        @endforelse

        @if ($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
