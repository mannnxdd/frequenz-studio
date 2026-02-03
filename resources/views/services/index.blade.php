@extends('site.layout')

@section('title', 'Layanan & Paket - Frequenz Studio')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Layanan & Paket</h1>
    <p class="text-zinc-400 mt-2">Pilih layanan dan paket yang sesuai kebutuhanmu.</p>
</div>

<div class="space-y-6">
    @forelse($services as $service)
        <div data-reveal class="reveal rounded-2xl border border-zinc-800 bg-zinc-950/40 p-6 shadow-sm glow-hover">
            <h2 class="text-xl font-semibold">{{ $service->name }}</h2>
            @if($service->description)
                <p class="text-zinc-400 mt-2">{{ $service->description }}</p>
            @endif

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($service->packages as $package)
                    <div data-reveal class="reveal rounded-2xl border border-zinc-800 bg-black p-5 glow-hover">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-zinc-100">{{ $package->name }}</h3>
                                @if($package->duration_minutes)
                                    <p class="text-sm text-zinc-400 mt-1">Durasi: {{ $package->duration_minutes }} menit</p>
                                @endif
                                @if(!is_null($package->down_payment))
                                    <p class="text-sm text-zinc-400 mt-1">DP mulai: Rp {{ number_format($package->down_payment, 0, ',', '.') }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-zinc-500">per paket</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a
                            x-data="{down:false}"
                            @mousedown="down=true" @mouseup="down=false" @mouseleave="down=false"
                            :class="down ? 'scale-[0.98]' : 'scale-100'"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white text-black text-sm font-medium hover:bg-zinc-200 transition transform"
                            href="{{ url('/booking?package_id=' . $package->id) }}"
                            >
                            Booking Paket Ini
                            </a>

                        </div>
                    </div>
                @empty
                    <p class="text-zinc-500">Belum ada paket untuk layanan ini.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="rounded-2xl border border-zinc-800 bg-zinc-950/40 p-6">
            <p class="text-zinc-400">Belum ada layanan.</p>
        </div>
    @endforelse
</div>
@endsection
