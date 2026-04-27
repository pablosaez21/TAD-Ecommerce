@extends('layouts.app')

@section('title', 'Mis pedidos — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7; min-height: 70vh;">
    <div class="container">

        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Mi cuenta</p>
        <h1 class="mb-5" style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text);">Mis pedidos</h1>

        @forelse ($orders as $order)
            @if ($loop->first)
                <div style="background: #fff;">
                    <table class="table mb-0" style="font-size: 0.88rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid #F0F0F0;">
                                <th style="padding: 16px 24px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">
                                    Pedido
                                </th>
                                <th style="padding: 16px 24px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">
                                    Fecha
                                </th>
                                <th style="padding: 16px 24px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">
                                    Estado
                                </th>
                                <th style="padding: 16px 24px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">
                                    Total
                                </th>
                                <th style="padding: 16px 24px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">
                                    Pago
                                </th>
                                <th style="padding: 16px 24px; border: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

                            <tr style="border-bottom: 1px solid #F7F7F7;">
                                <td style="padding: 20px 24px; border: none; color: var(--dh-text); font-weight: 600;">
                                    #{{ $order->id }}
                                </td>
                                <td style="padding: 20px 24px; border: none; color: var(--dh-muted);">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 20px 24px; border: none;">
                                    @php
                                        $badgeColor = match($order->status ?? '') {
                                            'processing'  => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                                            'shipped'     => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
                                            'delivered'   => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                                            'cancelled'   => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
                                            default       => ['bg' => '#F3F4F6', 'text' => '#374151'],
                                        };
                                    @endphp
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 2px; font-size: 0.75rem; font-weight: 600; background: {{ $badgeColor['bg'] }}; color: {{ $badgeColor['text'] }}; text-transform: capitalize;">
                                        {{ $order->status ?? '—' }}
                                    </span>
                                </td>
                                <td style="padding: 20px 24px; border: none; font-weight: 700; color: var(--dh-primary);">
                                    {{ number_format((float) ($order->total ?? 0), 2) }} €
                                </td>
                                <td style="padding: 20px 24px; border: none; color: var(--dh-muted); text-transform: capitalize;">
                                    {{ $order->payment?->payment_method ?? '—' }}
                                </td>
                                <td style="padding: 20px 24px; border: none; text-align: right;">
                                    <a href="#" {{-- ruta pendiente: orders.show --}}
                                       style="font-size: 0.82rem; color: var(--dh-primary); text-decoration: none; font-weight: 600;">
                                        Ver detalle →
                                    </a>
                                </td>
                            </tr>

            @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif

        @empty
            <div class="text-center" style="padding: 80px 0;">
                <i class="bi bi-box-seam d-block mb-4" style="font-size: 3.5rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; font-size: 1.8rem; color: var(--dh-text); margin-bottom: 0.5rem;">Aún no tienes pedidos</h4>
                <p style="color: var(--dh-muted); font-size: 0.9rem; margin-bottom: 2rem;">Explora nuestra colección y realiza tu primera compra.</p>
                <a href="{{ route('products.index') }}" class="btn btn-dh" style="padding: 12px 40px;">
                    Ver productos
                </a>
            </div>
        @endforelse

    </div>
</section>

@endsection
