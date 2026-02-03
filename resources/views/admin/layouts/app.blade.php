<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin - Frequenz Studio')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-black text-zinc-100">
  <header class="bg-zinc-950/70 backdrop-blur border-b border-zinc-800">
    <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
      <a href="{{ route('admin.dashboard') }}" class="font-semibold tracking-wide">Admin Panel</a>

      <nav class="flex items-center gap-6 text-sm md:text-base text-zinc-300 font-medium">
        <a href="{{ route('admin.bookings.index') }}" class="hover:text-white">Booking</a>
        <a href="{{ route('admin.portfolios.index') }}" class="hover:text-white">Portofolio</a>
        <a href="{{ route('home') }}" class="hover:text-white" target="_blank">Lihat Website</a>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-6 py-8">
    @if(session('success'))
      <div class="mb-6 rounded-2xl border border-emerald-800 bg-emerald-950/40 p-4 text-emerald-200">
        {{ session('success') }}
      </div>
    @endif
    @if($errors->any())
      <div class="mb-6 rounded-2xl border border-red-800 bg-red-950/40 p-4 text-red-200">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
