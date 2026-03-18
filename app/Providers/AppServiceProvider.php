<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Facades\URL;

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
        // 1. Force HTTPS for ngrok / production
        if (config('app.env') !== 'local' || str_contains(request()->url(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        // 2. Share categories with all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });
    }
}