<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $wedding = Service::where('name', 'Wedding Photo & Video')->first();
        $studio  = Service::where('name', 'Studio Photo Session')->first();
        $design  = Service::where('name', 'Desain Grafis')->first();

        if ($wedding) {
            $packages = [
                [
                    'service_id' => $wedding->id,
                    'name' => 'Wedding Basic',
                    'price' => 1500000,
                    'down_payment' => 300000,
                    'duration_minutes' => null,
                    'is_active' => true,
                ],
                [
                    'service_id' => $wedding->id,
                    'name' => 'Wedding Premium',
                    'price' => 3500000,
                    'down_payment' => 500000,
                    'duration_minutes' => null,
                    'is_active' => true,
                ],
            ];

            foreach ($packages as $p) {
                Package::updateOrCreate(
                    ['service_id' => $p['service_id'], 'name' => $p['name']],
                    $p
                );
            }
        }

        if ($studio) {
            $packages = [
                [
                    'service_id' => $studio->id,
                    'name' => 'Studio 30 Menit',
                    'price' => 150000,
                    'down_payment' => null,
                    'duration_minutes' => 30,
                    'is_active' => true,
                ],
                [
                    'service_id' => $studio->id,
                    'name' => 'Studio 60 Menit',
                    'price' => 250000,
                    'down_payment' => null,
                    'duration_minutes' => 60,
                    'is_active' => true,
                ],
            ];

            foreach ($packages as $p) {
                Package::updateOrCreate(
                    ['service_id' => $p['service_id'], 'name' => $p['name']],
                    $p
                );
            }
        }

        if ($design) {
            $packages = [
                [
                    'service_id' => $design->id,
                    'name' => 'Desain 1 Konten',
                    'price' => 50000,
                    'down_payment' => null,
                    'duration_minutes' => null,
                    'is_active' => true,
                ],
                [
                    'service_id' => $design->id,
                    'name' => 'Paket Bulanan 12 Konten',
                    'price' => 500000,
                    'down_payment' => 100000,
                    'duration_minutes' => null,
                    'is_active' => true,
                ],
            ];

            foreach ($packages as $p) {
                Package::updateOrCreate(
                    ['service_id' => $p['service_id'], 'name' => $p['name']],
                    $p
                );
            }
        }
    }
}
