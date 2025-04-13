<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Schema;

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
        // Force HTTPS in production
        if (App::environment('production')) {
            URL::forceScheme('https');
            
            // Set correct asset URL for Vite in production
            if (config('app.asset_url')) {
                Vite::useScriptTagAttributes([
                    'crossorigin' => 'anonymous',
                ]);
                
                Vite::useCspNonce('vite-nonce');
            }
        }
        
        // Fix for MySQL string length in older versions
        Schema::defaultStringLength(191);
    }
}
