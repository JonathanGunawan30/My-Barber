<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Hairstyle;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\Interfaces\ClientDashboardService;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected ClientDashboardService $clientDashboardService;
    public function __construct(ClientDashboardService $clientDashboardService)
    {
        $this->clientDashboardService = $clientDashboardService;
    }

    public function index()
    {
        $data = $this->clientDashboardService->getLandingPageData();

        return Inertia::render('Welcome', $data);
    }

    public function hairstyles()
    {
        $data = $this->clientDashboardService->getAll();
        return Inertia::render('Hairstyles/Index', $data);
    }

    public function dashboard()
    {
        $customer = auth()->guard('customer')->user();

        $bookings = Booking::where('customer_id', $customer->id)->get();

        $totalSpent = $bookings->whereIn('status', ['paid', 'done'])
            ->sum(fn($booking) => $booking->service->price);

        $favoriteServiceId = $bookings->groupBy('service_id')
            ->map->count()
            ->sortDesc()
            ->keys()
            ->first();

        $favoriteService = $favoriteServiceId ? Service::find($favoriteServiceId)->name : 'None';

        $branches = Branch::where('status', 'active')->get();
        $services = Service::all();
        $barbers = Barber::where('status', 'active')->get();
        $allFutureBookings = Booking::where('date', '>=', Carbon::today()->toDateString())
            ->with('service:id,duration')->get(['id', 'barber_id', 'service_id', 'date', 'time']);
        $customerBookings = Booking::where('customer_id', $customer->id)
            ->with(['service', 'branch', 'barber', 'testimonial'])->latest()->get();
        $reviewedBarberIds = Testimonial::where('customer_id', $customer->id)
            ->pluck('barber_id')->unique()->all();
        $customerTestimonials = Testimonial::where('customer_id', $customer->id)
            ->with(['barber:id,name,photo', 'booking.service:id,name'])->latest()->get();


        return Inertia::render('customer/Dashboard', [
            'customer' => $customer,
            'branches' => $branches,
            'services' => $services,
            'barbers' => $barbers,
            'allFutureBookings' => $allFutureBookings,
            'customerBookings' => $customerBookings,
            'reviewedBarberIds' => $reviewedBarberIds,
            'customerTestimonials' => $customerTestimonials,

            'customerStats' => [
                'totalBookings' => $bookings->count(),
                'totalSpent' => $totalSpent,
                'favoriteService' => $favoriteService,
                'memberSince' => $customer->created_at->toIso8601String(),
            ],
        ]);
    }
}
