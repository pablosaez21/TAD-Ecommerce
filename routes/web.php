<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('products', ProductController::class);

// Carrito — accesible sin login (sesión)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function (): void {
    // Checkout
    Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Favoritos
    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Pedidos
    Route::get('/orders/{order}', [ProfileController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders/{order}/confirmation', [ProfileController::class, 'orderConfirmation'])->name('orders.confirmation');

    // Perfil
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::put('/profile/addresses/{addressId}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{addressId}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');
    Route::post('/profile/language', [ProfileController::class, 'updateLanguage'])->name('profile.language.update');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
});
