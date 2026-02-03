@extends('site.layout')

@section('title', 'Frequenz Studio — Creative Agency')

@section('content')
<div class="space-y-20">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2rem] border border-zinc-800 bg-zinc-950/40">
    {{-- Background image (optional) --}}
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero.jpg') }}"
            alt="Frequenz Studio"
            class="h-full w-full object-cover opacity-25"
            onerror="this.style.display='none'"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/50 to-black"></div>
        <div class="absolute inset-0 [mask-image:radial-gradient(60%_55%_at_50%_30%,black,transparent)]">
            <div class="h-full w-full opacity-[0.08]"
                 style="background-image:linear-gradient(to_right,rgba(255,255,255,.25)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,.25)_1px,transparent_1px);background-size:48px 48px;">
            </div>
        </div>
    </div>

    {{-- Ambient blobs --}}
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-28 -left-28 h-80 w-80 rounded-full bg-white/6 blur-3xl"></div>
        <div class="absolute -bottom-28 -right-28 h-80 w-80 rounded-full bg-white/6 blur-3xl"></div>
    </div>

    <div data-reveal class="reveal relative px-7 py-12 md:px-12 md:py-16">
        <p class="text-[11px] uppercase tracking-[0.35em] text-zinc-300/80">
            Creative Agency • Photo • Video • Design
        </p>

        <div class="mt-5 max-w-3xl">
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight leading-[1.1]">
                Visual yang terasa mahal.
                <span class="text-zinc-300">Untuk momen dan brand yang kamu bangun.</span>
            </h1>

            <p class="mt-5 text-zinc-300/80 text-base md:text-lg leading-relaxed">
                Frequenz Studio melayani fotografi & videografi wedding, sesi foto studio,
                hingga desain grafis untuk kebutuhan branding dan promosi.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('booking.create') }}"
                   class="btn-shine inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 font-semibold text-black hover:bg-zinc-200 transition">
                    Booking Sekarang
                </a>

                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-zinc-700 px-6 py-3 font-semibold text-zinc-100 hover:border-zinc-500 hover:bg-white/5 transition">
                    Lihat Layanan
                </a>
            </div>
        </div>

        {{-- Highlights --}}
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-zinc-800 bg-black/30 p-5 glow-hover">
                <p class="text-zinc-400 text-sm">Respon cepat</p>
                <p class="mt-1 font-semibold">Konfirmasi via WhatsApp</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-black/30 p-5 glow-hover">
                <p class="text-zinc-400 text-sm">Cinematic look</p>
                <p class="mt-1 font-semibold">Color grading clean</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-black/30 p-5 glow-hover">
                <p class="text-zinc-400 text-sm">Fleksibel</p>
                <p class="mt-1 font-semibold">Paket & custom request</p>
            </div>
        </div>
    </div>
</section>

    {{-- SERVICES --}}
    <section class="space-y-6">
        <div data-reveal class="reveal flex items-end justify-between gap-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Layanan unggulan</h2>
                <p class="mt-2 text-zinc-400">Pilih layanan yang paling sesuai dengan kebutuhanmu.</p>
            </div>

            <a href="{{ route('services.index') }}"
               class="hidden sm:inline-flex text-sm text-zinc-300 hover:text-white underline underline-offset-4">
                Lihat semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($services ?? [] as $service)
                @php $min = $service->packages->min('price'); @endphp
                <div data-reveal class="reveal rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6 glow-hover">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-lg font-semibold">{{ $service->name }}</h3>
                        <span class="rounded-xl border border-zinc-800 bg-black/30 px-3 py-1 text-xs text-zinc-300">
                            {{ $service->packages->count() }} paket
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-zinc-400 leading-relaxed min-h-[44px]">
                        {{ $service->description ?? 'Layanan profesional untuk kebutuhan visual kamu.' }}
                    </p>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-zinc-400">
                            @if($min)
                                Mulai <b class="text-zinc-100">Rp {{ number_format($min, 0, ',', '.') }}</b>
                            @else
                                Paket tersedia
                            @endif
                        </div>

                        <a href="{{ route('services.index') }}"
                           class="text-sm font-semibold text-zinc-100 hover:text-white underline underline-offset-4">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-zinc-800 bg-zinc-950/40 p-8 text-zinc-400">
                    Layanan belum tersedia.
                </div>
            @endforelse
        </div>

        <a href="{{ route('services.index') }}"
           class="sm:hidden inline-flex text-sm text-zinc-300 hover:text-white underline underline-offset-4">
            Lihat semua layanan
        </a>
    </section>

    {{-- PORTFOLIO --}}
    <section class="space-y-6">
        <div data-reveal class="reveal flex items-end justify-between gap-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Portofolio</h2>
                <p class="mt-2 text-zinc-400">Cuplikan karya terbaru dari Frequenz Studio.</p>
            </div>

            <a href="{{ route('portfolios.index') }}"
               class="hidden sm:inline-flex text-sm text-zinc-300 hover:text-white underline underline-offset-4">
                Lihat semua
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($portfolios ?? [] as $p)
                @php $cover = optional($p->media->first())->url; @endphp

                <a data-reveal href="{{ route('portfolios.show', $p) }}"
                   class="reveal group relative overflow-hidden rounded-3xl border border-zinc-800 bg-black glow-hover">
                    <div class="aspect-[4/3]">
                        @if($cover)
                            <img src="{{ $cover }}" alt="{{ $p->title }}"
                                 class="h-full w-full object-cover opacity-90 group-hover:opacity-100 transition duration-300">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-zinc-600 text-sm">
                                No Media
                            </div>
                        @endif
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-sm font-semibold">{{ $p->title }}</p>
                        <p class="mt-1 text-xs text-zinc-300">
                            {{ $p->service?->name ?? 'Frequenz Studio' }}
                            @if($p->project_date) • {{ $p->project_date }} @endif
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-2 md:col-span-3 rounded-3xl border border-zinc-800 bg-zinc-950/40 p-8 text-zinc-400">
                    Portofolio belum tersedia.
                </div>
            @endforelse
        </div>

        <a href="{{ route('portfolios.index') }}"
           class="sm:hidden inline-flex text-sm text-zinc-300 hover:text-white underline underline-offset-4">
            Lihat semua portofolio
        </a>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="space-y-6">
        <div data-reveal class="reveal">
            <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Testimoni</h2>
            <p class="mt-2 text-zinc-400">Beberapa feedback dari klien.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($testimonials ?? [] as $t)
                <div data-reveal class="reveal rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6 glow-hover">
                    <div class="flex items-start justify-between gap-4">
                        <p class="font-semibold">{{ $t->customer_name }}</p>
                        <p class="text-xs text-zinc-400">
                            {{ str_repeat('★', (int)($t->rating ?? 5)) }}{{ str_repeat('☆', 5 - (int)($t->rating ?? 5)) }}
                        </p>
                    </div>
                    <p class="mt-3 text-sm text-zinc-300 leading-relaxed">
                        “{{ $t->message }}”
                    </p>
                </div>
            @empty
                <div class="rounded-3xl border border-zinc-800 bg-zinc-950/40 p-8 text-zinc-400">
                    Testimoni belum tersedia.
                </div>
            @endforelse
        </div>
    </section>

    

</div>
@endsection
