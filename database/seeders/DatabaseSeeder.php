<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bus;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user'
        ]);

        Website::create([
            'nomor_admin' => ['08123123123', '081231232'],
            'nomor_rekening' => ['Sigit 33201231231823 BRI', 'Wahyu 91231231762 BCA'],
            'sosial_media' => ['instagram @wahyupanambang']
        ]);

        Bus::factory()->count(20)->create();
    }
}
