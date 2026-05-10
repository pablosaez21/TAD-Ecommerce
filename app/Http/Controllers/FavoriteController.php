<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function toggle(Product $product): RedirectResponse
    {
        $user = auth()->user();
        abort_if(! $user, 401);

        $alreadyFavorite = $user->favoriteProducts()->whereKey($product->id)->exists();

        if ($alreadyFavorite) {
            $user->favoriteProducts()->detach($product->id);
            $message = 'Producto eliminado de favoritos.';
        } else {
            $user->favoriteProducts()->attach($product->id);
            $message = 'Producto agregado a favoritos.';
        }

        return back()->with('status', $message);
    }

    public function index()
    {
        $products = auth()->user()
            ->favoriteProducts()
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('products'));
    }
}
