@extends('layouts.app')

@section('title', 'Favoritos — Double Helix')

@section('content')

<section style="padding: 60px 0 40px; background: #fff; border-bottom: 1px solid #F0F0F0;">
    <div class="container">

        <p class="mb-2"
           style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">
            Favoritos
        </p>

        <h1 style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text); margin-bottom: 0.5rem;">
            Tus productos favoritos
        </h1>

        <p style="color: var(--dh-muted); font-size: 0.9rem;">
            {{ $products->total() }}
            {{ $products->total() === 1 ? 'producto guardado' : 'productos guardados' }}
        </p>

    </div>
</section>

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

            <div class="text-center" style="padding: 100px 0;">

                <i class="bi bi-heart"
                   style="font-size: 4rem; color: #D1D5DB;"></i>

                <h3 class="mt-4"
                    style="font-weight: 300; color: var(--dh-text);">
                    No tienes favoritos
                </h3>

                <p style="color: var(--dh-muted); font-size: 0.9rem;">
                    Guarda productos para encontrarlos rápidamente más tarde.
                </p>

                <a href="{{ route('products.index') }}"
                   class="btn btn-dh mt-3"
                   style="padding: 12px 30px;">
                    Explorar productos
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