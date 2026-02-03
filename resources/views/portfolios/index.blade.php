@extends('site.layout')

@section('title', 'Portofolio - Frequenz Studio')

@section('content')
<div class="space-y-8">

    <div data-reveal class="reveal flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Portofolio</h1>
            <p class="text-zinc-400 mt-2">Kumpulan karya terbaru Frequenz Studio.</p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('portfolios.index') }}" class="flex items-center gap-3">
            <select name="service_id"
                    class="rounded-xl border border-zinc-800 bg-black px-4 py-2.5 text-zinc-100
                           focus:outline-none focus:ring-2 focus:ring-zinc-500">
                <option value="">Semua layanan</option>
                @foreach($services as $s)
                    <option value="{{ $s->id }}" @selected((string)$serviceId === (string)$s->id)>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>

            <button class="px-5 py-2.5 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200 transition">
                Filter
            </button>
        </form>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($portfolios as $p)
            @php
                $cover = optional($p->media->first())->url;
            @endphp

            <a data-reveal
               href="{{ route('portfolios.show', $p) }}"
               class="reveal group overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950/40 glow-hover">
                <div class="relative aspect-[4/3] bg-black">
                    @if($cover)
                        <img src="{{ $cover }}"
                             alt="{{ $p->title }}"
                             class="h-full w-full object-cover opacity-90 group-hover:opacity-100 transition duration-300">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-zinc-600 text-sm">
                            No Media
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <p class="text-base font-semibold">{{ $p->title }}</p>
                        <p class="text-xs text-zinc-300 mt-1">
                            {{ $p->service?->name ?? 'Frequenz Studio' }}
                            @if($p->project_date)
                                • {{ $p->project_date }}
                            @endif
                        </p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 rounded-3xl border border-zinc-800 bg-zinc-950/40 p-8 text-zinc-400">
                Belum ada portofolio yang dipublish.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="text-zinc-300">
        {{ $portfolios->links() }}
    </div>

</div>
@endsection
