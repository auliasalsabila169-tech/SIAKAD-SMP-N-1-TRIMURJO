<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    protected function getGuruUser()
    {
        return Auth::user()->guru ?? Guru::first();
    }

    /**
     * Dashboard Guru: Menampilkan jadwal mengajar & beban penilaian mapel
     */
    public function dashboard()
    {
        $guru = $this->getGuruUser();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $jadwals = Jadwal::with('mataPelajaran', 'kelas.siswas', 'hari', 'jamPelajaran')
            ->where('guru_id', $guru?->id_guru)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        // Hitung progres penginputan nilai untuk setiap kelas KBM yang diampu guru
        $progresPenilaian = [];
        $totalSiswaDiajar = 0;
        $totalSiswaSudahDinilai = 0;

        foreach ($jadwals as $j) {
            $totalSiswa = $j->kelas?->siswas ? $j->kelas->siswas->count() : 0;
            $totalSiswaDiajar += $totalSiswa;

            $sudahDinilai = Nilai::where('jadwal_id', $j->id_jadwal)
                ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
                ->where('nilai_akhir', '>', 0)
                ->count();
            
            $totalSiswaSudahDinilai += $sudahDinilai;

            $progresPenilaian[$j->id_jadwal] = [
                'total' => $totalSiswa,
                'dinilai' => $sudahDinilai,
                'persen' => $totalSiswa > 0 ? round(($sudahDinilai / $totalSiswa) * 100) : 0,
                'is_selesai' => ($totalSiswa > 0 && $sudahDinilai >= $totalSiswa),
            ];
        }

        $persenKeseluruhan = $totalSiswaDiajar > 0 ? round(($totalSiswaSudahDinilai / $totalSiswaDiajar) * 100) : 0;

        return view('guru.dashboard', compact(
            'guru', 
            'jadwals', 
            'tahunAktif', 
            'progresPenilaian',
            'totalSiswaDiajar',
            'totalSiswaSudahDinilai',
            'persenKeseluruhan'
        ));
    }

    /**
     * Daftar Kelas KBM untuk Input Nilai Siswa
     */
    public function nilaiIndex()
    {
        $guru = $this->getGuruUser();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $jadwals = Jadwal::with('mataPelajaran', 'kelas', 'hari', 'jamPelajaran')
            ->where('guru_id', $guru?->id_guru)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get();

        return view('guru.nilai.index', compact('guru', 'jadwals', 'tahunAktif'));
    }

    /**
     * Tampilan Formulir Input Nilai Siswa per Jadwal KBM
     */
    public function inputNilai($jadwal_id)
    {
        $jadwal = Jadwal::with('mataPelajaran', 'kelas', 'tahunAjaran')->findOrFail($jadwal_id);
        $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->orderBy('nama')->get();

        // Ambil nilai yang sudah ada sebelumnya
        $existingNilai = Nilai::where('jadwal_id', $jadwal_id)
            ->where('tahun_ajaran_id', $jadwal->tahun_ajaran_id)
            ->get()
            ->keyBy('siswa_id');

        return view('guru.nilai.input', compact('jadwal', 'siswas', 'existingNilai'));
    }

    /**
     * Simpan / Perbarui Nilai Siswa
     */
    public function simpanNilai(Request $request, $jadwal_id)
    {
        $jadwal = Jadwal::findOrFail($jadwal_id);
        $nilaiData = $request->input('nilai', []);

        foreach ($nilaiData as $siswaId => $row) {
            $pengetahuan = (float)($row['pengetahuan'] ?? 0);
            $keterampilan = (float)($row['keterampilan'] ?? 0);
            $rawSikap = strtoupper(trim($row['sikap'] ?? 'B'));
            
            // Standardisasi nilai sikap ke predikat resmi A, B, C, D
            $sikap = match($rawSikap) {
                'SB', 'A' => 'A',
                'B'       => 'B',
                'C'       => 'C',
                'K', 'D'  => 'D',
                default   => 'B',
            };
            
            $deskripsi = $row['deskripsi'] ?? null;

            // Hitung nilai akhir otomatis: rata-rata pengetahuan & keterampilan
            $nilaiAkhir = round(($pengetahuan + $keterampilan) / 2, 2);

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'jadwal_id' => $jadwal->id_jadwal,
                    'tahun_ajaran_id' => $jadwal->tahun_ajaran_id,
                ],
                [
                    'semester' => $jadwal->tahunAjaran->semester_aktif ?? 'Ganjil',
                    'nilai_pengetahuan' => $pengetahuan,
                    'nilai_keterampilan' => $keterampilan,
                    'nilai_sikap' => $sikap,
                    'nilai_akhir' => $nilaiAkhir,
                    'deskripsi' => $deskripsi,
                ]
            );
        }

        return redirect()->route('guru.dashboard')->with('success', 'Nilai siswa berhasil disimpan dan tersinkronisasi ke leger akademik.');
    }
}

