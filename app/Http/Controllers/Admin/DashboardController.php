<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Inertia\Inertia;
use App\Models\Barber;
use App\Models\Booking;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $todaysBookingsCount = Booking::whereDate('date', Carbon::today())->count();
        $yesterdaysBookingsCount = Booking::whereDate('date', Carbon::yesterday())->count();

        $todaysRevenue = Booking::whereDate('date', Carbon::today())
            ->whereIn('status', ['paid', 'done'])
            ->with('service:id,price')
            ->get()
            ->sum(fn($booking) => $booking->service->price);

        $yesterdaysRevenue = Booking::whereDate('date', Carbon::yesterday())
            ->whereIn('status', ['paid', 'done'])
            ->with('service:id,price')
            ->get()
            ->sum(fn($booking) => $booking->service->price);

        $recentBookings = Booking::with(['customer:id,name', 'service:id,name,price'])
            ->latest()
            ->limit(5)
            ->get();

        $todaySchedule = Booking::whereDate('date', Carbon::today())
            ->with(['customer:id,name', 'barber:id,name'])
            ->whereIn('status', ['pending', 'paid'])
            ->orderBy('time')
            ->get();

        return Inertia::render('admin/Dashboard/Index', [
            'stats' => [
                'todaysBookings' => [
                    'count' => $todaysBookingsCount,
                    'percentageChange' => $this->calculatePercentageChange($todaysBookingsCount, $yesterdaysBookingsCount),
                ],
                'todaysRevenue' => [
                    'total' => $todaysRevenue,
                    'percentageChange' => $this->calculatePercentageChange($todaysRevenue, $yesterdaysRevenue),
                ],
                'activeCustomers' => [
                    'total' => Customer::count(),
                    'newThisWeek' => Customer::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
                ],
                'availableBarbers' => [
                    'active' => Barber::where('status', 'active')->count(),
                    'total' => Barber::count(),
                ],
            ],
            'recentBookings' => $recentBookings,
            'todaySchedule' => $todaySchedule,
        ]);
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100);
    }

}
