@extends('layouts.app')

@section('title', 'Pedido #' . ($order->id ?? '—') . ' — Admin')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7;">
    <div class="container">

        <div class="mb-5">
            <a href="#" style="font-size: 0.82rem; color: var(--dh-muted); text-decoration: none;"> {{-- ruta pendiente: admin.orders.index --}}
                ← Volver a pedidos
            </a>
            <p class="mt-3 mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración / Pedidos</p>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">
                    Pedido #{{ $order->id ?? '—' }}
                </h1>
                {{-- Cambio de estado (no funcional) --}}
                <div class="d-flex gap-2">
                    @foreach (['processing' => 'Procesando', 'shipped' => 'Enviado', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado'] as $val => $label)
                        <form method="POST" action="#"> {{-- ruta pendiente: admin.orders.update --}}
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $val }}">
                            <button type="submit"
                                    style="padding: 6px 14px; font-size: 0.78rem; border-radius: 2px; cursor: pointer;
                                           border: 1px solid {{ ($order->status ?? '') === $val ? 'var(--dh-primary)' : '#E5E7EB' }};
                                           background: {{ ($order->status ?? '') === $val ? 'var(--dh-primary)' : '#fff' }};
                                           color: {{ ($order->status ?? '') === $val ? '#fff' : 'var(--dh-muted)' }};">
                                {{ $label }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-start">

            {{-- ─── Artículos ──────────────────────────────────── --}}
            <div class="col-lg-7">
                <div style="background: #fff; padding: 36px; margin-bottom: 20px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                        Artículos
                    </h5>
                    @forelse ($order->lines ?? [] as $line)
                        <div class="d-flex align-items-center gap-4 {{ !$loop->last ? 'pb-4 mb-4' : '' }}"
                             style="{{ !$loop->last ? 'border-bottom: 1px solid #F0F0F0;' : '' }}">
                            <div style="flex-shrink: 0; width: 64px; height: 64px; background: #F7F7F7; overflow: hidden;">
                                @if ($line->product?->image ?? false)
                                    <img src="{{ asset('storage/' . $line->product->image) }}" alt=""
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image" style="color: #D1D5DB;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold" style="font-size: 0.88rem; color: var(--dh-text);">{{ $line->product?->name ?? '—' }}</p>
                                <p class="mb-0" style="font-size: 0.8rem; color: var(--dh-muted);">{{ number_format((float)($line->unit_price ?? 0), 2) }} € × {{ $line->quantity ?? 1 }}</p>
                            </div>
                            <span style="font-weight: 700; color: var(--dh-text); font-size: 0.9rem; flex-shrink: 0;">
                                {{ number_format((float)($line->subtotal ?? 0), 2) }} €
                            </span>
                        </div>
                    @empty
                        <p style="color: var(--dh-muted); font-size: 0.88rem;">Sin artículos.</p>
                    @endforelse
                </div>

                {{-- Cliente --}}
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-3" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">Cliente</h5>
                    <div style="font-size: 0.88rem; color: var(--dh-text);">
                        <p class="mb-1 fw-semibold">{{ $order->user?->name ?? '—' }}</p>
                        <p class="mb-1" style="color: var(--dh-muted);">{{ $order->user?->email ?? '—' }}</p>
                        <p class="mb-0" style="color: var(--dh-muted);">
                            Miembro desde {{ $order->user?->created_at->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- ─── Panel derecho ───────────────────────────────── --}}
            <div class="col-lg-5">

                {{-- Resumen económico --}}
                <div style="background: #fff; padding: 36px; margin-bottom: 20px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">Resumen</h5>
                    <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem; color: var(--dh-muted);">
                        <span>Método de pago</span>
                        <span style="text-transform: capitalize;">{{ $order->payment?->payment_method ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem; color: var(--dh-muted);">
                        <span>Estado de pago</span>
                        <span style="text-transform: capitalize;">{{ $order->payment?->status ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3" style="border-top: 1px solid #F0F0F0; font-weight: 700; color: var(--dh-text);">
                        <span>Total</span>
                        <span style="color: var(--dh-primary); font-size: 1.1rem;">{{ number_format((float)($order->total ?? 0), 2) }} €</span>
                    </div>
                </div>

                {{-- Dirección de envío --}}
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-3" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">Dirección de envío</h5>
                    @isset($order->address)
                        <p style="font-size: 0.88rem; color: var(--dh-muted); line-height: 1.75; margin-bottom: 0;">
                            {{ $order->address->street }}<br>
                            {{ $order->address->city }}, {{ $order->address->province }}<br>
                            {{ $order->address->postal_code }} — {{ $order->address->country }}<br>
                            <span style="color: var(--dh-text);">Tel. {{ $order->address->phone }}</span>
                        </p>
                    @else
                        <p style="font-size: 0.88rem; color: var(--dh-muted);">Sin dirección.</p>
                    @endisset
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
