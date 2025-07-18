<?php

namespace App\Providers;

use App\Services\Implementations\ClientDashboardServiceImpl;
use App\Services\Interfaces\ClientDashboardService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ClientDashboardServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ClientDashboardService::class => ClientDashboardServiceImpl::class,
    ];

    public function provides(): array
    {
        return [ClientDashboardService::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
