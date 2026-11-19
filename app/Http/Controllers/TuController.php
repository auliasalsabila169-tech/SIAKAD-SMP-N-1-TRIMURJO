<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Jadwal;
use App\Models\Hari;
use App\Models\JamPelajaran;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TuController extends Controller
{
    /**
     * Dashboard Tata Usaha / Admin
     */
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalMapel = MataPelajaran::count();
        $totalJadwal = Jadwal::count();
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $siswas = Siswa::with('kelas')->latest()->take(10)->get();
        $gurus = Guru::with('kelasWali')->latest()->take(10)->get();

        // Data lengkap untuk modal interaktif
        $allSiswas = Siswa::with('kelas')->orderBy('nama')->get();
        $allGurus = Guru::with('kelasWali', 'user')->orderBy('nama_guru')->get();
        $allKelas = Kelas::with('waliKelas', 'siswas')->orderBy('nama_kelas')->get();
        $allMapels = MataPelajaran::orderBy('nama_mapel')->get();
        $allJadwals = Jadwal::with('kelas', 'mataPelajaran', 'guru', 'hari', 'jamPelajaran')->get();

        $haris = Hari::all();
        $jams = JamPelajaran::orderBy('urutan')->get();

        return view('tu.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalJadwal',
            'tahunAktif',
            'siswas',
            'gurus',
            'allSiswas',
            'allGurus',
            'allKelas',
            'allMapels',
            'allJadwals',
            'haris',
            'jams'
        ));
    }

    /**
     * Daftar Siswa (Standar Buku Induk)
     */
    public function siswaIndex()
    {
        $siswas = Siswa::with('kelas')->paginate(15);
        $kelasList = Kelas::all();
        return view('tu.siswa.index', compact('siswas', 'kelasList'));
    }

    /**
     * Simpan Siswa Baru
     */
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nisn' => 'required|unique:siswas,nisn',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'nullable|exists:kelas,id_kelas',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->nisn . '@siswa.smpn1trimurjo.sch.id',
                'password' => bcrypt($request->password ?? 'password'),
            ]);
            $user->assignRole('Siswa');

            $data = $request->except(['_token', 'password']);
            $data['user_id'] = $user->id_user;
            Siswa::create($data);
        });

        return back()->with('success', 'Data siswa berhasil ditambahkan dan akun login langsung dibuat.');
    }

    /**
     * Update Siswa
     */
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $id . ',id_siswa',
            'nisn' => 'required|unique:siswas,nisn,' . $id . ',id_siswa',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'nullable|exists:kelas,id_kelas',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $siswa->update($request->except(['_token', '_method']));

            if ($siswa->user) {
                $siswa->user->update([
                    'name' => $request->nama,
                    'email' => $request->nisn . '@siswa.smpn1trimurjo.sch.id',
                ]);
            }
        });

        return back()->with('success', 'Data siswa ' . $siswa->nama . ' berhasil diperbarui.');
    }

    /**
     * Hapus Siswa
     */
    public function siswaDestroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $nama = $siswa->nama;

        DB::transaction(function () use ($siswa) {
            if ($siswa->user) {
                $siswa->user->delete();
            }
            $siswa->delete();
        });

        return back()->with('success', 'Data siswa ' . $nama . ' berhasil dihapus.');
    }

    /**
     * Daftar Guru
     */
    public function guruIndex()
    {
        $gurus = Guru::with('user', 'kelasWali')->paginate(15);
        return view('tu.guru.index', compact('gurus'));
    }

    /**
     * Simpan Guru Baru
     */
    public function guruStore(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:users,email',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama_guru,
                'email' => $request->email,
                'password' => bcrypt($request->password ?? 'password'),
            ]);
            $user->assignRole('Guru');

            Guru::create([
                'user_id' => $user->id_user,
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return back()->with('success', 'Data guru dan akun login berhasil ditambahkan.');
    }

    /**
     * Update Guru
     */
    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $id . ',id_guru',
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:users,email,' . ($guru->user_id ?? 0) . ',id_user',
        ]);

        DB::transaction(function () use ($request, $guru) {
            $guru->update([
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            if ($guru->user) {
                $guru->user->update([
                    'name' => $request->nama_guru,
                    'email' => $request->email,
                ]);
            }
        });

        return back()->with('success', 'Data guru ' . $guru->nama_guru . ' berhasil diperbarui.');
    }

    /**
     * Hapus Guru
     */
    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);
        $nama = $guru->nama_guru;

        DB::transaction(function () use ($guru) {
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();
        });

        return back()->with('success', 'Data guru ' . $nama . ' berhasil dihapus.');
    }

    /**
     * Kelola Kelas
     */
    public function kelasIndex()
    {
        $kelasList = Kelas::with('waliKelas', 'siswas')->get();
        $gurus = Guru::all();
        return view('tu.kelas.index', compact('kelasList', 'gurus'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|string|max:10',
            'guru_id' => 'nullable|exists:guru,id_guru',
        ]);

        $kelas = Kelas::create($request->all());

        if ($request->guru_id) {
            $guru = Guru::find($request->guru_id);
            if ($guru && $guru->user) {
                $guru->user->assignRole('Wali Kelas');
            }
        }

        return back()->with('success', 'Data rombel kelas berhasil ditambahkan.');
    }

    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|string|max:10',
            'guru_id' => 'nullable|exists:guru,id_guru',
        ]);

        $kelas->update($request->all());

        if ($request->guru_id) {
            $guru = Guru::find($request->guru_id);
            if ($guru && $guru->user) {
                $guru->user->assignRole('Wali Kelas');
            }
        }

        return back()->with('success', 'Data rombel kelas ' . $kelas->nama_kelas . ' berhasil diperbarui.');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $nama = $kelas->nama_kelas;
        $kelas->delete();

        return back()->with('success', 'Data rombel kelas ' . $nama . ' berhasil dihapus.');
    }

    /**
     * ========================================================
     * MANAJEMEN JADWAL PELAJARAN (HANYA TATA USAHA YANG MEMBUAT)
     * ========================================================
     */
    public function jadwalIndex(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $query = Jadwal::with('kelas', 'mataPelajaran', 'guru', 'hari', 'jamPelajaran')
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $jadwals = $query->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapels = MataPelajaran::orderBy('nama_mapel')->get();
        $gurus = Guru::orderBy('nama_guru')->get();
        $haris = Hari::all();
        $jams = JamPelajaran::orderBy('urutan')->get();

        return view('tu.jadwal.index', compact(
            'jadwals',
            'kelasList',
            'mapels',
            'gurus',
            'haris',
            'jams',
            'tahunAktif',
            'kelasId'
        ));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id_kelas',
            'mapel_id' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'guru_id' => 'required|exists:guru,id_guru',
            'hari_id' => 'required|exists:hari,id_hari',
            'jam_id' => 'required|exists:jam_pelajaran,id_jam_pelajaran',
        ]);

        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        Jadwal::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'hari_id' => $request->hari_id,
            'jam_id' => $request->jam_id,
            'tahun_ajaran_id' => $tahunAktif?->id_tahun_ajaran ?? 1,
        ]);

        return back()->with('success', 'Jadwal KBM kelas berhasil diterbitkan oleh Tata Usaha.');
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id_kelas',
            'mapel_id' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'guru_id' => 'required|exists:guru,id_guru',
            'hari_id' => 'required|exists:hari,id_hari',
            'jam_id' => 'required|exists:jam_pelajaran,id_jam_pelajaran',
        ]);

        $jadwal->update($request->all());

        return back()->with('success', 'Jadwal KBM berhasil diperbarui.');
    }

    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal KBM berhasil dihapus.');
    }

    /**
     * ========================================================
     * AKSES REKAPITULASI SEMUA NILAI SETIAP KELAS OLEH TU
     * ========================================================
     */
    public function nilaiIndex(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $selectedKelasId = $request->get('kelas_id', $kelasList->first()?->id_kelas);
        $kelas = Kelas::find($selectedKelasId);

        $tahunAktif = TahunAjaran::where('is_active', 1)->first() ?? TahunAjaran::first();

        $siswas = $kelas ? Siswa::where('kelas_id', $kelas->id_kelas)->orderBy('nama')->get() : collect();

        $jadwals = $kelas ? Jadwal::with('mataPelajaran', 'guru')
            ->where('kelas_id', $kelas->id_kelas)
            ->where('tahun_ajaran_id', $tahunAktif?->id_tahun_ajaran)
            ->get()
            ->unique('mapel_id') : collect();

        // Buat matriks nilai lengkap [siswa_id][mapel_id]
        $rekapNilai = [];
        $ringkasanSiswa = [];

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

            $ringkasanSiswa[$siswa->id_siswa] = [
                'total' => $total,
                'rata_rata' => $count > 0 ? round($total / $count, 2) : 0,
            ];
        }

        return view('tu.nilai.index', compact(
            'kelasList',
            'selectedKelasId',
            'kelas',
            'tahunAktif',
            'siswas',
            'jadwals',
            'rekapNilai',
            'ringkasanSiswa'
        ));
    }

    /**
     * Persetujuan (ACC) / Publikasi Nilai Rapor oleh Tata Usaha
     */
    public function toggleAccKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->is_acc_tu = $kelas->is_acc_tu ? 0 : 1;
        $kelas->save();

        // Update seluruh nilai siswa di kelas ini sesuai status ACC TU
        $siswaIds = Siswa::where('kelas_id', $kelas->id_kelas)->pluck('id_siswa');
        Nilai::whereIn('siswa_id', $siswaIds)->update(['is_acc_tu' => $kelas->is_acc_tu]);

        $statusMsg = $kelas->is_acc_tu ? 'berhasil DI-ACC & DIPUBLIKASIKAN ke siswa' : 'status ACC berhasil dibatalkan (dikunci kembali)';
        return back()->with('success', "Nilai rapor kelas {$kelas->nama_kelas} {$statusMsg}.");
    }

    /**
     * Kelola Mata Pelajaran (Kurikulum)
     */
    public function mapelStore(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
            'kkm' => 'required|numeric|min:0|max:100',
        ]);

        MataPelajaran::create($request->all());

        return back()->with('success', 'Mata pelajaran baru berhasil ditambahkan ke kurikulum.');
    }

    public function mapelUpdate(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel,' . $id . ',id_mata_pelajaran',
            'nama_mapel' => 'required|string|max:255',
            'kkm' => 'required|numeric|min:0|max:100',
        ]);

        $mapel->update($request->all());

        return back()->with('success', 'Mata pelajaran ' . $mapel->nama_mapel . ' berhasil diperbarui.');
    }

    public function mapelDestroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $nama = $mapel->nama_mapel;
        $mapel->delete();

        return back()->with('success', 'Mata pelajaran ' . $nama . ' berhasil dihapus dari kurikulum.');
    }
}
