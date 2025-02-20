<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {

        for ($i = 0; $i < 26; $i++) { 
            Kelas::create([
                'nama_kelas' => 'Kelas ' . chr(65 + $i), 
            ]);
        }
        
    }
}