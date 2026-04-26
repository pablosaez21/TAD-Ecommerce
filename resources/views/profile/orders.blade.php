@extends('layouts.layout')

@section('content')
<h2 class="mb-3">Historial de pedidos</h2>

@forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-body">
            <h5>Pedido #{{ $order->id }}</h5>
            <p class="mb-1">Estado: {{ $order->status }}</p>
            <p class="mb-1">Total: {{ number_format((float) $order->total, 2) }} EUR</p>
            <p class="mb-2">Pago: {{ $order->payment?->status }} ({{ $order->payment?->payment_method }})</p>

            <ul class="mb-0">
                @foreach($order->lines as $line)
                    <li>{{ $line->product->name }} x {{ $line->quantity }} - {{ number_format((float) $line->subtotal, 2) }} EUR</li>
                @endforeach
            </ul>
        </div>
    </div>
@empty
    <p>No tienes pedidos todavia.</p>
@endforelse
@endsection
