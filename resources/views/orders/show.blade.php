@extends('layouts.app')

@section('title', 'Pedido #' . ($order->id ?? '—') . ' — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7;">
    <div class="container">

        {{-- Cabecera --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
            <div>
                <p class="mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Mi cuenta</p>
                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">
                    Pedido #{{ $order->id ?? '—' }}
                </h1>
            </div>
            <a href="{{ route('profile.orders') }}" style="font-size: 0.85rem; color: var(--dh-muted); text-decoration: none;">
                ← Volver a mis pedidos
            </a>
        </div>

        {{-- ─── Timeline de estado ─────────────────────────────── --}}
        @php
            $steps = ['processing' => 'Procesando', 'shipped' => 'Enviado', 'delivered' => 'Entregado'];
            $statuses = array_keys($steps);
            $currentIndex = array_search($order->status ?? 'processing', $statuses);
            if ($currentIndex === false) $currentIndex = 0;
        @endphp

        <div style="background: #fff; padding: 40px; margin-bottom: 32px;">
            <div class="d-flex align-items-center justify-content-between position-relative">

                {{-- Línea de fondo --}}
                <div style="position: absolute; top: 14px; left: 14px; right: 14px; height: 2px; background: #E5E7EB; z-index: 0;"></div>

                @foreach ($steps as $key => $label)
                    @php
                        $stepIndex = array_search($key, $statuses);
                        $isDone = $stepIndex <= $currentIndex && $order->status !== 'cancelled';
                    @endphp
                    <div class="text-center position-relative" style="z-index: 1; flex: 1;">
                        <div style="width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 10px;
                                    background: {{ $isDone ? 'var(--dh-primary)' : '#E5E7EB' }};
                                    display: flex; align-items: center; justify-content: center;">
                            @if ($isDone)
                                <i class="bi bi-check" style="color: #fff; font-size: 0.85rem;"></i>
                            @endif
                        </div>
                        <span style="font-size: 0.78rem; font-weight: {{ $isDone ? '600' : '400' }};
                                     color: {{ $isDone ? 'var(--dh-text)' : 'var(--dh-muted)' }}; white-space: nowrap;">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach

            </div>

            @if (($order->status ?? '') === 'cancelled')
                <div class="text-center mt-4">
                    <span style="font-size: 0.82rem; font-weight: 600; color: #dc2626; background: #FEE2E2; padding: 6px 16px; border-radius: 2px;">
                        Pedido cancelado
                    </span>
                </div>
            @endif
        </div>

        <div class="row g-4 align-items-start">

            {{-- ─── Productos ──────────────────────────────────── --}}
            <div class="col-lg-7">
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                        Artículos del pedido
                    </h5>

                    @forelse ($order->lines ?? [] as $line)
                        <div class="d-flex align-items-center gap-4 {{ !$loop->last ? 'pb-4 mb-4' : '' }}"
                             style="{{ !$loop->last ? 'border-bottom: 1px solid #F0F0F0;' : '' }}">
                            <div style="flex-shrink: 0; width: 72px; height: 72px; background: #F7F7F7; overflow: hidden;">
                                @if ($line->product?->image ?? false)
                                    <img src="{{ asset('storage/' . $line->product->image) }}"
                                         alt="{{ $line->product->name ?? '' }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image" style="color: #D1D5DB;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-semibold" style="font-size: 0.9rem; color: var(--dh-text);">
                                    {{ $line->product?->name ?? '—' }}
                                </p>
                                <p class="mb-0" style="font-size: 0.82rem; color: var(--dh-muted);">
                                    {{ number_format((float) ($line->unit_price ?? 0), 2) }} € × {{ $line->quantity ?? 1 }}
                                </p>
                            </div>
                            <div style="flex-shrink: 0;">
                                <span style="font-weight: 700; color: var(--dh-text); font-size: 0.9rem;">
                                    {{ number_format((float) ($line->subtotal ?? 0), 2) }} €
                                </span>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--dh-muted); font-size: 0.88rem;">Sin artículos registrados.</p>
                    @endforelse
                </div>
            </div>

            {{-- ─── Datos del pedido ───────────────────────────── --}}
            <div class="col-lg-5">

                {{-- Resumen económico --}}
                <div style="background: #fff; padding: 36px; margin-bottom: 24px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                        Resumen
                    </h5>
                    <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem; color: var(--dh-muted);">
                        <span>Subtotal</span>
                        <span>{{ number_format((float) ($order->total ?? 0), 2) }} €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3" style="font-size: 0.88rem; color: var(--dh-muted);">
                        <span>Pago</span>
                        <span style="text-transform: capitalize;">{{ $order->payment?->payment_method ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3" style="border-top: 1px solid #F0F0F0;">
                        <span style="font-weight: 700; color: var(--dh-text);">Total</span>
                        <span style="font-weight: 700; color: var(--dh-primary); font-size: 1.05rem;">
                            {{ number_format((float) ($order->total ?? 0), 2) }} €
                        </span>
                    </div>
                </div>

                {{-- Dirección de envío --}}
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-3" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                        Dirección de envío
                    </h5>
                    @isset($order->address)
                        <p class="mb-0" style="font-size: 0.88rem; color: var(--dh-muted); line-height: 1.75;">
                            {{ $order->address->street }}<br>
                            {{ $order->address->city }}, {{ $order->address->province }}<br>
                            {{ $order->address->postal_code }} — {{ $order->address->country }}<br>
                            <span style="color: var(--dh-text);">Tel. {{ $order->address->phone }}</span>
                        </p>
                    @else
                        <p style="font-size: 0.88rem; color: var(--dh-muted);">Sin dirección registrada.</p>
                    @endisset
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
