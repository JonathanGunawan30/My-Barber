<?php

namespace App\Providers;

use App\Services\Implementations\HairstyleServiceImpl;
use App\Services\Interfaces\HairstyleService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class HairstyleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HairstyleService::class => HairstyleServiceImpl::class,
    ];

    public function provides(): array
    {
        return [HairstyleService::class];
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
