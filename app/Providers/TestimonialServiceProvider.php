<?php

namespace App\Providers;

use App\Services\Implementations\TestimonialServiceImpl;
use App\Services\Interfaces\TestimonialService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TestimonialServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        TestimonialService::class => TestimonialServiceImpl::class,
    ];

    public function provides(): array
    {
        return [TestimonialService::class];
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
