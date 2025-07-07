<?php

namespace App\Providers;

use App\Services\Implementations\BarberServiceImpl;
use App\Services\Interfaces\BarberService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BarberServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        BarberService::class => BarberServiceImpl::class,
    ];
    public function provides(): array
    {
        return [BarberService::class];
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
