<?php

namespace App\Services\Implementations;

use App\Models\Branch;
use App\Models\Hairstyle;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\Interfaces\ClientDashboardService;

class ClientDashboardServiceImpl implements ClientDashboardService
{
    public function getLandingPageData(): array
    {
        return [
            'services' => Service::all(),
            'branches' => Branch::all(),
            'testimonials' => Testimonial::with('customer')->get(),
        ];
    }

    public function getAll(): array
    {
        return [
            'hairstyles' => Hairstyle::all()
        ];
    }
}
