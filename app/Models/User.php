<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Gender;
use App\Enums\Role;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_handphone',
        'role',
        'password',
        'alamat',
        'gender',
        'foto_profile_path',
        'tempat_lahir',
        'tanggal_lahir',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === Role::ADMIN->value;
        }

        if ($panel->getId() === 'siswa') {
            return $this->role === Role::SISWA->value;
        }

        if ($panel->getId() === 'pengajar') {
            return $this->role === Role::PENGAJAR->value;
        }

        return false;
    }

    public function getFilamentName(): string
    {
        return $this->nama_lengkap ?? 'User';
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
