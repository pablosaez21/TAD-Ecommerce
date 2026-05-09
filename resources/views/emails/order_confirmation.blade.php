<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de pedido — Double Helix</title>
</head>
<body style="margin: 0; padding: 0; background: #F7F7F7; font-family: 'DM Sans', Arial, sans-serif; color: #111827;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background: #F7F7F7; padding: 48px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; max-width: 600px; width: 100%;">

                    {{-- Cabecera --}}
                    <tr>
                        <td style="background: #151515; padding: 32px 48px; border-top: 3px solid #D4006A;">
                            <p style="margin: 0; font-size: 1.1rem; font-weight: 700; letter-spacing: 3px; color: #ffffff;">
                                DOUBLE <span style="color: #D4006A;">HELIX</span>
                            </p>
                        </td>
                    </tr>

                    {{-- Cuerpo --}}
                    <tr>
                        <td style="padding: 48px;">

                            <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 4px; color: #D4006A; margin: 0 0 12px;">
                                Confirmación de pedido
                            </p>
                            <h1 style="font-size: 2rem; font-weight: 300; color: #111827; margin: 0 0 8px;">
                                ¡Gracias por tu compra!
                            </h1>
                            <p style="color: #6B7280; font-size: 0.95rem; margin: 0 0 32px; line-height: 1.7;">
                                Hemos recibido tu pedido correctamente. A continuación tienes el resumen.
                            </p>

                            {{-- Número de pedido --}}
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="background: #F7F7F7; margin-bottom: 32px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <p style="margin: 0 0 4px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #6B7280;">
                                            Número de pedido
                                        </p>
                                        <p style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #111827;">
                                            #{{ $order->id }}
                                        </p>
                                    </td>
                                    <td style="padding: 20px 24px; text-align: right;">
                                        <p style="margin: 0 0 4px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #6B7280;">
                                            Estado
                                        </p>
                                        <p style="margin: 0; font-size: 0.9rem; font-weight: 600; color: #111827; text-transform: capitalize;">
                                            {{ $order->status }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Artículos --}}
                            <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #6B7280; margin: 0 0 16px; font-weight: 600;">
                                Artículos
                            </p>

                            @foreach ($order->lines as $line)
                                <table width="100%" cellpadding="0" cellspacing="0"
                                       style="border-bottom: 1px solid #F0F0F0; margin-bottom: 12px; padding-bottom: 12px;">
                                    <tr>
                                        <td style="font-size: 0.9rem; color: #111827;">
                                            {{ $line->product->name ?? '—' }}
                                            <span style="color: #6B7280;">× {{ $line->quantity }}</span>
                                        </td>
                                        <td style="text-align: right; font-size: 0.9rem; font-weight: 600; color: #111827;">
                                            {{ number_format((float) $line->subtotal, 2) }} €
                                        </td>
                                    </tr>
                                </table>
                            @endforeach

                            {{-- Total --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 8px; margin-bottom: 40px;">
                                <tr>
                                    <td style="font-size: 1rem; font-weight: 700; color: #111827; padding-top: 16px; border-top: 2px solid #F0F0F0;">
                                        Total
                                    </td>
                                    <td style="text-align: right; font-size: 1.1rem; font-weight: 700; color: #D4006A; padding-top: 16px; border-top: 2px solid #F0F0F0;">
                                        {{ number_format((float) $order->total, 2) }} €
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #6B7280; font-size: 0.88rem; line-height: 1.7; margin: 0;">
                                Si tienes alguna duda sobre tu pedido, escríbenos y te ayudamos.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background: #151515; padding: 24px 48px; text-align: center;">
                            <p style="margin: 0; font-size: 0.78rem; color: #6B7280;">
                                &copy; {{ date('Y') }} Double Helix. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
