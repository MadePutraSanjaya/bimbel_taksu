<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'kelas_id',
        'user_id',
        'jumlah_hadir',
        'jumlah_alpha',
        'status'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}