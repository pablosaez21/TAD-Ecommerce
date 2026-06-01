<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('active', true)
        ->inRandomOrder()
        ->take(4)
        ->get();

    return view('home', compact('featuredProducts'));
})->name('home');

Route::resource('products', ProductController::class);

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Carrito — accesible sin login (sesión)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function (): void {
    // Checkout
    Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Favoritos
    Route::middleware('auth')->group(function () {
        Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index')->middleware('auth');

    // Pedidos
    Route::get('/orders/{order}', [ProfileController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders/{order}/confirmation', [ProfileController::class, 'orderConfirmation'])->name('orders.confirmation');

    // Perfil
    //Como cambio, se deberia de agrupar los endpoints ne un grupo. En este caso se trata de un perfil. Por tanto agruparlo
    //Por algo como pefil.
    // Same for everything else.
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::put('/profile/addresses/{addressId}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{addressId}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');
    Route::post('/profile/language', [ProfileController::class, 'updateLanguage'])->name('profile.language.update');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    

    // Autenticación
    Route::get('/home', function () {
        return view('auth.dashboard');
    })->middleware('auth');

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // Admin
    Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);

    });

    // Verificar email
    Route::get('/home', function () {
        return view('auth.dashboard');
    })->middleware(['auth','verified']);
});
