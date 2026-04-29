<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = session('locale');

        if (auth()->check() && in_array(auth()->user()->language, ['es', 'en'], true)) {
            $locale = auth()->user()->language;
        }

        App::setLocale(in_array($locale, ['es', 'en'], true) ? $locale : 'es');
    }
}
