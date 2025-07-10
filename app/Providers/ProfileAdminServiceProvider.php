<?php

namespace App\Providers;

use App\Services\Implementations\ProfileAdminServiceImpl;
use App\Services\Interfaces\ProfileAdminService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProfileAdminServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ProfileAdminService::class => ProfileAdminServiceImpl::class,
    ];

    public function provides(): array
    {
        return [ProfileAdminService::class];
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
