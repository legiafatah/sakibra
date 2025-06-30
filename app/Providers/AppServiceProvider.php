<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;


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
    public function boot(Request $request)
    {
        // URL::forceRootUrl(config('app.url'));
        // URL::forceScheme('https');

            if (request()->isSecure() || str_contains(request()->getHost(), 'ngrok')) {
                URL::forceScheme('https');
                config(['app.url' => request()->getSchemeAndHttpHost()]);
            }
    
     
    }
}
