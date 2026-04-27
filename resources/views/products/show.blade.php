@extends('layouts.app')

@section('title', $product->name . ' — Double Helix')

@section('content')

{{-- ─── PRODUCTO PRINCIPAL ────────────────────────────────────────── --}}
<section style="padding: 80px 0; background: #fff;">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav class="mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-size: 0.8rem; color: var(--dh-muted);">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: var(--dh-muted); text-decoration: none;">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}" style="color: var(--dh-muted); text-decoration: none;">Productos</a>
                </li>
                <li class="breadcrumb-item active" style="color: var(--dh-text);">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">

            {{-- Imagen --}}
            <div class="col-lg-6">
                <div style="aspect-ratio: 1/1; background: #F7F7F7; overflow: hidden;">
                    @if ($product->image ?? false)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 5rem; color: #D1D5DB;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="col-lg-6" style="padding-top: 12px;">

                {{-- Categorías --}}
                @if ($product->categories->isNotEmpty())
                    <div class="mb-3">
                        @foreach ($product->categories as $category)
                            <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--dh-primary); font-weight: 600;">
                                {{ $category->name }}@if (!$loop->last), @endif
                            </span>
                        @endforeach
                    </div>
                @endif

                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); line-height: 1.2; margin-bottom: 1rem;">
                    {{ $product->name }}
                </h1>

                <p style="font-size: 1.75rem; font-weight: 700; color: var(--dh-primary); margin-bottom: 1.5rem;">
                    {{ number_format((float) $product->price, 2) }} €
                </p>

                @if ($product->description ?? false)
                    <p style="color: var(--dh-muted); font-size: 0.95rem; line-height: 1.8; margin-bottom: 1.5rem;">
                        {{ $product->description }}
                    </p>
                @endif

                {{-- Stock --}}
                <div class="mb-4">
                    @if (($product->stock ?? 0) > 0)
                        <span style="font-size: 0.82rem; color: #16a34a; font-weight: 600;">
                            <i class="bi bi-check-circle me-1"></i>En stock ({{ $product->stock }} disponibles)
                        </span>
                    @else
                        <span style="font-size: 0.82rem; color: var(--dh-muted); font-weight: 600;">
                            <i class="bi bi-x-circle me-1"></i>Agotado
                        </span>
                    @endif
                </div>

                {{-- Selector cantidad --}}
                @if (($product->stock ?? 0) > 0)
                    <div class="mb-4">
                        <label style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); margin-bottom: 8px; display: block;">
                            Cantidad
                        </label>
                        <div class="d-flex align-items-center gap-0" style="width: fit-content; border: 1px solid #E5E7EB; border-radius: 2px;">
                            <button type="button" onclick="changeQty(-1)"
                                    style="width: 40px; height: 40px; border: none; background: transparent; font-size: 1.1rem; color: var(--dh-text);">
                                −
                            </button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   style="width: 52px; height: 40px; border: none; border-left: 1px solid #E5E7EB; border-right: 1px solid #E5E7EB; text-align: center; font-size: 0.9rem; color: var(--dh-text); background: transparent;"
                                   readonly>
                            <button type="button" onclick="changeQty(1)"
                                    style="width: 40px; height: 40px; border: none; background: transparent; font-size: 1.1rem; color: var(--dh-text);">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex flex-column gap-2" style="max-width: 380px;">
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <input type="hidden" name="quantity" id="qty-hidden" value="1">
                            <button type="submit" class="btn btn-dh w-100" style="padding: 14px 32px; font-size: 0.9rem;">
                                <i class="bi bi-bag-plus me-2"></i>Añadir al carrito
                            </button>
                        </form>

                        @auth
                            <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dh-outline w-100" style="padding: 13px 32px; font-size: 0.9rem;">
                                    <i class="bi bi-heart me-2"></i>Añadir a favoritos
                                </button>
                            </form>
                        @endauth
                    </div>
                @else
                    <button class="btn w-100" disabled
                            style="padding: 14px 32px; background: #E5E7EB; color: var(--dh-muted); border-radius: 2px; border: none; max-width: 380px;">
                        Producto agotado
                    </button>
                @endif

                {{-- Botón admin --}}
                @auth
                    @if (auth()->user()->role === 'admin')
                        <div class="d-flex gap-2 mt-4 pt-4" style="border-top: 1px solid #F0F0F0;">
                            <a href="{{ route('products.edit', $product) }}"
                               class="btn btn-sm btn-dh-outline" style="padding: 8px 20px; font-size: 0.8rem;">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                        style="padding: 8px 20px; font-size: 0.8rem; border: 1px solid #fee2e2; color: #dc2626; border-radius: 2px; background: transparent;"
                                        onclick="return confirm('¿Eliminar este producto?')">
                                    <i class="bi bi-trash me-1"></i>Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</section>

{{-- ─── TAMBIÉN TE PUEDE GUSTAR ───────────────────────────────────── --}}
@isset($relatedProducts)
    @if ($relatedProducts->isNotEmpty())
        <section style="padding: 80px 0; background: #F7F7F7;">
            <div class="container">
                <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Recomendados</p>
                <h2 class="mb-5" style="font-weight: 300; font-size: 2rem; color: var(--dh-text);">También te puede gustar</h2>
                <div class="row g-4">
                    @foreach ($relatedProducts->take(4) as $related)
                        <div class="col-6 col-lg-3">
                            @include('partials.product-card', ['product' => $related])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endisset

@endsection

@push('scripts')
<script>
    function changeQty(delta) {
        const input = document.getElementById('qty');
        const hidden = document.getElementById('qty-hidden');
        if (!input) return;
        let val = parseInt(input.value) + delta;
        const max = parseInt(input.getAttribute('max') || 99);
        val = Math.max(1, Math.min(val, max));
        input.value = val;
        if (hidden) hidden.value = val;
    }
</script>
@endpush
