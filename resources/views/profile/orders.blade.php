@extends('layouts.app')

@section('title', __('orders.my_orders_title') . ' — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7; min-height: 70vh;">
    <div class="container">

        <span class="dh-label">{{ __('orders.label') }}</span>
        <h1 class="dh-section-title mb-5">{{ __('orders.my_orders_title') }}</h1>

        @forelse ($orders as $order)
            @if ($loop->first)
                <div style="background: #fff;">
                    <table class="table mb-0">
                        <thead>
                            <tr style="border-bottom: 2px solid #F0F0F0;">
                                <th style="padding: 14px 24px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; font-weight: 600;">{{ __('orders.col_id') }}</th>
                                <th style="padding: 14px 24px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; font-weight: 600;">{{ __('orders.col_date') }}</th>
                                <th style="padding: 14px 24px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; font-weight: 600;">{{ __('orders.col_status') }}</th>
                                <th style="padding: 14px 24px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; font-weight: 600;">{{ __('orders.col_payment') }}</th>
                                <th style="padding: 14px 24px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; font-weight: 600; text-align: right;">{{ __('orders.col_total') }}</th>
                                <th style="padding: 14px 24px; border: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

                            <tr style="border-bottom: 1px solid #F7F7F7;">
                                <td style="padding: 20px 24px; border: none; color: var(--dh-muted); font-size: 0.88rem;">#{{ $order->id }}</td>
                                <td style="padding: 20px 24px; border: none; color: var(--dh-muted); font-size: 0.88rem;">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 20px 24px; border: none;">
                                    @php
                                        $cls = match($order->status ?? '') {
                                            'processing' => 'dh-badge-processing',
                                            'shipped'    => 'dh-badge-shipped',
                                            'delivered'  => 'dh-badge-delivered',
                                            'cancelled'  => 'dh-badge-cancelled',
                                            default      => 'dh-badge-default',
                                        };
                                        $statusLabel = match($order->status ?? '') {
                                            'processing' => __('orders.status_processing'),
                                            'shipped'    => __('orders.status_shipped'),
                                            'delivered'  => __('orders.status_delivered'),
                                            'cancelled'  => __('orders.status_cancelled'),
                                            default      => $order->status ?? '—',
                                        };
                                    @endphp
                                    <span class="dh-status-badge {{ $cls }}">{{ $statusLabel }}</span>
                                </td>
                                <td style="padding: 20px 24px; border: none; color: var(--dh-muted); font-size: 0.88rem; text-transform: capitalize;">
                                    {{ $order->payment?->payment_method ?? '—' }}
                                </td>
                                <td style="padding: 20px 24px; border: none; font-weight: 700; color: var(--dh-primary); font-size: 0.95rem; text-align: right;">
                                    {{ number_format((float) $order->total, 2) }} €
                                </td>
                                <td style="padding: 20px 24px; border: none; text-align: right;">
                                    <a href="{{ route('orders.show', $order) }}"
                                       style="font-size: 0.82rem; color: var(--dh-primary); text-decoration: none; font-weight: 600; white-space: nowrap;">
                                        {{ __('orders.see_detail') }}
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
                <h4 style="font-weight: 300; font-size: 1.8rem; color: var(--dh-text); margin-bottom: 0.5rem;">{{ __('orders.empty_title') }}</h4>
                <p style="color: var(--dh-muted); font-size: 0.9rem; margin-bottom: 2rem;">{{ __('orders.empty_subtitle') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-dh" style="padding: 12px 40px;">
                    {{ __('common.see_all_products') }}
                </a>
            </div>
        @endforelse

    </div>
</section>

@endsection
