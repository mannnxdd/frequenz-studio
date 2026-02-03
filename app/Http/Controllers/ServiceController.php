<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->with(['packages' => function ($q) {
                $q->where('is_active', true)->orderBy('price');
            }])
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services'));
    }
}
