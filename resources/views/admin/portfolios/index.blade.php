@extends('admin.layouts.app')
@section('title','Admin - Portofolio')

@section('content')
<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-bold">Portofolio</h1>
    <p class="text-zinc-400 text-sm mt-1">Tambah karya, upload media, publish/unpublish.</p>
  </div>

  <div class="flex items-center gap-3">
    <form method="GET" class="flex items-center gap-3">
      <select name="service_id" class="rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
        <option value="">Semua layanan</option>
        @foreach($services as $s)
          <option value="{{ $s->id }}" @selected((string)$serviceId === (string)$s->id)>{{ $s->name }}</option>
        @endforeach
      </select>
      <button class="px-5 py-2 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">Filter</button>
    </form>

    <a href="{{ route('admin.portfolios.create') }}"
       class="px-5 py-2 rounded-xl border border-zinc-700 text-zinc-200 hover:border-zinc-500 hover:text-white">
      + Tambah
    </a>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  @foreach($portfolios as $p)
    @php $cover = optional($p->media->first())->url; @endphp
    <a href="{{ route('admin.portfolios.edit', $p) }}"
       class="rounded-3xl border border-zinc-800 bg-zinc-950/40 overflow-hidden glow-hover">
      <div class="aspect-[4/3] bg-black">
        @if($cover)
          <img src="{{ $cover }}" class="h-full w-full object-cover opacity-90">
        @else
          <div class="h-full w-full flex items-center justify-center text-zinc-600 text-sm">No Media</div>
        @endif
      </div>
      <div class="p-5">
        <p class="font-semibold">{{ $p->title }}</p>
        <p class="text-xs text-zinc-400 mt-1">{{ $p->service?->name }}</p>
        <p class="text-xs mt-2">
          <span class="px-2 py-1 rounded-lg border border-zinc-700">{{ $p->is_published ? 'published' : 'draft' }}</span>
        </p>
      </div>
    </a>
  @endforeach
</div>

<div class="mt-6 text-zinc-300">
  {{ $portfolios->links() }}
</div>
@endsection
