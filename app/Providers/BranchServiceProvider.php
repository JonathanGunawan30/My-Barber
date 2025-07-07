<?php

namespace App\Providers;

use App\Services\Implementations\BranchServiceImpl;
use App\Services\Interfaces\BranchService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BranchServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        BranchService::class => BranchServiceImpl::class,
    ];

    public function provides(): array
    {
        return [BranchService::class];
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
