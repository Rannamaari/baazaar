<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
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
        Order::observe(OrderObserver::class);
        
        // Force HTTPS URLs in production
        if (config('app.env') === 'production' || config('app.force_https', false)) {
            URL::forceScheme('https');
        }
        
        // Trust proxies for proper HTTPS detection
        if (config('trustedproxy.proxies') === '*') {
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
