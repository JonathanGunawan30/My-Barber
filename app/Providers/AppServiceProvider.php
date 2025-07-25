<?php

namespace App\Providers;

use App\Services\OAuth\GoogleOAuthService;
use App\Services\OAuth\OAuthService;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton( OAuthService::class, GoogleOAuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if ($request->is('admin/*')) {
                return route('admin.dashboard');
            }
            return route('dashboard');
        });
    }
}
