<?php

namespace App\Helpers;

use App\Models\Booking;

class WhatsAppHelper
{
    public static function bookingMessage(Booking $booking): string
    {
        return urlencode(
            "*Pemberitahuan Booking Baru Masuk*\n\n" .
            "Kode: {$booking->booking_code}\n" .
            "Customer: {$booking->customer->full_name}\n" .
            "WA: {$booking->customer->phone}\n" .
            "Layanan: {$booking->service->name}\n" .
            "Tanggal: {$booking->event_date?->format('d M Y')}\n" .
            "Waktu: {$booking->start_time} - {$booking->end_time}\n\n" .
            "Segera sesuaikan jadwal dan konfirmasi kepada client anda."
        );
    }
}
