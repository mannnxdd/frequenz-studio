<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Wedding Photo & Video',
                'description' => 'Layanan dokumentasi pernikahan foto dan video.',
                'is_active' => true,
            ],
            [
                'name' => 'Studio Photo Session',
                'description' => 'Foto di tempat (studio) untuk personal, keluarga, wisuda, dll.',
                'is_active' => true,
            ],
            [
                'name' => 'Desain Grafis',
                'description' => 'Desain untuk kebutuhan branding, promosi, konten sosial media, dll.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(
                ['name' => $s['name']],
                $s
            );
        }
    }
}
