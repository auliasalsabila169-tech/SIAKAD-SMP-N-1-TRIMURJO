<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id_tahun_ajaran';

    protected $fillable = [
        'tahun',
        'semester_aktif',
        'is_active',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }
}

