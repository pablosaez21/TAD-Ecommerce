@extends('layouts.app')

@section('title', __('cart.title') . ' — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7; min-height: 70vh;">
    <div class="container">

        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">{{ __('cart.label') }}</p>
        <h1 class="mb-5" style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text);">{{ __('cart.title') }}</h1>

        @php $cartItems = session('cart', []); @endphp

        @if (count($cartItems) > 0)

            <div class="row g-5 align-items-start">

                <div class="col-lg-8">
                    <div style="background: #fff;">

                        @foreach ($cartItems as $item)
                            <div class="d-flex align-items-center gap-4 p-4 {{ !$loop->last ? 'border-bottom' : '' }}"
                                 style="border-color: #F0F0F0 !important;">

                                <div style="flex-shrink: 0; width: 80px; height: 80px; background: #F7F7F7; overflow: hidden;">
                                    @if (!empty($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                             alt="{{ $item['name'] ?? '' }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image" style="color: #D1D5DB;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold" style="font-size: 0.92rem; color: var(--dh-text);">
                                        {{ $item['name'] ?? '' }}
                                    </p>
                                    <p class="mb-0" style="font-size: 0.85rem; color: var(--dh-muted);">
                                        {{ number_format((float) ($item['price'] ?? 0), 2) }} {{ __('cart.unit_price') }}
                                    </p>
                                </div>

                                <div style="flex-shrink: 0; min-width: 60px; text-align: center;">
                                    <span style="font-size: 0.85rem; color: var(--dh-muted); display: block; margin-bottom: 2px;">{{ __('cart.qty_label') }}</span>
                                    <span style="font-size: 0.95rem; color: var(--dh-text); font-weight: 600;">
                                        {{ $item['quantity'] ?? 1 }}
                                    </span>
                                </div>

                                <div style="flex-shrink: 0; min-width: 80px; text-align: right;">
                                    <span style="font-weight: 700; color: var(--dh-text); font-size: 0.95rem;">
                                        {{ number_format((float) ($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }} €
                                    </span>
                                </div>

                                <div style="flex-shrink: 0;">
                                    <form method="POST" action="{{ route('cart.remove', $item['product_id'] ?? 0) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background: none; border: none; color: #D1D5DB; font-size: 1.1rem; cursor: pointer; padding: 4px; transition: color 0.2s;"
                                                onmouseenter="this.style.color='#dc2626'" onmouseleave="this.style.color='#D1D5DB'"
                                                aria-label="{{ __('cart.remove_label') }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('products.index') }}"
                           style="font-size: 0.85rem; color: var(--dh-muted); text-decoration: none;">
                            {{ __('cart.keep_shopping') }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div style="background: #fff; padding: 32px; position: sticky; top: 100px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            {{ __('cart.summary_title') }}
                        </h5>

                        @php
                            $subtotal = collect($cartItems)->sum(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 1));
                            $shipping = $subtotal >= 60 ? 0 : 4.95;
                            $total = $subtotal + $shipping;
                        @endphp

                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.9rem; color: var(--dh-muted);">
                            <span>{{ __('cart.subtotal') }}</span>
                            <span>{{ number_format($subtotal, 2) }} €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3" style="font-size: 0.9rem; color: var(--dh-muted);">
                            <span>{{ __('cart.shipping') }}</span>
                            <span>{{ $shipping === 0 ? __('common.free') : number_format($shipping, 2) . ' €' }}</span>
                        </div>

                        @if ($shipping > 0)
                            <p style="font-size: 0.78rem; color: var(--dh-muted); background: var(--dh-primary-light, #FBE9F2); padding: 8px 12px; border-radius: 2px; margin-bottom: 1rem;">
                                <i class="bi bi-truck me-1"></i>{{ __('cart.free_shipping_info') }}
                            </p>
                        @endif

                        <div class="d-flex justify-content-between pt-3 mb-4" style="border-top: 1px solid #F0F0F0;">
                            <span style="font-weight: 700; font-size: 1rem; color: var(--dh-text);">{{ __('cart.total') }}</span>
                            <span style="font-weight: 700; font-size: 1rem; color: var(--dh-primary);">{{ number_format($total, 2) }} €</span>
                        </div>

                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn btn-dh w-100"
                               style="padding: 14px 32px; font-size: 0.9rem;">
                                {{ __('cart.checkout_btn') }}
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-dh w-100"
                                   style="padding: 14px 32px; font-size: 0.9rem;">
                                    {{ __('cart.login_to_buy') }}
                                </a>
                            @else
                                <button class="btn btn-dh w-100" disabled style="padding: 14px 32px; font-size: 0.9rem;">
                                    {{ __('cart.checkout_btn') }}
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>

            </div>

        @else

            <div class="text-center" style="padding: 80px 0;">
                <i class="bi bi-bag d-block mb-4" style="font-size: 4rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; font-size: 1.8rem; color: var(--dh-text); margin-bottom: 0.75rem;">{{ __('cart.empty_title') }}</h4>
                <p style="color: var(--dh-muted); font-size: 0.95rem; margin-bottom: 2rem;">{{ __('cart.empty_subtitle') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-dh" style="padding: 12px 40px;">
                    {{ __('cart.see_products') }}
                </a>
            </div>

        @endif

    </div>
</section>

@endsection
