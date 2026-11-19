<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Hari;
use App\Models\JamPelajaran;
use App\Models\TahunAjaran;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalasController extends Controller
{
    /**
     * Dapatkan kelas yang diampu oleh Wali Kelas yang sedang login
     */
    protected function getKelasWalas()
    {
        $user = Auth::user();
        if ($user->guru && $user->guru->kelasWali) {
            return $user->guru->kelasWali;
        }

        // Fallback untuk demo jika user tidak terikat spesifik
        return Kelas::first();
    }

    /**
     * Dashboard Wali Kelas
     */
    public function dashboard()
    {
        $kelas = $this->getKelasWalas();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $siswas = Siswa::where('kelas_id', $kelas?->id_kelas)->orderBy('nama')->get();
        
        // Walas mengecek seluruh jadwal kelas binaannya
        $jadwals = Jadwal::with('mataPelajaran', 'guru', 'hari', 'jamPelajaran')
            ->where('kelas_id', $kelas?->id_kelas)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        // Radar Monitoring Keterisian Nilai dari Seluruh Guru Mata Pelajaran
        $mapelMonitoring = [];
        $uniqueJadwals = $jadwals->unique('mapel_id');
        $totalSiswa = $siswas->count();
        $totalMapelLengkap = 0;

        foreach ($uniqueJadwals as $j) {
            $nilaiCount = Nilai::where('jadwal_id', $j->id_jadwal)
                ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
                ->where('nilai_akhir', '>', 0)
                ->count();

            $isLengkap = ($totalSiswa > 0 && $nilaiCount >= $totalSiswa);
            if ($isLengkap) {
                $totalMapelLengkap++;
            }

            $mapelMonitoring[] = [
                'id_jadwal' => $j->id_jadwal,
                'mapel' => $j->mataPelajaran->nama_mapel ?? '-',
                'kode' => $j->mataPelajaran->kode_mapel ?? '-',
                'guru' => $j->guru->nama_guru ?? 'Belum Ditentukan',
                'nip' => $j->guru->nip ?? '-',
                'sudah_dinilai' => $nilaiCount,
                'total_siswa' => $totalSiswa,
                'is_lengkap' => $isLengkap,
                'persen' => $totalSiswa > 0 ? round(($nilaiCount / $totalSiswa) * 100) : 0,
            ];
        }

        // Statistik Gender Siswa Kelas Binaan
        $siswaLaki = $siswas->where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = $siswas->where('jenis_kelamin', 'P')->count();

        return view('walas.dashboard', compact(
            'kelas', 
            'tahunAktif', 
            'siswas', 
            'jadwals',
            'mapelMonitoring',
            'totalMapelLengkap',
            'siswaLaki',
            'siswaPerempuan'
        ));
    }

    /**
     * Pengecekan Jadwal Pelajaran Kelas oleh Wali Kelas (Read-Only)
     */
    public function jadwalIndex()
    {
        $kelas = $this->getKelasWalas();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $jadwals = Jadwal::with('mataPelajaran', 'guru', 'hari', 'jamPelajaran')
            ->where('kelas_id', $kelas?->id_kelas)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        return view('walas.jadwal.index', compact('kelas', 'tahunAktif', 'jadwals'));
    }

    /**
     * MEREKAP SEMUA NILAI DARI GURU MATA PELAJARAN (Leger Nilai Kelas)
     */
    public function cetakLeger()
    {
        $kelas = $this->getKelasWalas();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        // Ambil seluruh siswa di kelas binaan ini
        $siswas = Siswa::where('kelas_id', $kelas?->id_kelas)->orderBy('nama')->get();

        // Ambil semua mapel yang diajarkan di kelas ini
        $jadwals = Jadwal::with('mataPelajaran', 'guru')
            ->where('kelas_id', $kelas?->id_kelas)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get()
            ->unique('mapel_id');

        // Buat matriks rekapan nilai dari setiap guru mapel
        $rekapNilai = [];
        $totalNilaiSiswa = [];

        foreach ($siswas as $siswa) {
            $total = 0;
            $count = 0;

            foreach ($jadwals as $j) {
                $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
                    ->where('jadwal_id', $j->id_jadwal)
                    ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
                    ->first();

                $rekapNilai[$siswa->id_siswa][$j->mapel_id] = $nilai;

                if ($nilai && $nilai->nilai_akhir > 0) {
                    $total += $nilai->nilai_akhir;
                    $count++;
                }
            }

            $totalNilaiSiswa[$siswa->id_siswa] = [
                'total' => $total,
                'rata_rata' => $count > 0 ? round($total / $count, 2) : 0,
            ];
        }

        return view('walas.leger.cetak', compact(
            'kelas',
            'tahunAktif',
            'siswas',
            'jadwals',
            'rekapNilai',
            'totalNilaiSiswa'
        ));
    }

    /**
     * TAMPILAN INTERAKTIF REKAP SEMUA NILAI KELAS DARI GURU MAPEL
     */
    public function nilaiIndex()
    {
        $kelas = $this->getKelasWalas();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $siswas = Siswa::where('kelas_id', $kelas?->id_kelas)->orderBy('nama')->get();

        $jadwals = Jadwal::with('mataPelajaran', 'guru')
            ->where('kelas_id', $kelas?->id_kelas)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get()
            ->unique('mapel_id');

        $rekapNilai = [];
        $totalNilaiSiswa = [];

        foreach ($siswas as $siswa) {
            $total = 0;
            $count = 0;

            foreach ($jadwals as $j) {
                $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
                    ->where('jadwal_id', $j->id_jadwal)
                    ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
                    ->first();

                $rekapNilai[$siswa->id_siswa][$j->mapel_id] = $nilai;

                if ($nilai && $nilai->nilai_akhir > 0) {
                    $total += $nilai->nilai_akhir;
                    $count++;
                }
            }

            $totalNilaiSiswa[$siswa->id_siswa] = [
                'total' => $total,
                'rata_rata' => $count > 0 ? round($total / $count, 2) : 0,
            ];
        }

        return view('walas.nilai.index', compact(
            'kelas',
            'tahunAktif',
            'siswas',
            'jadwals',
            'rekapNilai',
            'totalNilaiSiswa'
        ));
    }
}
