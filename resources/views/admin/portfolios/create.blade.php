@extends('admin.layouts.app')
@section('title','Admin - Tambah Portofolio')

@section('content')
<a href="{{ route('admin.portfolios.index') }}" class="text-sm underline text-zinc-300 hover:text-white">← Kembali</a>

<div class="mt-4 rounded-3xl border border-zinc-800 bg-zinc-950/40 p-6">
  <h1 class="text-xl font-semibold">Tambah Portofolio</h1>

  <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.portfolios.store') }}">
    @csrf

    <div>
      <label class="text-sm text-zinc-300">Layanan</label>
      <select name="service_id" class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
        @foreach($services as $s)
          <option value="{{ $s->id }}" @selected(old('service_id')==$s->id)>{{ $s->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm text-zinc-300">Judul</label>
      <input name="title" value="{{ old('title') }}"
        class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
    </div>

    <div>
      <label class="text-sm text-zinc-300">Deskripsi</label>
      <textarea name="description" rows="4"
        class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="text-sm text-zinc-300">Tanggal Project</label>
        <input type="date" name="project_date" value="{{ old('project_date') }}"
          class="mt-1 w-full rounded-xl border border-zinc-800 bg-black px-4 py-2 text-zinc-100">
      </div>
      <div class="flex items-center gap-2 mt-6">
        <input id="pub" type="checkbox" name="is_published" value="1" class="rounded border-zinc-700 bg-black">
        <label for="pub" class="text-sm text-zinc-300">Publish</label>
      </div>
    </div>

    <button class="px-6 py-2.5 rounded-xl bg-white text-black font-semibold hover:bg-zinc-200">
      Simpan
    </button>
  </form>
</div>
@endsection
