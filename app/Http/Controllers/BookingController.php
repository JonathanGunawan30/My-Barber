<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::all();

        return Inertia::render('Booking/Create', [
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'barber_id' => 'required|exists:barbers,id',
            'branch_id' => 'required|exists:branches,id',
            'time' => 'required|date_format:Y-m-d H:i:s',
            'note' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $service = Service::findOrFail($data['service_id']);

        $booking = Booking::create([
            'customer_id' => auth()->guard('customer')->id(),
            'service_id' => $service->id,
            'barber_id' => $data['barber_id'],
            'branch_id' => $data['branch_id'],
            'time' => $data['time'],
            'note' => $data['note'],
            'status' => 'pending',
            'date' => $data['date'],
        ]);

        $customer = auth()->guard('customer')->user();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $payload = [
            'transaction_details' => [
                'order_id' => 'INV-' . $booking->id,
                'gross_amount' => $service->price,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
            ],
            'callbacks' => [
                'finish' => route('booking.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function finish(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $orderId = $request->query('order_id');
        $status = \Midtrans\Transaction::status($orderId);

        $bookingId = str_replace('INV-', '', $orderId);
        $booking = Booking::findOrFail($bookingId);

        if ($status->transaction_status === 'settlement') {
            $booking->status = 'paid';
        } elseif (in_array($status->transaction_status, ['deny', 'cancel', 'expire'])) {
            $booking->status = 'failed';
        }

        $booking->save();

        return Inertia::render('Booking/Finish', [
            'status' => $booking->status,
            'booking' => $booking,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $bookingId = str_replace('INV-', '', $orderId);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if ($transactionStatus === 'settlement') {
            $booking->status = 'paid';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $booking->status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $booking->status = 'pending';
        }

        $booking->save();

        return response()->json(['message' => 'Status updated']);
    }

    public function review(Request $request, Booking $booking)
    {
        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($booking->status !== 'done' || $booking->testimonial) {
            return back()->with('error', 'This booking cannot be reviewed.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Testimonial::create([
            'booking_id'  => $booking->id,
            'customer_id' => $booking->customer_id,
            'barber_id'   => $booking->barber_id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Thank you for your testimonial!');
    }



}
