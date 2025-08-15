<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
        // Paksa HTTPS jika APP_URL menggunakan skema https
        $appUrl = (string) config('app.url');
        if (str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();
    }
}
