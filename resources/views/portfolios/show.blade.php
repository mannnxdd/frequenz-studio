@extends('site.layout')

@section('title', $portfolio->title . ' - Portofolio')

@section('content')
@php
  $media = $portfolio->media;
@endphp

<div class="space-y-8" x-data="lightbox()">

    {{-- Header --}}
    <div data-reveal class="reveal">
        <a href="{{ route('portfolios.index') }}"
           class="text-sm text-zinc-300 hover:text-white underline underline-offset-4">
            ← Kembali ke Portofolio
        </a>

        <h1 class="mt-4 text-3xl md:text-4xl font-bold tracking-tight">
            {{ $portfolio->title }}
        </h1>

        <p class="text-zinc-400 mt-2">
            {{ $portfolio->service?->name ?? 'Frequenz Studio' }}
            @if($portfolio->project_date) • {{ $portfolio->project_date }} @endif
        </p>

        @if($portfolio->description)
            <p class="text-zinc-300 mt-4 max-w-3xl leading-relaxed">
                {{ $portfolio->description }}
            </p>
        @endif
    </div>

    {{-- Cover --}}
    @if($cover?->url)
        <div data-reveal class="reveal overflow-hidden rounded-3xl border border-zinc-800 bg-black glow-hover">
            <img src="{{ $cover->url }}" alt="{{ $portfolio->title }}"
                 class="w-full max-h-[520px] object-cover opacity-95">
        </div>
    @endif

    {{-- Gallery --}}
    <div data-reveal class="reveal">
        <h2 class="text-xl font-semibold">Galeri</h2>
        <p class="text-zinc-400 mt-1 text-sm">Klik media untuk melihat lebih besar.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($media as $m)
            @if($m->media_type === 'video')
                <button type="button"
                        data-reveal
                        class="reveal group overflow-hidden rounded-2xl border border-zinc-800 bg-black glow-hover text-left"
                        @click="open('{{ $m->url }}', 'video')">
                    <div class="relative aspect-[4/3]">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="px-3 py-1 rounded-full text-xs border border-zinc-700 text-zinc-200 bg-zinc-950/50">
                                Video
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                </button>
            @else
                <button type="button"
                        data-reveal
                        class="reveal group overflow-hidden rounded-2xl border border-zinc-800 bg-black glow-hover text-left"
                        @click="open('{{ $m->url }}', 'image')">
                    <div class="relative aspect-[4/3]">
                        <img src="{{ $m->url }}" alt="Media"
                             class="h-full w-full object-cover opacity-90 group-hover:opacity-100 transition">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                </button>
            @endif
        @empty
            <div class="col-span-2 md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-950/40 p-6 text-zinc-400">
                Belum ada media.
            </div>
        @endforelse
    </div>

    {{-- Lightbox Overlay --}}
    <div x-show="show" x-transition.opacity
         class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
         @keydown.escape.window="close()"
         style="display:none;">
        <div class="relative w-full max-w-5xl">
            <button type="button"
                    class="absolute -top-12 right-0 text-zinc-200 hover:text-white"
                    @click="close()">
                Tutup ✕
            </button>

            <template x-if="type === 'image'">
                <img :src="src" alt="Preview"
                     class="w-full max-h-[80vh] object-contain rounded-2xl border border-zinc-800 bg-black">
            </template>

            <template x-if="type === 'video'">
    <div class="w-full rounded-2xl border border-zinc-800 bg-black overflow-hidden">
        <video
            :src="src"
            class="w-full max-h-[80vh]"
            controls
            autoplay
            muted
            playsinline
        ></video>
    </div>
</template>

        </div>
    </div>

</div>

<script>
function lightbox(){
  return {
    show:false,
    src:'',
    type:'image',
    open(url, type){
      this.src = url;
      this.type = type;
      this.show = true;
      document.body.style.overflow = 'hidden';
    },
    close(){
      this.show = false;
      this.src = '';
      document.body.style.overflow = '';
    }
  }
}
</script>
@endsection
