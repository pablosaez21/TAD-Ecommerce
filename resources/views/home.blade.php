@extends('layouts.app')

@section('title', 'Double Helix — Deporte en nuestro ADN')

@section('content')

{{-- ─── HERO ──────────────────────────────────────────────────────── --}}
<section style="background: #151515; min-height: 90vh; display: flex; align-items: center;">
    <div class="container" style="padding-top: 80px; padding-bottom: 80px;">
        <div class="row align-items-center">
            <div class="col-lg-7">

                <span class="dh-label dh-label--muted mb-4">Nueva Colección SS26</span>

                <h1 class="dh-display text-white mb-5" style="font-size: clamp(4rem, 10vw, 7rem);">
                    Muévete<br>con estilo.
                </h1>

                <div class="d-flex align-items-start gap-3 mb-5">
                    <div class="dh-hero-line"></div>
                    <p style="color: #9CA3AF; font-size: 1rem; max-width: 400px; line-height: 1.8; margin-bottom: 0;">
                        Ropa deportiva diseñada para rendir al máximo. Sin compromisos entre comodidad y diseño.
                    </p>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-dh"
                       style="padding: 14px 40px; font-size: 0.88rem; letter-spacing: 1px;">
                        Comprar ahora
                    </a>
                    <a href="{{ route('products.index') }}" class="btn"
                       style="padding: 14px 40px; font-size: 0.88rem; letter-spacing: 1px; border: 1.5px solid rgba(255,255,255,0.35); color: #fff; border-radius: 2px; background: transparent; transition: all 200ms ease;">
                        Ver colección
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ─── PRODUCTOS DESTACADOS ──────────────────────────────────────── --}}
<section style="padding: 100px 0; background: #fff;">
    <div class="container">

        <span class="dh-label">Destacados</span>
        <h2 class="dh-section-title mb-5">Los más vendidos</h2>

        <div class="row g-4">
            @isset($featuredProducts)
                @forelse ($featuredProducts as $product)
                    <div class="col-6 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <p style="color: var(--dh-muted); font-size: 0.9rem;">No hay productos destacados en este momento.</p>
                    </div>
                @endforelse
            @else
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-6 col-lg-3">
                        <div class="dh-product-card">
                            <div class="dh-product-img d-flex align-items-center justify-content-center">
                                <i class="bi bi-image" style="font-size: 3rem; color: #D1D5DB;"></i>
                            </div>
                            <div style="padding: 14px 0 8px;">
                                <p class="dh-product-name mb-1">Producto destacado</p>
                                <p class="dh-product-price mb-0">— €</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endisset
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-dh-outline" style="padding: 12px 40px;">
                Ver todos los productos
            </a>
        </div>
    </div>
</section>

@endsection
