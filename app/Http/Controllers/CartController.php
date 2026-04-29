<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('cart.index');
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if (! $product->active || $product->stock <= 0) {
            return back()->with('error', 'Este producto no está disponible.');
        }

        $validated = $request->validate([
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $quantity = $validated['quantity'] ?? 1;
        $cart     = session('cart', []);
        $key      = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = min(
                $cart[$key]['quantity'] + $quantity,
                $product->stock
            );
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => (float) $product->price,
                'image'      => $product->image,
                'quantity'   => min($quantity, $product->stock),
            ];
        }

        session(['cart' => $cart]);

        return back()->with('status', "«{$product->name}» añadido al carrito.");
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[(string) $product->id]);
        session(['cart' => $cart]);

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    public function showCheckout(): View|RedirectResponse
    {
        if (empty(session('cart', []))) {
            return redirect()->route('cart.index')->with('status', 'Tu carrito está vacío.');
        }

        return view('checkout.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 401);

        $validated = $request->validate([
            'address_id'         => ['required', 'exists:addresses,id'],
            'payment_method'     => ['required', 'string', 'max:120'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $address = $user->addresses()->whereKey($validated['address_id'])->firstOrFail();

        $order = DB::transaction(function () use ($validated, $user, $address) {
            $order = Order::create([
                'user_id'    => $user->id,
                'address_id' => $address->id,
                'status'     => 'processing',
                'total'      => 0,
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
                $subtotal  = $unitPrice * $item['quantity'];

                $order->lines()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);
                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            $order->payment()->create([
                'payment_method' => $validated['payment_method'],
                'status'         => 'paid',
                'amount'         => $total,
            ]);

            return $order->fresh(['lines.product', 'payment', 'address']);
        });

        session()->forget('cart');

        Mail::to($user->email)->send(new OrderConfirmationMail($order));

        return redirect()
            ->route('orders.confirmation', $order)
            ->with('status', '¡Pedido realizado! Te hemos enviado la confirmación por correo.');
    }
}
