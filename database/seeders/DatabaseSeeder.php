<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@nicepark.test',
        ], [
            'name' => 'Admin Nice Park',
            'password' => Hash::make('password'),
            'phone' => null,
        ]);
        $admin->forceFill(['role' => User::ROLE_ADMIN])->save();

        $customer = User::firstOrCreate([
            'email' => 'customer@nicepark.test',
        ], [
            'name' => 'Customer Nice Park',
            'password' => Hash::make('password'),
            'phone' => null,
        ]);
        $customer->forceFill(['role' => User::ROLE_CUSTOMER])->save();

        $this->call([
            TicketSeeder::class,
            SchoolPackageSeeder::class,
        ]);
    }
}
