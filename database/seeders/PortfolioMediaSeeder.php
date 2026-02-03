<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use App\Models\PortfolioMedia;

class PortfolioMediaSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Wedding Akad & Resepsi — Rizki & Aulia' => [
                ['type' => 'image', 'url' => '/images/dummy/wedding-1.jpg'],
                ['type' => 'image', 'url' => '/images/dummy/wedding-2.jpg'],
                [
                    'type' => 'video',
                    'url'  => '/storage/videos/wedding-cinematic-andi-sarah.mp4',
                ],
            ],
            'Wedding Outdoor — Fajar & Intan' => [
                ['type' => 'image', 'url' => '/images/dummy/wedding-2.jpg'],
            ],
            'Studio Wisuda — Universitas Teknologi Sumbawa' => [
                ['type' => 'image', 'url' => '/images/dummy/studio-1.jpg'],
                ['type' => 'image', 'url' => '/images/dummy/studio-2.jpg'],
            ],
            'Desain Konten Sosial Media UMKM' => [
                ['type' => 'image', 'url' => '/images/dummy/design-1.jpg'],
            ],

        ];

        foreach ($map as $portfolioTitle => $medias) {
            $portfolio = Portfolio::where('title', $portfolioTitle)->first();
            if (!$portfolio) continue;

            foreach ($medias as $m) {
                PortfolioMedia::create([
                    'portfolio_id' => $portfolio->id,
                    'media_type' => $m['type'],
                    'url' => $m['url'],
                ]);
            }
        }
    }
}
