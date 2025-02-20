<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $siswaList = $data['siswa_list'] ?? [];
        
        $absensiRecords = [];
        
        foreach ($siswaList as $siswa) {
            $absensi = new \App\Models\Absensi([
                'user_id' => $siswa['user_id'],
                'kelas_id' => $data['kelas_id'],
                'pertemuan_id' => $data['pertemuan_id'],
                'status' => $siswa['status']
            ]);
            
            $absensi->save();
            $absensiRecords[] = $absensi;
        }
        
        return $absensiRecords[0] ?? new \App\Models\Absensi();
    }
}