@extends('site.layout')

@section('title', 'Detail Booking - Frequenz Studio')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Detail Booking</h1>

    <div class="rounded-2xl border border-zinc-800 bg-zinc-950/40 p-6 shadow-sm space-y-3">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm text-zinc-400">Kode Booking</p>
                <p class="text-xl font-bold">{{ $booking->booking_code }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm border border-zinc-700 text-zinc-200">
                Status: <b>{{ $booking->status }}</b>
            </span>
        </div>

        <div class="h-px bg-zinc-800"></div>

        <p class="text-zinc-200"><b class="text-zinc-100">Nama:</b> {{ $booking->customer->full_name }}</p>
        <p class="text-zinc-200"><b class="text-zinc-100">WhatsApp:</b> {{ $booking->customer->phone }}</p>

        <p class="text-zinc-200"><b class="text-zinc-100">Layanan:</b> {{ $booking->service->name }}</p>
        <p class="text-zinc-200"><b class="text-zinc-100">Paket:</b> {{ $booking->package?->name ?? 'Custom / tanpa paket' }}</p>

        <p class="text-zinc-200"><b class="text-zinc-100">Tanggal:</b> {{ $booking->event_date ?? '-' }}</p>
        <p class="text-zinc-200"><b class="text-zinc-100">Jam:</b> {{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}</p>

        <p class="text-zinc-200"><b class="text-zinc-100">Lokasi:</b> {{ $booking->location ?? '-' }}</p>
        <p class="text-zinc-200"><b class="text-zinc-100">Brief:</b> {{ $booking->brief ?? '-' }}</p>

        <p class="text-zinc-200"><b class="text-zinc-100">Estimasi Harga:</b> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

        <div class="pt-3 flex gap-4 text-sm text-zinc-300">
            <a href="{{ route('booking.check.form') }}" class="underline hover:text-white">Cek booking lain</a>
            <a href="{{ route('services.index') }}" class="underline hover:text-white">Lihat layanan</a>
        </div>
    </div>
</div>
@endsection
