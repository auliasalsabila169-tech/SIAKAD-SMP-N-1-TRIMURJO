<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jam_pelajaran';
    protected $primaryKey = 'id_jam_pelajaran';
    public $timestamps = false;

    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'urutan',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'jam_id', 'id_jam_pelajaran');
    }
}

