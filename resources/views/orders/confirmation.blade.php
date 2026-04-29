@extends('layouts.app')

@section('title', 'Pedido confirmado — Double Helix')

@section('content')

<section style="padding: 120px 0; background: #fff; min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">

                <i class="bi bi-check-circle d-block mb-4" style="font-size: 4rem; color: var(--dh-primary);"></i>

                <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-muted);">
                    Pedido realizado
                </p>
                <h1 class="mb-3" style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text);">
                    ¡Gracias por tu compra!
                </h1>
                <p style="color: var(--dh-muted); font-size: 0.95rem; line-height: 1.7; margin-bottom: 2.5rem;">
                    Hemos recibido tu pedido. Recibirás un correo de confirmación en breve.
                </p>

                @isset($order)
                    <div style="background: #F7F7F7; padding: 28px 32px; margin-bottom: 2.5rem; text-align: left;">
                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem;">
                            <span style="color: var(--dh-muted);">Número de pedido</span>
                            <span style="color: var(--dh-text); font-weight: 600;">#{{ $order->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.88rem;">
                            <span style="color: var(--dh-muted);">Estado</span>
                            <span style="color: var(--dh-text); font-weight: 600; text-transform: capitalize;">{{ $order->status ?? '—' }}</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2" style="border-top: 1px solid #E5E7EB; font-size: 0.95rem;">
                            <span style="color: var(--dh-text); font-weight: 600;">Total</span>
                            <span style="color: var(--dh-primary); font-weight: 700;">{{ number_format((float) ($order->total ?? 0), 2) }} €</span>
                        </div>
                    </div>
                @endisset

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('profile.orders') }}" class="btn btn-dh" style="padding: 12px 36px; font-size: 0.9rem;">
                        Ver mis pedidos
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-dh-outline" style="padding: 12px 36px; font-size: 0.9rem;">
                        Seguir comprando
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
