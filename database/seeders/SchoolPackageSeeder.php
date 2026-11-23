<?php

namespace Database\Seeders;

use App\Models\SchoolPackage;
use Illuminate\Database\Seeder;

class SchoolPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // data contoh, sesuaikan dengan harga resmi
        $packages = [
            ['name' => 'Paket Fun Learning TK/PAUD', 'price' => 45000],
            ['name' => 'Paket Field Trip SD', 'price' => 50000],
            ['name' => 'Paket Outing SMP/SMA', 'price' => 55000],
        ];

        foreach ($packages as $package) {
            SchoolPackage::updateOrCreate(
                ['name' => $package['name']],
                [
                    'description' => 'Termasuk tiket masuk, akses playground dan mini zoo. Minimal 20 peserta, 1 guru pendamping gratis per 10 siswa (data contoh).',
                    'price_per_participant' => $package['price'],
                    'min_participants' => 20,
                    'is_active' => true,
                ],
            );
        }
    }
}
