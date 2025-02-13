<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'jadwal_hadir',
        'jadwal_pulang'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}