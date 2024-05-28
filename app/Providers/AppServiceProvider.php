<?php

namespace App\Providers;

use App\Services\UpsApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UpsApiService::class,
            fn ($app) => (new UpsApiService(
                config('services.ups.client_id'),
                config('services.ups.client_secret')
            ))->client()
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
