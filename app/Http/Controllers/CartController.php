<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 401);

        $validated = $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
            'payment_method' => ['required', 'string', 'max:120'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $address = $user->addresses()->whereKey($validated['address_id'])->firstOrFail();

        $order = DB::transaction(function () use ($validated, $user, $address) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'status' => 'processing',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::query()
                    ->whereKey($item['product_id'])
                    ->where('active', true)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock < $item['quantity']) {
                    abort(422, "Stock insuficiente para {$product->name}");
                }

                $unitPrice = (float) $product->price;
                $subtotal = $unitPrice * $item['quantity'];

                $order->lines()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);
                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            $order->payment()->create([
                'payment_method' => $validated['payment_method'],
                'status' => 'paid',
                'amount' => $total,
            ]);

            return $order->fresh(['lines.product', 'payment', 'address']);
        });

        Mail::to($user->email)->send(new OrderConfirmationMail($order));

        return redirect()
            ->route('profile.orders')
            ->with('status', 'Pedido realizado correctamente. Se envio confirmacion por correo.');
    }
}
