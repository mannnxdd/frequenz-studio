<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $serviceId = $request->query('service_id');

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $query = Portfolio::query()
            ->where('is_published', true)
            ->with(['service', 'media'])
            ->orderByRaw("project_date IS NULL, project_date DESC")
            ->latest();

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        $portfolios = $query->paginate(12)->withQueryString();

        return view('portfolios.index', compact('services', 'portfolios', 'serviceId'));
    }

    public function show(Portfolio $portfolio)
    {
        abort_unless($portfolio->is_published, 404);

        $portfolio->load(['service', 'media']);

        $cover = $portfolio->media->first();
        return view('portfolios.show', compact('portfolio', 'cover'));
    }
}
