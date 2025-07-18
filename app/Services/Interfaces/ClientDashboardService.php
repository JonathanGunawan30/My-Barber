<?php

namespace App\Services\Interfaces;

use App\Models\Hairstyle;

interface ClientDashboardService
{
    public function getLandingPageData(): array;
    public function getAll(): array;
}
