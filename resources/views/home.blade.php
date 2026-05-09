@extends('layouts.app')

@section('title', 'Double Helix — ' . __('home.hero_title'))

@section('content')

<section style="background: #151515; min-height: 90vh; display: flex; align-items: center;">
    <div class="container" style="padding-top: 80px; padding-bottom: 80px;">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">

                <span class="dh-label dh-label--muted mb-4">{{ __('home.collection_tag') }}</span>

                <h1 class="dh-display text-white mb-5" style="font-size: clamp(4rem, 10vw, 7rem);">
                    {{ __('home.hero_title') }}
                </h1>

                <div class="d-flex align-items-start gap-3 mb-5">
                    <div class="dh-hero-line"></div>
                    <p style="color: #9CA3AF; font-size: 1rem; max-width: 400px; line-height: 1.8; margin-bottom: 0;">
                        {{ __('home.hero_subtitle') }}
                    </p>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-dh"
                       style="padding: 14px 40px; font-size: 0.88rem; letter-spacing: 1px;">
                        {{ __('home.hero_cta_shop') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="btn"
                       style="padding: 14px 40px; font-size: 0.88rem; letter-spacing: 1px; border: 1.5px solid rgba(255,255,255,0.35); color: #fff; border-radius: 2px; background: transparent; transition: all 200ms ease;">
                        {{ __('home.hero_cta_catalog') }}
                    </a>
                </div>

            </div>

            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/logo_double_helix.png') }}"
                     alt="Double Helix"
                     style="width: min(560px, 90%); height: auto; object-fit: contain; opacity: 0.92;">
            </div>
        </div>
    </div>
</section>

<section style="padding: 100px 0; background: #fff;">
    <div class="container">

        <span class="dh-label">{{ __('home.featured_label') }}</span>
        <h2 class="dh-section-title mb-5">{{ __('home.featured_title') }}</h2>

        <div class="row g-4">
            @isset($featuredProducts)
                @forelse ($featuredProducts as $product)
                    <div class="col-6 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <p style="color: var(--dh-muted); font-size: 0.9rem;">{{ __('home.featured_empty') }}</p>
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
                                <p class="dh-product-name mb-1">{{ __('home.featured_title') }}</p>
                                <p class="dh-product-price mb-0">— €</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endisset
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-dh-outline" style="padding: 12px 40px;">
                {{ __('home.see_all_btn') }}
            </a>
        </div>
    </div>
</section>

@endsection
