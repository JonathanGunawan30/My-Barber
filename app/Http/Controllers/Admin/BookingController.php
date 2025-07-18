<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'customer:id,name,email,avatar',
            'service:id,name,price',
            'barber:id,name',
            'branch:id,name'
        ])
            ->latest('date')
            ->get();
        return Inertia::render('admin/Booking/Index', [
            'bookings' => $bookings,
        ]);
    }
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'paid', 'done', 'canceled'])],
        ]);
        $booking->status = $request->status;
        $booking->save();
        return redirect()->back()->with('success', 'Booking status has been updated.');
    }
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking has been deleted successfully.');
    }
}
