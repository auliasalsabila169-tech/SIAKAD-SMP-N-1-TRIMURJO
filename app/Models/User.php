<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke profil Guru (jika user adalah Guru / Wali Kelas)
     */
    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke profil Siswa (jika user adalah Siswa)
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id_user');
    }
}
