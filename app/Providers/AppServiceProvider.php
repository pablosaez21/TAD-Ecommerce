<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $locale = session('locale');

        if (auth()->check() && in_array(auth()->user()->language, ['es', 'en'], true)) {
            $locale = auth()->user()->language;
        }

        App::setLocale(in_array($locale, ['es', 'en'], true) ? $locale : 'es');

        View::composer('partials.navbar', function ($view) {
            if (Schema::hasTable('categories')) {
                $view->with('navCategories', Category::orderBy('name')->get());
            } else {
                $view->with('navCategories', collect());
            }
        });
    }
}
