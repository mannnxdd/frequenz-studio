<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use App\Models\Service;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $wedding = Service::where('name', 'Wedding Photo & Video')->first();
        $studio  = Service::where('name', 'Studio Photo Session')->first();
        $design  = Service::where('name', 'Desain Grafis')->first();

        $items = [
            [
                'service' => $wedding,
                'title' => 'Wedding Akad & Resepsi — Rizki & Aulia',
                'description' => 'Dokumentasi akad dan resepsi dengan konsep cinematic dan natural.',
                'project_date' => '2025-01-20',
            ],
            [
                'service' => $wedding,
                'title' => 'Wedding Outdoor — Fajar & Intan',
                'description' => 'Sesi wedding outdoor dengan nuansa hangat dan intimate.',
                'project_date' => '2025-02-10',
            ],
            [
                'service' => $studio,
                'title' => 'Studio Wisuda — Universitas Teknologi Sumbawa',
                'description' => 'Sesi foto wisuda studio dengan lighting clean dan elegan.',
                'project_date' => '2025-03-05',
            ],
            [
                'service' => $design,
                'title' => 'Desain Konten Sosial Media UMKM',
                'description' => 'Desain feed Instagram untuk kebutuhan branding UMKM lokal.',
                'project_date' => '2025-03-18',
            ],
        ];

        foreach ($items as $item) {
            if (!$item['service']) continue;

            Portfolio::create([
                'service_id' => $item['service']->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'project_date' => $item['project_date'],
                'is_published' => true,
            ]);
        }
    }
}
