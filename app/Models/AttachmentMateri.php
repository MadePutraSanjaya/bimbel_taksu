<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentMateri extends Model
{
    protected $table = 'attachment_materi';

    use HasFactory;

    protected $fillable = [
        'name',
        'path',
    ];

    protected $guarded = [];
}
