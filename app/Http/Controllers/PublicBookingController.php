<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Helpers\WhatsAppHelper;

class PublicBookingController extends Controller
{
    public function create(Request $request)
    {
        $selectedPackageId = $request->query('package_id');

        $services = Service::query()
            ->where('is_active', true)
            ->with(['packages' => function ($q) {
                $q->where('is_active', true)->orderBy('price');
            }])
            ->orderBy('name')
            ->get();

        $selectedPackage = null;
        if ($selectedPackageId) {
            $selectedPackage = Package::where('is_active', true)->find($selectedPackageId);
        }

        return view('booking.create', compact('services', 'selectedPackage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'  => ['required', 'string', 'max:150'],
            'phone'      => ['required', 'string', 'max:30'],
            'email'      => ['nullable', 'email', 'max:150'],

            'service_id' => ['required', 'exists:services,id'],
            'package_id' => ['nullable', 'exists:packages,id'],

            'event_date' => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time'   => ['nullable', 'date_format:H:i'],
            'location'   => ['nullable', 'string'],
            'brief'      => ['nullable', 'string'],
        ]);

        // Cari / buat customer berdasarkan nomor WA
        $customer = Customer::firstOrCreate(
            ['phone' => $request->phone],
            [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'address'   => null,
            ]
        );

        $customer->update([
            'full_name' => $request->full_name,
            'email'     => $request->email,
        ]);

        $package = $request->package_id
            ? Package::find($request->package_id)
            : null;

        $bookingCode = $this->generateBookingCode();

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'customer_id'  => $customer->id,
            'service_id'   => $request->service_id,
            'package_id'   => $request->package_id,

            'event_date'   => $request->event_date,
            'start_time'   => $request->start_time ? ($request->start_time . ':00') : null,
            'end_time'     => $request->end_time ? ($request->end_time . ':00') : null,
            'location'     => $request->location,
            'brief'        => $request->brief,

            'total_price'  => $package ? $package->price : 0,
            'status'       => Booking::STATUS_PENDING,
        ]);

        /**
         * ===============================
         * WhatsApp Notification (Admin)
         * ===============================
         */
        $waLink = null;
        if (config('app.admin_whatsapp')) {
            $waLink = 'https://wa.me/' . config('app.admin_whatsapp')
                . '?text=' . WhatsAppHelper::bookingMessage($booking);
        }

        return redirect()
            ->route('booking.create')
            ->with('success', 'Booking berhasil dibuat. Kode booking kamu: ' . $booking->booking_code)
            ->with('wa_link', $waLink);
    }

    public function checkForm()
    {
        return view('booking.check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'booking_code' => ['required', 'string', 'max:50'],
            'phone'        => ['required', 'string', 'max:30'],
        ]);

        $booking = Booking::query()
            ->where('booking_code', $request->booking_code)
            ->whereHas('customer', function ($q) use ($request) {
                $q->where('phone', $request->phone);
            })
            ->with(['customer', 'service', 'package'])
            ->first();

        if (!$booking) {
            return back()->withErrors([
                'not_found' => 'Booking tidak ditemukan. Pastikan kode booking dan nomor WA benar.'
            ]);
        }

        return view('booking.result', compact('booking'));
    }

    private function generateBookingCode(): string
    {
        $year = date('Y');

        do {
            $random = strtoupper(bin2hex(random_bytes(3)));
            $code = "FQZ-{$year}-{$random}";
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
