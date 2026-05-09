@extends('layouts.app')

@section('title', $category->name . ' — Double Helix')

@section('content')

<section style="padding: 60px 0 40px; background: #fff; border-bottom: 1px solid #F0F0F0;">
    <div class="container">

        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">
            {{ __('products.catalog_label') }}
        </p>
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3">
            <div>
                <h1 style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text); margin-bottom: 0.3rem;">
                    {{ $category->name }}
                </h1>
                @if ($category->description)
                    <p class="mb-1" style="color: var(--dh-muted); font-size: 0.88rem;">{{ $category->description }}</p>
                @endif
                <p class="mb-0" style="color: var(--dh-muted); font-size: 0.88rem;">
                    {{ $products->total() }} {{ $products->total() === 1 ? __('categories.result_singular') : __('categories.result_plural') }}
                </p>
            </div>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="btn btn-dh" style="padding: 10px 28px; font-size: 0.88rem;">
                        <i class="bi bi-plus-lg me-1"></i>{{ __('products.new_product') }}
                    </a>
                @endif
            @endauth
        </div>

        {{-- Barra de filtros idéntica a products/index --}}
        <div class="d-flex gap-2 mt-4 flex-wrap">
            <a href="{{ route('products.index') }}"
               class="badge py-2 px-3 text-decoration-none"
               style="background: transparent; border: 1px solid #E5E7EB; border-radius: 2px; font-weight: 400; font-size: 0.78rem; letter-spacing: 0.5px; color: var(--dh-muted);">
                {{ __('products.filter_all') }}
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}"
                   class="py-2 px-3 text-decoration-none"
                   style="border-radius: 2px; font-weight: 400; font-size: 0.78rem; letter-spacing: 0.5px;
                          {{ $cat->id === $category->id
                              ? 'background: var(--dh-primary); color: #fff;'
                              : 'border: 1px solid #E5E7EB; color: var(--dh-muted); background: #fff;' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

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
            <div class="text-center" style="padding: 80px 0;">
                <i class="bi bi-bag-x d-block mb-4" style="font-size: 3.5rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; color: var(--dh-text); margin-bottom: 0.5rem;">
                    {{ __('categories.no_products') }}
                </h4>
                <a href="{{ route('products.index') }}" class="btn btn-dh-outline mt-3" style="padding: 10px 32px;">
                    {{ __('common.see_all_products') }}
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
