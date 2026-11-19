<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function kelasWali()
    {
        return $this->hasOne(Kelas::class, 'guru_id', 'id_guru');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'guru_id', 'id_guru');
    }
}

