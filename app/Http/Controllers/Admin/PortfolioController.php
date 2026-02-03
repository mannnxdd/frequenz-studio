<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioMedia;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $serviceId = $request->query('service_id');

        $services = Service::where('is_active', true)->orderBy('name')->get();

        $portfolios = Portfolio::query()
            ->with(['service','media'])
            ->when($serviceId, fn($q) => $q->where('service_id', $serviceId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.portfolios.index', compact('portfolios','services','serviceId'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.portfolios.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required','exists:services,id'],
            'title' => ['required','string','max:200'],
            'description' => ['nullable','string'],
            'project_date' => ['nullable','date'],
            'is_published' => ['nullable','boolean'],
        ]);

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        $portfolio = Portfolio::create($data);

        return redirect()->route('admin.portfolios.edit', $portfolio)
            ->with('success', 'Portofolio dibuat. Sekarang kamu bisa upload media.');
    }

    public function edit(Portfolio $portfolio)
    {
        $portfolio->load(['media','service']);
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.portfolios.edit', compact('portfolio','services'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $request->validate([
            'service_id' => ['required','exists:services,id'],
            'title' => ['required','string','max:200'],
            'description' => ['nullable','string'],
            'project_date' => ['nullable','date'],
            'is_published' => ['nullable','boolean'],
        ]);

        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $portfolio->update($data);

        return back()->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        // hapus file media juga
        $portfolio->load('media');
        foreach ($portfolio->media as $m) {
            $this->deleteIfStoredFile($m->url);
        }
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio dihapus.');
    }

    public function storeMedia(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'media_type' => ['required','in:image,video'],
            'file' => ['required','file',
                // image: jpg/png/webp ; video: mp4 (bisa kamu tambah)
            ],
        ]);

        $mediaType = $request->media_type;

        if ($mediaType === 'image') {
            $request->validate([
                'file' => ['image','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB
            ]);
            $path = $request->file('file')->store('portfolios/images', 'public');
        } else {
            $request->validate([
                'file' => ['mimes:mp4','max:51200'], // 50MB
            ]);
            $path = $request->file('file')->store('portfolios/videos', 'public');
        }

        PortfolioMedia::create([
            'portfolio_id' => $portfolio->id,
            'media_type' => $mediaType,
            'url' => '/storage/' . $path,
        ]);

        return back()->with('success', 'Media berhasil diupload.');
    }

    public function destroyMedia(Portfolio $portfolio, PortfolioMedia $media)
    {
        abort_unless($media->portfolio_id === $portfolio->id, 404);

        $this->deleteIfStoredFile($media->url);
        $media->delete();

        return back()->with('success', 'Media dihapus.');
    }

    private function deleteIfStoredFile(string $url): void
    {
        // url format: /storage/xxx/yyy.ext
        if (str_starts_with($url, '/storage/')) {
            $relative = str_replace('/storage/', '', $url);
            Storage::disk('public')->delete($relative);
        }
    }
}
