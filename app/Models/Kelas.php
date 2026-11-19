<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'guru_id',
        'is_acc_tu',
    ];

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id', 'id_kelas');
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_id', 'id_kelas');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id_kelas');
    }
}

