@extends('layouts.app')

@section('title', 'Pedidos — Admin')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7; min-height: 80vh;">
    <div class="container">

        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5">
            <div>
                <p class="mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración</p>
                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">Pedidos</h1>
            </div>
            {{-- Filtro de estado (no funcional) --}}
            <div class="d-flex gap-2 flex-wrap">
                @foreach (['Todos', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $f)
                    <button type="button" class="btn btn-sm"
                            style="border: 1px solid {{ $f === 'Todos' ? 'var(--dh-primary)' : '#E5E7EB' }}; border-radius: 2px; font-size: 0.78rem;
                                   color: {{ $f === 'Todos' ? 'var(--dh-primary)' : 'var(--dh-muted)' }}; background: #fff;">
                        {{ $f }}
                    </button> {{-- TODO: filtro por estado --}}
                @endforeach
            </div>
        </div>

        @forelse ($orders ?? [] as $order)
            @if ($loop->first)
                <div style="background: #fff;">
                    <table class="table mb-0" style="font-size: 0.88rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid #F0F0F0;">
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">#</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Cliente</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Fecha</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Estado</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Pago</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; text-align: right;">Total</th>
                                <th style="padding: 14px 24px; border: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

                            <tr style="border-bottom: 1px solid #F7F7F7;">
                                <td style="padding: 18px 24px; border: none; color: var(--dh-muted);">#{{ $order->id }}</td>
                                <td style="padding: 18px 24px; border: none;">
                                    <p class="mb-0" style="color: var(--dh-text); font-weight: 500;">{{ $order->user?->name ?? '—' }}</p>
                                    <p class="mb-0" style="font-size: 0.78rem; color: var(--dh-muted);">{{ $order->user?->email ?? '' }}</p>
                                </td>
                                <td style="padding: 18px 24px; border: none; color: var(--dh-muted);">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td style="padding: 18px 24px; border: none;">
                                    @php
                                        $bc = match($order->status ?? '') {
                                            'processing' => ['#FEF3C7','#92400E'],
                                            'shipped'    => ['#DBEAFE','#1E40AF'],
                                            'delivered'  => ['#D1FAE5','#065F46'],
                                            'cancelled'  => ['#FEE2E2','#991B1B'],
                                            default      => ['#F3F4F6','#374151'],
                                        };
                                    @endphp
                                    <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.72rem; font-weight: 600; background: {{ $bc[0] }}; color: {{ $bc[1] }}; text-transform: capitalize;">
                                        {{ $order->status ?? '—' }}
                                    </span>
                                </td>
                                <td style="padding: 18px 24px; border: none; color: var(--dh-muted); text-transform: capitalize;">
                                    {{ $order->payment?->status ?? '—' }}
                                </td>
                                <td style="padding: 18px 24px; border: none; font-weight: 700; color: var(--dh-primary); text-align: right;">
                                    {{ number_format((float) ($order->total ?? 0), 2) }} €
                                </td>
                                <td style="padding: 18px 24px; border: none; text-align: right;">
                                    <a href="#" {{-- ruta pendiente: admin.orders.show --}}
                                       style="font-size: 0.82rem; color: var(--dh-primary); text-decoration: none; font-weight: 600;">
                                        Ver →
                                    </a>
                                </td>
                            </tr>

            @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif

        @empty
            <div class="text-center" style="background: #fff; padding: 80px 0;">
                <i class="bi bi-bag-check d-block mb-4" style="font-size: 3rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; color: var(--dh-text);">No hay pedidos registrados</h4>
            </div>
        @endforelse

        @if (isset($orders) && $orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
