<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPembelajaran extends Model
{
    protected $fillable = [
        'nama_pembelajaran',
        'materi',
        'kelas_id',
        'status'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function attachments()
    {
        return $this->morphMany(AttachmentMateri::class, 'attachmentable');
    }
}