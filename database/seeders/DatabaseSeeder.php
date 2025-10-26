<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan seeder UserSeeder
        $this->call([
            UserSeeder::class,
        ]);
    }
}
