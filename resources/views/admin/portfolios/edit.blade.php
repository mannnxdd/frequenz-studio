@extends('admin.layouts.app')
@section('title','Admin - Edit Portofolio')

@section('content')
<a href="{{ route('admin.portfolios.index') }}" class="text-sm underline text-zinc-300 hover:text-white">← Kembali</a>

<div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
  <div class="lg:col-span-2 rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6">
    <h1 class="text-xl font-semibold">Edit Portofolio</h1>

    <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}">
      @csrf
      @method('PUT')

      <div>
        <label class="text-sm text-zinc-300">Layanan</label>
        <select name="service_id" class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
          @foreach($services as $s)
            <option value="{{ $s->id }}" @selected(old('service_id', $portfolio->service_id)==$s->id)>{{ $s->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-sm text-zinc-300">Judul</label>
        <input name="title" value="{{ old('title', $portfolio->title) }}"
          class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
      </div>

      <div>
        <label class="text-sm text-zinc-300">Deskripsi</label>
        <textarea name="description" rows="4"
          class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">{{ old('description', $portfolio->description) }}</textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-sm text-zinc-300">Tanggal Project</label>
          <input type="date" name="project_date" value="{{ old('project_date', $portfolio->project_date) }}"
            class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
        </div>
        <div class="flex items-center gap-2 mt-6">
          <input id="pub" type="checkbox" name="is_published" value="1"
                 class="rounded border-zinc-700 bg-black"
                 @checked(old('is_published', $portfolio->is_published))>
          <label for="pub" class="text-sm text-zinc-300">Publish</label>
        </div>
      </div>

      <button class="px-6 py-2.5 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">
        Simpan
      </button>
    </form>

    <form class="mt-6" method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}"
          onsubmit="return confirm('Yakin hapus portofolio ini?')">
      @csrf
      @method('DELETE')
      <button class="text-sm text-red-300 hover:text-red-200 underline">Hapus portofolio</button>
    </form>
  </div>

  <div class="rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6">
    <h2 class="text-lg font-semibold">Media</h2>

    <form class="mt-4 space-y-3" method="POST" action="{{ route('admin.portfolios.media.store', $portfolio) }}" enctype="multipart/form-data">
      @csrf
      <select name="media_type" class="w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
        <option value="image">Image (jpg/png/webp)</option>
        <option value="video">Video (mp4)</option>
      </select>

      <input type="file" name="file" class="w-full text-sm text-zinc-300">

      <button class="w-full px-5 py-2.5 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">
        Upload
      </button>

      <p class="text-xs text-zinc-500">Image max 5MB, Video max 50MB.</p>
    </form>

    <div class="mt-6 space-y-3">
      @foreach($portfolio->media as $m)
        <div class="flex items-center justify-between gap-3 rounded-2xl border border-zinc-800 bg-black/40 p-3">
          <div class="min-w-0">
            <p class="text-sm font-medium">{{ $m->media_type }}</p>
            <p class="text-xs text-zinc-500 truncate">{{ $m->url }}</p>
          </div>

          <form method="POST" action="{{ route('admin.portfolios.media.destroy', [$portfolio, $m]) }}"
                onsubmit="return confirm('Hapus media ini?')">
            @csrf
            @method('DELETE')
            <button class="text-xs text-red-300 hover:text-red-200 underline">Hapus</button>
          </form>
        </div>
      @endforeach
      @if($portfolio->media->isEmpty())
        <p class="text-sm text-zinc-500">Belum ada media.</p>
      @endif
    </div>
  </div>
</div>
@endsection
