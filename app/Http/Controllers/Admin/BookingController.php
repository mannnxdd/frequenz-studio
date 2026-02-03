<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');

        $bookings = Booking::query()
            ->with(['customer', 'service', 'package'])
            ->when($q, function ($query) use ($q) {
                $query->where('booking_code', 'like', "%$q%")
                    ->orWhereHas('customer', fn($c) => $c->where('full_name', 'like', "%$q%")
                        ->orWhere('phone', 'like', "%$q%"));
            })
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $statuses = ['pending','confirmed','in_progress','done','cancelled'];

        return view('admin.bookings.index', compact('bookings', 'statuses', 'status', 'q'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer','service','package']);
        $statuses = ['pending','confirmed','in_progress','done','cancelled'];
        return view('admin.bookings.show', compact('booking','statuses'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,in_progress,done,cancelled'],
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
