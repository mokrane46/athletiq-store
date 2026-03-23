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
        // 1. Auto-detect ngrok and fix asset URLs
        $forwardedHost = request()->header('X-Forwarded-Host');
        if ($forwardedHost && str_contains($forwardedHost, 'ngrok')) {
            URL::forceScheme('https');
            URL::forceRootUrl('https://' . $forwardedHost);
        }

        // 2. Share categories with all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });
    }
}