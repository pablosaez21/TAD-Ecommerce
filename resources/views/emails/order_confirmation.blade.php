<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacion de pedido</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111;">
    <h2 style="color: #ff00ff;">SportStore - Pedido #{{ $order->id }}</h2>
    <p>Gracias por tu compra. Este es el resumen de tu pedido.</p>

    <ul>
        @foreach($order->lines as $line)
            <li>
                {{ $line->product->name }} x {{ $line->quantity }} - {{ number_format((float) $line->subtotal, 2) }} EUR
            </li>
        @endforeach
    </ul>

    <p><strong>Total:</strong> {{ number_format((float) $order->total, 2) }} EUR</p>
    <p><strong>Estado:</strong> {{ $order->status }}</p>
    <p>Gracias por confiar en SportStore.</p>
</body>
</html>
