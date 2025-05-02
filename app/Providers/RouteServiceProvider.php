<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    // ...
    
    public function boot(): void
    {
        $this->configureRateLimiting();
        
        // ...
    }
    
    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
{
    RateLimiter::for('login', function (Request $request) {
        return Limit::perMinute(3)->by($request->input('email') . '|' . $request->ip());
    });

    RateLimiter::for('global', function (Request $request) {
        return Limit::perMinute(1000);
    });

    RateLimiter::for('downloads', function (Request $request) {
        return Limit::perMinute(10);
    });
}
}