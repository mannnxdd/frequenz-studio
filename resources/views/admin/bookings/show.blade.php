@extends('admin.layouts.app')
@section('title','Admin - Detail Booking')

@section('content')
<a href="{{ route('admin.bookings.index') }}" class="text-sm underline text-zinc-300 hover:text-white">← Kembali</a>

<div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
  <div class="lg:col-span-2 rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6">
    <div class="flex items-start justify-between gap-4">
      <div>
        <p class="text-zinc-400 text-sm">Kode Booking</p>
        <h1 class="text-2xl font-bold">{{ $booking->booking_code }}</h1>
      </div>
      <span class="px-3 py-1 rounded-xl border border-zinc-700">{{ $booking->status }}</span>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div>
        <p class="text-zinc-400">Customer</p>
        <p class="font-semibold">{{ $booking->customer->full_name }}</p>
        <p class="text-zinc-300">{{ $booking->customer->phone }}</p>
      </div>
      <div>
        <p class="text-zinc-400">Layanan</p>
        <p class="font-semibold">{{ $booking->service->name }}</p>
        <p class="text-zinc-300">{{ $booking->package?->name ?? 'Custom' }}</p>
      </div>
      <div>
        <p class="text-zinc-400">Tanggal & Waktu</p>
        <p class="text-zinc-300">{{ $booking->event_date ?? '-' }}</p>
        <p class="text-zinc-300">{{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}</p>
      </div>
      <div>
        <p class="text-zinc-400">Estimasi</p>
        <p class="text-zinc-300">Rp {{ number_format($booking->total_price,0,',','.') }}</p>
      </div>
    </div>

    <div class="mt-6">
      <p class="text-zinc-400 text-sm">Lokasi</p>
      <p class="text-zinc-300">{{ $booking->location ?? '-' }}</p>
    </div>

    <div class="mt-4">
      <p class="text-zinc-400 text-sm">Brief</p>
      <p class="text-zinc-300 whitespace-pre-line">{{ $booking->brief ?? '-' }}</p>
    </div>
  </div>

  <div class="rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6">
    <h2 class="text-lg font-semibold">Update Status</h2>
    <form class="mt-4 space-y-4" method="POST" action="{{ route('admin.bookings.update', $booking) }}">
      @csrf
      @method('PUT')

      <select name="status"
        class="w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
        @foreach($statuses as $st)
          <option value="{{ $st }}" @selected($booking->status === $st)>{{ $st }}</option>
        @endforeach
      </select>

      <button class="w-full px-5 py-2.5 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">
        Simpan
      </button>
    </form>
  </div>
</div>
@endsection
