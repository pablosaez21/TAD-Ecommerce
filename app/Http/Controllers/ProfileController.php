<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function addresses(): View
    {
        $user = auth()->user();
        abort_if(! $user, 401);

        $addresses = $user->addresses()->latest()->get();

        return view('profile.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 401);

        $validated = $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            ...$validated,
            'is_default' => (bool) ($validated['is_default'] ?? false),
        ]);

        return back()->with('status', 'Direccion creada correctamente.');
    }

    public function updateAddress(Request $request, int $addressId): RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 401);

        $address = $user->addresses()->findOrFail($addressId);

        $validated = $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address->update([
            ...$validated,
            'is_default' => (bool) ($validated['is_default'] ?? false),
        ]);

        return back()->with('status', 'Direccion actualizada correctamente.');
    }

    public function destroyAddress(int $addressId): RedirectResponse
    {
        $user = auth()->user();
        abort_if(! $user, 401);

        $address = $user->addresses()->findOrFail($addressId);
        $address->delete();

        return back()->with('status', 'Direccion eliminada correctamente.');
    }

    public function updateLanguage(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 401);

        $validated = $request->validate([
            'language' => ['required', 'in:es,en'],
        ]);

        $user->update(['language' => $validated['language']]);
        session(['locale' => $validated['language']]);

        return back()->with('status', 'Idioma actualizado correctamente.');
    }

    public function orders(): View
    {
        $user = auth()->user();
        abort_if(! $user, 401);

        $orders = $user->orders()
            ->with(['lines.product', 'payment', 'address'])
            ->latest()
            ->get();

        return view('profile.orders', compact('orders'));
    }

    public function showOrder(Order $order): View
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load(['lines.product', 'payment', 'address']);

        return view('orders.show', compact('order'));
    }

    public function orderConfirmation(Order $order): View
    {
        abort_if($order->user_id !== auth()->id(), 403);

        return view('orders.confirmation', compact('order'));
    }
}
