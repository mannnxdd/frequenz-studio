@extends('site.layout')

@section('title', 'Booking - Frequenz Studio')

@section('content')
<div class="max-w-4xl">

    {{-- HEADER --}}
    <div data-reveal class="reveal mb-10 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
                Booking Jasa
            </h1>
            <p class="text-zinc-400 mt-2 max-w-xl">
                Silahkan mengisi form dibawah ini
            </p>
        </div>

        <a href="{{ route('booking.check.form') }}"
           class="text-sm text-zinc-300 hover:text-white underline underline-offset-4">
            Cek Booking
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div x-data="{show:true}" x-show="show" x-transition.duration.400ms
             class="mb-6 rounded-2xl border border-emerald-800 bg-emerald-950/40 p-5 text-emerald-200">
            <div class="flex items-start justify-between gap-4">
                <p class="font-medium">
                    {{ session('success') }}
                </p>
                <button @click="show=false"
                        class="text-sm opacity-70 hover:opacity-100">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    {{-- WHATSAPP ADMIN --}}
    @if(session('wa_link'))
        <div class="mb-8 rounded-2xl border border-green-800 bg-green-950/40 p-5 text-green-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="font-medium">
                        Booking berhasil dikirim 🎉
                    </p>
                    <p class="text-sm text-green-300 mt-1">
                        Silakan klik tombol di samping untuk mengirim notifikasi ke admin via WhatsApp.
                    </p>
                </div>

                <a href="{{ session('wa_link') }}"
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2
                          rounded-xl bg-green-600 px-5 py-3
                          text-white font-semibold
                          hover:bg-green-500 transition">
                    Konfirmasi via WhatsApp
                </a>
            </div>
        </div>

        {{-- AUTO OPEN WHATSAPP (OPSIONAL) --}}
        <script>
            window.open("{{ session('wa_link') }}", "_blank");
        </script>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <div x-data="{show:true}" x-show="show" x-transition.duration.400ms
             class="mb-8 rounded-2xl border border-red-800 bg-red-950/40 p-5 text-red-200">
            <div class="flex items-start justify-between gap-4">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
                <button @click="show=false"
                        class="text-sm opacity-70 hover:opacity-100">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('booking.store') }}"
          data-reveal
          class="reveal glow-hover rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6 md:p-8 shadow-sm space-y-6">
        @csrf

        {{-- CUSTOMER INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Nama Lengkap
                </label>
                <input name="full_name"
                       value="{{ old('full_name') }}"
                       placeholder="Nama kamu"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 placeholder:text-zinc-600
                              focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>

            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Nomor WhatsApp
                </label>
                <input name="phone"
                       value="{{ old('phone') }}"
                       placeholder="08xxxxxxxxxx"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 placeholder:text-zinc-600
                              focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>

            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Email <span class="text-zinc-500">(opsional)</span>
                </label>
                <input name="email"
                       value="{{ old('email') }}"
                       placeholder="email@contoh.com"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 placeholder:text-zinc-600
                              focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
        </div>

        <div class="h-px bg-zinc-800"></div>

        {{-- SERVICE & PACKAGE --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Pilih Layanan
                </label>
                <select name="service_id"
                        class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                               text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    <option value="">-- pilih layanan --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                            @selected(old('service_id', $selectedPackage?->service_id) == $service->id)>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Pilih Paket <span class="text-zinc-500">(opsional)</span>
                </label>
                <select name="package_id"
                        class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                               text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    <option value="">-- custom / tanpa paket --</option>
                    @foreach($services as $service)
                        @foreach($service->packages as $pkg)
                            <option value="{{ $pkg->id }}"
                                @selected(old('package_id', $selectedPackage?->id) == $pkg->id)>
                                {{ $service->name }} — {{ $pkg->name }}
                                (Rp {{ number_format($pkg->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </div>

        {{-- DATE & TIME --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Tanggal
                </label>
                <input type="date"
                       name="event_date"
                       value="{{ old('event_date') }}"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>

            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Jam Mulai
                </label>
                <input type="time"
                       name="start_time"
                       value="{{ old('start_time') }}"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>

            <div>
                <label class="text-sm font-medium text-zinc-200">
                    Jam Selesai
                </label>
                <input type="time"
                       name="end_time"
                       value="{{ old('end_time') }}"
                       class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                              text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
        </div>

        {{-- LOCATION --}}
        <div>
            <label class="text-sm font-medium text-zinc-200">
                Lokasi <span class="text-zinc-500">(opsional)</span>
            </label>
            <textarea name="location"
                      rows="2"
                      placeholder="Alamat acara / studio / lokasi outdoor"
                      class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                             text-zinc-100 placeholder:text-zinc-600
                             focus:outline-none focus:ring-2 focus:ring-zinc-500">{{ old('location') }}</textarea>
        </div>

        {{-- BRIEF --}}
        <div>
            <label class="text-sm font-medium text-zinc-200">
                Brief / Request
            </label>
            <textarea name="brief"
                      rows="3"
                      placeholder="Contoh: konsep foto, referensi, kebutuhan desain, dll"
                      class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2.5
                             text-zinc-100 placeholder:text-zinc-600
                             focus:outline-none focus:ring-2 focus:ring-zinc-500">{{ old('brief') }}</textarea>
        </div>

        {{-- SUBMIT --}}
        <div class="pt-4 flex items-center gap-4">
            <button
                x-data="{down:false}"
                @mousedown="down=true" @mouseup="down=false" @mouseleave="down=false"
                :class="down ? 'scale-[0.97]' : 'scale-100'"
                class="inline-flex items-center justify-center
                       px-6 py-3 rounded-2xl
                       bg-white text-black font-semibold
                       transition transform hover:bg-zinc-200">
                Kirim Booking
            </button>

            <p class="text-xs text-zinc-500">
                Setelah mengisi form jangan lupa untuk konfirmasi ke Admin melalui WhatsApp.
            </p>
        </div>
    </form>
</div>
@endsection
