<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'mata_pembelajaran_id',
        'user_id',
        'kelas_id',
        'catatan',
        'nilai'
    ];

    public function mataPembelajaran()
    {
        return $this->belongsTo(MataPembelajaran::class, 'mata_pembelajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}