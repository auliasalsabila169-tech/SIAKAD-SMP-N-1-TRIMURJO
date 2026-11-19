<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'tahun_ajaran_id',
        'semester',
        'nilai_pengetahuan',
        'nilai_keterampilan',
        'nilai_sikap',
        'nilai_akhir',
        'deskripsi',
        'is_acc_tu',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id_jadwal');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }
}

