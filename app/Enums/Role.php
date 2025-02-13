<?php

namespace App\Enums;

enum Role: string
{
    case SISWA = 'SISWA';
    case PENGAJAR = 'PENGAJAR';
    case ADMIN = 'ADMIN';
}
