<?php

namespace App\Providers;

use App\Services\Implementations\ServiceServiceImpl;
use App\Services\Interfaces\ServiceService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ServiceService::class => ServiceServiceImpl::class,
    ];

    public function provides(): array
    {
        return [ServiceService::class];
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
