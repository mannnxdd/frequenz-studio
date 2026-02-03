@extends('site.layout')

@section('title', 'Cek Booking - Frequenz Studio')

@section('content')
<div class="max-w-xl">
    <h1 class="text-3xl font-bold mb-2">Cek Booking</h1>
    <p class="text-zinc-400 mb-6">Masukkan kode booking dan nomor WhatsApp yang sama saat booking.</p>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-950/40 border border-red-800 text-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('booking.check') }}"
          class="rounded-2xl border border-zinc-800 bg-zinc-950/40 p-6 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="text-sm font-medium text-zinc-200">Kode Booking</label>
            <input name="booking_code" value="{{ old('booking_code') }}"
                   class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-3 py-2 text-zinc-100 placeholder:text-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-500"
                   placeholder="FQZ-2026-XXXXXX">
        </div>

        <div>
            <label class="text-sm font-medium text-zinc-200">Nomor WhatsApp</label>
            <input name="phone" value="{{ old('phone') }}"
                   class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-3 py-2 text-zinc-100 placeholder:text-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-500"
                   placeholder="08xxxx">
        </div>

        <button class="w-full px-5 py-2.5 rounded-xl bg-white text-black font-medium hover:bg-zinc-200">
            Cek Status
        </button>
    </form>
</div>
@endsection
