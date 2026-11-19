<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'hari_id',
        'jam_id',
        'tahun_ajaran_id',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id', 'id_mata_pelajaran');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'hari_id', 'id_hari');
    }

    public function jamPelajaran()
    {
        return $this->belongsTo(JamPelajaran::class, 'jam_id', 'id_jam_pelajaran');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'jadwal_id', 'id_jadwal');
    }
}

