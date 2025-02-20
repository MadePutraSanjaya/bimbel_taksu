<?php

namespace Database\Seeders;

use App\Models\Pertemuan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PertemuanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            Pertemuan::create([
                'pertemuan_ke' => $i,
            ]);
        }
    }
}