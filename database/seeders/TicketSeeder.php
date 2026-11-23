<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // data contoh, sesuaikan dengan harga resmi
        $tickets = [
            [
                'name' => 'Tiket Masuk Weekday',
                'description' => 'Akses bermain sepuasnya (playground, rainbow slide, mini zoo). Berlaku Senin–Jumat, buka 09.00–17.45.',
                'price' => 35000,
            ],
            [
                'name' => 'Tiket Masuk Weekend',
                'description' => 'Akses bermain sepuasnya (playground, rainbow slide, mini zoo). Berlaku Sabtu, Minggu, dan hari libur, buka 08.00–17.45.',
                'price' => 40000,
            ],
            [
                'name' => 'Tiket Anak (Balita)',
                'description' => 'Untuk anak usia 2–5 tahun, wajib didampingi orang dewasa.',
                'price' => 20000,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::updateOrCreate(
                ['name' => $ticket['name']],
                [
                    'description' => $ticket['description'],
                    'price' => $ticket['price'],
                    'is_active' => true,
                ],
            );
        }
    }
}
