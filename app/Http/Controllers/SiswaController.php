<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    protected function getSiswaUser()
    {
        return Auth::user()->siswa ?? Siswa::first();
    }

    /**
     * Dashboard Mandiri Siswa
     */
    public function dashboard()
    {
        $siswa = $this->getSiswaUser();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        // Jadwal KBM kelas siswa
        $jadwals = Jadwal::with('mataPelajaran', 'guru', 'hari', 'jamPelajaran')
            ->where('kelas_id', $siswa?->kelas_id)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        // Nilai hasil belajar siswa
        $nilais = Nilai::with('jadwal.mataPelajaran', 'jadwal.guru')
            ->where('siswa_id', $siswa?->id_siswa)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        $rataRata = $nilais->avg('nilai_akhir') ?? 0;

        $isAccTu = false;
        if ($siswa && $siswa->kelas) {
            $isAccTu = ($siswa->kelas->is_acc_tu == 1);
        }

        return view('siswa.dashboard', compact('siswa', 'tahunAktif', 'jadwals', 'nilais', 'rataRata', 'isAccTu'));
    }
}

