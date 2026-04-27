@extends('layouts.app')

@section('title', 'Panel de administración — Double Helix')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7; min-height: 80vh;">
    <div class="container">

        <p class="mb-2" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración</p>
        <h1 class="mb-5" style="font-weight: 300; font-size: 2.5rem; color: var(--dh-text);">Panel de control</h1>

        {{-- ─── Métricas ──────────────────────────────────────── --}}
        <div class="row g-4 mb-5">
            @php
                $metrics = [
                    ['label' => 'Productos',    'value' => $totalProducts ?? '—',   'icon' => 'bi-box-seam',     'link' => '#'],
                    ['label' => 'Pedidos',      'value' => $totalOrders ?? '—',     'icon' => 'bi-bag-check',    'link' => '#'],
                    ['label' => 'Clientes',     'value' => $totalUsers ?? '—',      'icon' => 'bi-people',       'link' => '#'],
                    ['label' => 'Ingresos',     'value' => isset($totalRevenue) ? number_format($totalRevenue, 2) . ' €' : '—', 'icon' => 'bi-graph-up', 'link' => '#'],
                ];
            @endphp

            @foreach ($metrics as $metric)
                <div class="col-6 col-lg-3">
                    <div style="background: #fff; padding: 32px 28px;">
                        <i class="bi {{ $metric['icon'] }} d-block mb-3" style="font-size: 1.75rem; color: var(--dh-primary);"></i>
                        <p class="mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted);">
                            {{ $metric['label'] }}
                        </p>
                        <p class="dh-admin-metric-number mb-0">{{ $metric['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4 align-items-start">

            {{-- ─── Últimos pedidos ────────────────────────────── --}}
            <div class="col-lg-8">
                <div style="background: #fff; padding: 36px;">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text); margin-bottom: 0;">
                            Últimos pedidos
                        </h5>
                        <a href="#" style="font-size: 0.82rem; color: var(--dh-primary); text-decoration: none;"> {{-- ruta pendiente: admin.orders.index --}}
                            Ver todos →
                        </a>
                    </div>

                    @forelse ($latestOrders ?? [] as $order)
                        @if ($loop->first)
                            <table class="table mb-0" style="font-size: 0.85rem;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #F0F0F0;">
                                        <th style="padding: 10px 0; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">#</th>
                                        <th style="padding: 10px 0; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Cliente</th>
                                        <th style="padding: 10px 0; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Estado</th>
                                        <th style="padding: 10px 0; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @endif

                                <tr style="border-bottom: 1px solid #F7F7F7;">
                                    <td style="padding: 14px 0; border: none; color: var(--dh-muted);">#{{ $order->id }}</td>
                                    <td style="padding: 14px 0; border: none; color: var(--dh-text);">{{ $order->user?->name ?? '—' }}</td>
                                    <td style="padding: 14px 0; border: none;">
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
                                    <td style="padding: 14px 0; border: none; font-weight: 700; color: var(--dh-primary); text-align: right;">
                                        {{ number_format((float) ($order->total ?? 0), 2) }} €
                                    </td>
                                </tr>

                        @if ($loop->last)
                                </tbody>
                            </table>
                        @endif

                    @empty
                        <p style="color: var(--dh-muted); font-size: 0.88rem; text-align: center; padding: 32px 0;">No hay pedidos registrados.</p>
                    @endforelse
                </div>
            </div>

            {{-- ─── Accesos rápidos ────────────────────────────── --}}
            <div class="col-lg-4">
                <div style="background: #fff; padding: 36px;">
                    <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                        Accesos rápidos
                    </h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-dh w-100 text-start" style="padding: 12px 20px; font-size: 0.88rem;">
                            <i class="bi bi-plus-lg me-2"></i>Nuevo producto
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-dh-outline w-100 text-start" style="padding: 12px 20px; font-size: 0.88rem;">
                            <i class="bi bi-box-seam me-2"></i>Ver productos
                        </a>
                        <a href="#" class="btn btn-dh-outline w-100 text-start" style="padding: 12px 20px; font-size: 0.88rem;"> {{-- ruta pendiente: admin.orders.index --}}
                            <i class="bi bi-bag-check me-2"></i>Ver pedidos
                        </a>
                        <a href="#" class="btn btn-dh-outline w-100 text-start" style="padding: 12px 20px; font-size: 0.88rem;"> {{-- ruta pendiente: admin.users.index --}}
                            <i class="bi bi-people me-2"></i>Ver clientes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
