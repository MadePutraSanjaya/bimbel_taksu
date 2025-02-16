<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'mata_pembelajaran_id',
        'siswa_id',
        'catatan',
        'nilai'
    ];

    public function mataPembelajaran()
    {
        return $this->belongsTo(MataPembelajaran::class, 'mata_pembelajaran_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

}