<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->with(['packages' => fn($q) => $q->where('is_active', true)->orderBy('price')])
            ->orderBy('name')
            ->limit(3)
            ->get();

        $portfolios = Portfolio::query()
            ->where('is_published', true)
            ->with('media')
            ->latest('project_date')
            ->limit(6)
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->latest()
            ->limit(3)
            ->get();

        return view('home', compact('services', 'portfolios', 'testimonials'));
    }
}