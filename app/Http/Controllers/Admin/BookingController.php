<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->query('q');
        $status = $request->query('status');

        $bookings = Booking::query()
            ->with(['customer', 'service', 'package'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('booking_code', 'like', "%{$q}%")
                       ->orWhereHas('customer', function ($c) use ($q) {
                           $c->where('full_name', 'like', "%{$q}%")
                             ->orWhere('phone', 'like', "%{$q}%");
                       });
                });
            })
            ->when($status, fn ($query) => $query->status($status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statuses' => Booking::STATUSES,
            'status'   => $status,
            'q'        => $q,
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'service', 'package']);

        return view('admin.bookings.show', [
            'booking'  => $booking,
            'statuses' => Booking::STATUSES,
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Booking::STATUSES)],
        ]);

        if ($booking->status === $validated['status']) {
            return back()->with('info', 'Status tidak berubah.');
        }

        $booking->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
