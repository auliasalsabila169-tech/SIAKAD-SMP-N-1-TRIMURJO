<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $primaryKey = 'id_siswa';

    /**
     * Memungkinkan seluruh 94 atribut Buku Induk Siswa dapat diisi secara fleksibel
     */
    protected $guarded = [
        'id_siswa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'id_siswa');
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id', 'id_siswa');
    }
}

