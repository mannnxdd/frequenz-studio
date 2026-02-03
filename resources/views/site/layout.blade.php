<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Frequenz Studio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-zinc-100">

@php
    $isActive = fn($pattern) => request()->is($pattern) ? 'text-white' : 'text-zinc-300';
@endphp

<header
  x-data="{ scrolled:false, open:false }"
  x-init="
    const onScroll = () => scrolled = window.scrollY > 10;
    onScroll();
    window.addEventListener('scroll', onScroll, { passive:true });
  "
  class="sticky top-0 z-50 border-b border-zinc-800/80 bg-zinc-950/50 backdrop-blur supports-[backdrop-filter]:bg-zinc-950/40 transition-all"
  :class="scrolled ? 'py-3' : 'py-5'"
>
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between gap-4">

        {{-- LOGO --}}
        <a href="{{ url('/') }}"
        x-data="logoAnim()"
        x-init="init()"
        @mousemove="onMove($event)"
        @mouseleave="onLeave()"
        class="relative flex items-center gap-3 group select-none">

            {{-- Glow layer --}}
            <span
                class="absolute inset-0 rounded-xl opacity-0 blur-xl
                    bg-white/10 transition-opacity duration-300
                    group-hover:opacity-100">
            </span>

            {{-- Logo image --}}
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Frequenz Studio"
                class="relative h-8 w-auto
                    transition-all duration-300 ease-out
                    will-change-transform"
                :style="style"
            >
        </a>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex items-center gap-6 text-base font-medium">
            <a href="{{ route('home') }}"
               class="nav-link hover:text-white transition {{ request()->is('/') ? 'active text-white' : 'text-zinc-300' }}">
                Beranda
            </a>

            <a href="{{ route('services.index') }}"
               class="nav-link hover:text-white transition {{ request()->is('layanan*') ? 'active text-white' : 'text-zinc-300' }}">
                Layanan
            </a>

            <a href="{{ route('portfolios.index') }}"
               class="nav-link hover:text-white transition {{ request()->is('portofolio*') ? 'active text-white' : 'text-zinc-300' }}">
                Portofolio
            </a>

            <!-- <a href="{{ route('booking.create') }}"
               class="nav-link hover:text-white transition {{ request()->is('booking*') ? 'active text-white' : 'text-zinc-300' }}">
                Booking
            </a> -->

            <a href="{{ route('booking.check.form') }}"
               class="nav-link hover:text-white transition {{ request()->is('cek-booking*') ? 'active text-white' : 'text-zinc-300' }}">
                Cek Booking
            </a>
        </nav>

        {{-- DESKTOP CTA --}}
        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('booking.create') }}"
               class="btn-shine inline-flex items-center justify-center rounded-2xl bg-white px-5 py-2.5 font-semibold text-black hover:bg-zinc-200 transition">
                Booking
            </a>
        </div>

        {{-- MOBILE BUTTON --}}
        <button
            type="button"
            class="md:hidden inline-flex items-center justify-center rounded-xl border border-zinc-700 bg-black/20 px-3 py-2 text-zinc-100 hover:border-zinc-500 transition"
            @click="open = !open"
            :aria-expanded="open"
            aria-label="Toggle menu"
        >
            <span x-show="!open">☰</span>
            <span x-show="open" style="display:none;">✕</span>
        </button>
    </div>

    {{-- MOBILE MENU --}}
    <div
        class="md:hidden"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        style="display:none;"
        @click.outside="open = false"
    >
        <div class="max-w-6xl mx-auto px-6 pb-5 pt-4">
            <div class="rounded-3xl border border-zinc-800 bg-black/30 p-4 space-y-2">
                <a href="{{ route('home') }}"
                   class="block rounded-2xl px-4 py-3 font-medium {{ request()->is('/') ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5 hover:text-white' }}"
                   @click="open=false">
                    Beranda
                </a>

                <a href="{{ route('services.index') }}"
                   class="block rounded-2xl px-4 py-3 font-medium {{ request()->is('layanan*') ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5 hover:text-white' }}"
                   @click="open=false">
                    Layanan
                </a>

                <a href="{{ route('portfolios.index') }}"
                   class="block rounded-2xl px-4 py-3 font-medium {{ request()->is('portofolio*') ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5 hover:text-white' }}"
                   @click="open=false">
                    Portofolio
                </a>

                <!-- <a href="{{ route('booking.create') }}"
                   class="block rounded-2xl px-4 py-3 font-medium {{ request()->is('booking*') ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5 hover:text-white' }}"
                   @click="open=false">
                    Booking
                </a> -->

                <a href="{{ route('booking.check.form') }}"
                   class="block rounded-2xl px-4 py-3 font-medium {{ request()->is('cek-booking*') ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5 hover:text-white' }}"
                   @click="open=false">
                    Cek Booking
                </a>

                <a href="{{ route('booking.create') }}"
                   class="btn-shine mt-2 inline-flex w-full items-center justify-center rounded-2xl bg-white px-5 py-3 font-semibold text-black hover:bg-zinc-200 transition"
                   @click="open=false">
                    Booking Sekarang
                </a>
            </div>
        </div>
    </div>
</header>


<main class="max-w-6xl mx-auto px-6 py-10">
    @yield('content')
</main>

{{-- reveal on scroll (kalau kamu pakai) --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('[data-reveal]');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('reveal-in'); });
  }, { threshold: 0.12 });
  els.forEach(el => io.observe(el));
});
</script>

</body>
</html>
