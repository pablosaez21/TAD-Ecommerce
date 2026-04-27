@extends('layouts.app')

@section('title', 'Finalizar compra — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7;">
    <div class="container">

        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Último paso</p>
        <h1 class="mb-5" style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text);">Finalizar compra</h1>

        <div class="alert alert-info small mb-5" style="border-radius: 2px; border: none; background: #EFF6FF; color: #1d4ed8;">
            <i class="bi bi-info-circle me-2"></i>
            La pasarela de pago aún no está implementada. Este formulario es una demo del flujo de checkout.
        </div>

        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf

            <div class="row g-5 align-items-start">

                {{-- ─── Formulario ──────────────────────────────── --}}
                <div class="col-lg-7">

                    {{-- Dirección de envío --}}
                    <div style="background: #fff; padding: 36px; margin-bottom: 24px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            Dirección de envío
                        </h5>

                        @auth
                            @php $addresses = auth()->user()->addresses ?? collect(); @endphp
                            @if ($addresses->isNotEmpty())
                                <div class="mb-3">
                                    @foreach ($addresses as $address)
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio"
                                                   name="address_id" id="addr_{{ $address->id }}"
                                                   value="{{ $address->id }}"
                                                   {{ ($address->is_default || $loop->first) && !old('address_id') ? 'checked' : '' }}
                                                   {{ old('address_id') == $address->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="addr_{{ $address->id }}"
                                                   style="font-size: 0.88rem; color: var(--dh-text); cursor: pointer;">
                                                {{ $address->street }}, {{ $address->city }} — {{ $address->postal_code }}
                                                @if ($address->is_default)
                                                    <span class="badge ms-2"
                                                          style="background: var(--dh-primary-light, #FBE9F2); color: var(--dh-primary); font-weight: 500; font-size: 0.7rem; border-radius: 2px;">
                                                        Predeterminada
                                                    </span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('profile.addresses') }}" style="font-size: 0.82rem; color: var(--dh-primary);">
                                    + Añadir nueva dirección
                                </a>
                            @else
                                <div class="alert alert-warning small" style="border-radius: 2px; border: none;">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    No tienes direcciones guardadas.
                                    <a href="{{ route('profile.addresses') }}" style="color: inherit; font-weight: 600;">Añadir una dirección</a>
                                </div>
                                <input type="hidden" name="address_id" value="">
                            @endif
                        @else
                            <p class="text-muted small">Debes iniciar sesión para continuar.</p>
                            <input type="hidden" name="address_id" value="">
                        @endauth
                    </div>

                    {{-- Método de pago --}}
                    <div style="background: #fff; padding: 36px; margin-bottom: 24px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            Método de pago
                        </h5>

                        @foreach (['card' => 'Tarjeta de crédito / débito', 'paypal' => 'PayPal', 'transfer' => 'Transferencia bancaria'] as $val => $label)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"
                                       name="payment_method" id="pay_{{ $val }}"
                                       value="{{ $val }}"
                                       {{ old('payment_method', 'card') === $val ? 'checked' : '' }}>
                                <label class="form-check-label" for="pay_{{ $val }}"
                                       style="font-size: 0.88rem; color: var(--dh-text); cursor: pointer;">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Items ocultos del carrito --}}
                    @php $cartItems = session('cart', []); @endphp
                    @foreach ($cartItems as $idx => $item)
                        <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item['product_id'] ?? '' }}">
                        <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}">
                    @endforeach

                    <button type="submit" class="btn btn-dh w-100" style="padding: 16px 32px; font-size: 0.95rem; letter-spacing: 0.5px;">
                        Confirmar pedido
                    </button>
                </div>

                {{-- ─── Resumen ──────────────────────────────────── --}}
                <div class="col-lg-5">
                    <div style="background: #fff; padding: 36px; position: sticky; top: 100px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            Tu pedido
                        </h5>

                        @php
                            $subtotal = 0;
                        @endphp

                        @forelse ($cartItems as $item)
                            @php $line = ($item['price'] ?? 0) * ($item['quantity'] ?? 1); $subtotal += $line; @endphp
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="flex: 1; padding-right: 16px;">
                                    <p class="mb-0" style="font-size: 0.88rem; color: var(--dh-text); font-weight: 500;">
                                        {{ $item['name'] ?? '—' }}
                                    </p>
                                    <p class="mb-0" style="font-size: 0.8rem; color: var(--dh-muted);">
                                        × {{ $item['quantity'] ?? 1 }}
                                    </p>
                                </div>
                                <span style="font-size: 0.88rem; color: var(--dh-text); white-space: nowrap;">
                                    {{ number_format($line, 2) }} €
                                </span>
                            </div>
                        @empty
                            <p style="font-size: 0.88rem; color: var(--dh-muted);">El carrito está vacío.</p>
                        @endforelse

                        @php $shipping = $subtotal >= 60 ? 0 : 4.95; $total = $subtotal + $shipping; @endphp

                        <div class="pt-3 mt-3" style="border-top: 1px solid #F0F0F0;">
                            <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem; color: var(--dh-muted);">
                                <span>Subtotal</span>
                                <span>{{ number_format($subtotal, 2) }} €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3" style="font-size: 0.88rem; color: var(--dh-muted);">
                                <span>Envío</span>
                                <span>{{ $shipping === 0 ? 'Gratis' : number_format($shipping, 2) . ' €' }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-3" style="border-top: 1px solid #F0F0F0;">
                                <span style="font-weight: 700; color: var(--dh-text);">Total</span>
                                <span style="font-weight: 700; color: var(--dh-primary); font-size: 1.1rem;">{{ number_format($total, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>

@endsection
