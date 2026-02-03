@extends('admin.layouts.app')
@section('title','Admin - Booking')

@section('content')
<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-bold">Booking</h1>
    <p class="text-zinc-400 text-sm mt-1">Kelola booking masuk dan ubah status.</p>
  </div>

  <form class="flex flex-wrap items-center gap-3">
    <input name="q" value="{{ $q }}" placeholder="Cari kode/nama/WA"
      class="rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100 placeholder:text-zinc-600">
    <select name="status"
      class="rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
      <option value="">Semua status</option>
      @foreach($statuses as $st)
        <option value="{{ $st }}" @selected($status === $st)>{{ $st }}</option>
      @endforeach
    </select>
    <button class="px-5 py-2 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">Filter</button>
  </form>
</div>

<div class="rounded-3xl border border-zinc-800 bg-zinc-950/40 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-black/40 text-zinc-300">
      <tr>
        <th class="text-left p-4">Kode</th>
        <th class="text-left p-4">Customer</th>
        <th class="text-left p-4">Layanan</th>
        <th class="text-left p-4">Tanggal</th>
        <th class="text-left p-4">Status</th>
        <th class="text-right p-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bookings as $b)
        <tr class="border-t border-zinc-800">
          <td class="p-4 font-semibold">{{ $b->booking_code }}</td>
          <td class="p-4">
            <div>{{ $b->customer->full_name }}</div>
            <div class="text-zinc-400 text-xs">{{ $b->customer->phone }}</div>
          </td>
          <td class="p-4">
            <div>{{ $b->service->name }}</div>
            <div class="text-zinc-400 text-xs">{{ $b->package?->name ?? 'Custom' }}</div>
          </td>
          <td class="p-4 text-zinc-300">{{ $b->event_date ?? '-' }}</td>
          <td class="p-4"><span class="px-2 py-1 rounded-lg border border-zinc-700">{{ $b->status }}</span></td>
          <td class="p-4 text-right">
            <a class="underline hover:text-white" href="{{ route('admin.bookings.show', $b) }}">Detail</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-6 text-zinc-300">
  {{ $bookings->links() }}
</div>
@endsection
