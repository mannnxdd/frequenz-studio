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

        // Cari / buat customer berdasarkan nomor WA (unik)
        $customer = Customer::firstOrCreate(
            ['phone' => $request->phone],
            [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'address'   => null,
            ]
        );

        // Kalau customer sudah ada, update nama/email kalau kosong atau berubah (opsional tapi enak)
        $customer->update([
            'full_name' => $request->full_name,
            'email'     => $request->email,
        ]);

        // Ambil paket untuk hitung harga (kalau dipilih)
        $package = null;
        if ($request->package_id) {
            $package = Package::find($request->package_id);
        }

        // Generate booking_code yang aman unik
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
            'status'       => 'pending',
        ]);

        return redirect()
            ->route('booking.create')
            ->with('success', 'Booking berhasil dibuat. Kode booking kamu: ' . $booking->booking_code);
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
            return back()->withErrors(['not_found' => 'Booking tidak ditemukan. Pastikan kode booking dan nomor WA benar.']);
        }

        return view('booking.result', compact('booking'));
    }

    private function generateBookingCode(): string
    {
        // Format: FQZ-2026-XXXXXX (acak) + retry kalau tabrakan
        $year = date('Y');

        do {
            $random = strtoupper(bin2hex(random_bytes(3))); // 6 char
            $code = "FQZ-{$year}-{$random}";
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
