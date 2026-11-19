@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-8">

    <!-- Header Section Banner Siswa (Eksekutif & Elegan) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-950 via-slate-900 to-indigo-950 border border-blue-500/30 p-6 sm:p-8 shadow-2xl">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 p-2 rounded-2xl bg-slate-950/80 border border-white/20 shadow-xl flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-500/40 text-blue-300 text-xs font-black tracking-wide uppercase mb-1">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        PORTAL HASIL BELAJAR SISWA
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $siswa->nama ?? 'Nama Peserta Didik' }}
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm mt-0.5">
                        NISN: <span class="font-mono font-bold text-blue-400">{{ $siswa->nisn ?? '-' }}</span> &bull; 
                        Rombel: <span class="font-bold text-white">Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}</span> &bull; 
                        Wali Kelas: <span class="font-semibold text-slate-300">{{ $siswa->kelas->waliKelas->nama_guru ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-slate-950/80 border border-slate-800 p-4 rounded-2xl shadow-md">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-400 flex items-center justify-center text-xl font-black">
                    🏆
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] font-extrabold uppercase tracking-wider block">Rata-Rata Capaian Rapor</span>
                    @if($isAccTu)
                        <span class="text-3xl font-black text-blue-400 font-mono">{{ number_format($rataRata, 1) }}</span>
                    @else
                        <span class="text-xs font-black text-amber-400 block mt-1 px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20">
                            Menunggu Pengesahan
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3 Column Layout (Left: Biodata Buku Induk, Right: Nilai & Jadwal) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom Kiri: Profil Siswa (Buku Induk) -->
        <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl space-y-5 h-fit">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-800">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-base">
                    📋
                </div>
                <div>
                    <h3 class="font-black text-white text-sm">Biodata Buku Induk</h3>
                    <p class="text-[10px] text-slate-400">Data Pokok Pendidikan Siswa</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Nomor Induk Siswa (NIS)</span>
                    <span class="font-mono font-bold text-slate-200">{{ $siswa->nis ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Nomor Induk Siswa Nasional</span>
                    <span class="font-mono font-black text-blue-400">{{ $siswa->nisn ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Jenis Kelamin</span>
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-black {{ $siswa->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                        {{ $siswa->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Tempat, Tanggal Lahir</span>
                    <span class="text-slate-200 font-medium">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? date('d/m/Y', strtotime($siswa->tanggal_lahir)) : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Agama</span>
                    <span class="text-slate-200 font-medium">{{ $siswa->agama ?? 'Islam' }}</span>
                </div>
                <div class="flex justify-between items-start py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Alamat Domisili</span>
                    <span class="text-slate-200 text-right max-w-[160px] truncate">{{ $siswa->alamat ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-800/60">
                    <span class="text-slate-400">Tahun Ajaran</span>
                    <span class="font-black text-emerald-400 font-mono">{{ $tahunAktif->tahun ?? '2025/2026' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-slate-400">Semester Berjalan</span>
                    <span class="font-bold text-white uppercase">{{ $tahunAktif->semester ?? 'Ganjil' }}</span>
                </div>
            </div>
        </div>

        <!-- Kolom Tengah & Kanan: Nilai Rapor & Jadwal Pelajaran -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Tabel Nilai & Hasil Belajar -->
            <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">📊</span>
                            <h3 class="font-black text-white text-base">Hasil Penilaian Capaian Pembelajaran</h3>
                        </div>
                        <p class="text-slate-400 text-xs mt-0.5">Semester {{ $tahunAktif->semester ?? 'Ganjil' }} &bull; TP {{ $tahunAktif->tahun ?? '2025/2026' }}</p>
                    </div>
                    <div class="flex items-center gap-2.5">
                        @if($isAccTu)
                            <button onclick="window.print()" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700 text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer no-print">
                                <span>🖨️</span>
                                <span>Cetak Rapor</span>
                            </button>
                            <span class="px-3 py-1 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 font-black text-xs flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                NILAI TELAH DISAHKAN
                            </span>
                        @else
                            <span class="px-3 py-1.5 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 font-black text-xs flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                MENUNGGU PENGESAHAN
                            </span>
                        @endif
                    </div>
                </div>

                @if($isAccTu)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                                <tr>
                                    <th class="p-4">Mata Pelajaran</th>
                                    <th class="p-4 text-center">Pengetahuan</th>
                                    <th class="p-4 text-center">Keterampilan</th>
                                    <th class="p-4 text-center">Sikap</th>
                                    <th class="p-4 text-center">Nilai Akhir</th>
                                    <th class="p-4">Capaian Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 font-medium">
                                @forelse($nilais as $n)
                                    <tr class="hover:bg-slate-800/40 transition">
                                        <td class="p-4">
                                            <span class="font-black text-white text-sm block">{{ $n->jadwal->mataPelajaran->nama_mapel ?? '-' }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">{{ $n->jadwal->guru->nama_guru ?? '' }}</span>
                                        </td>
                                        <td class="p-4 text-center font-mono font-bold text-slate-200">{{ $n->nilai_pengetahuan }}</td>
                                        <td class="p-4 text-center font-mono font-bold text-slate-200">{{ $n->nilai_keterampilan }}</td>
                                        <td class="p-4 text-center">
                                            <span class="px-2.5 py-1 rounded-lg font-mono font-black text-xs uppercase {{ in_array(strtoupper($n->nilai_sikap), ['A', 'SB']) ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' : 'bg-blue-500/10 text-blue-300 border border-blue-500/20' }}">
                                                {{ strtoupper($n->nilai_sikap) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="px-3 py-1 rounded-xl bg-blue-600/20 border border-blue-500/30 text-blue-400 font-mono font-black text-sm">
                                                {{ $n->nilai_akhir }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-slate-300 text-xs leading-relaxed max-w-xs">
                                            {{ $n->deskripsi ?? 'Telah mencapai ketuntasan kompetensi secara optimal.' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-500">
                                            Data nilai belum diinput oleh Bapak/Ibu guru pengampu mata pelajaran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center space-y-3 bg-slate-950/40">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mx-auto shadow-inner">
                            🔒
                        </div>
                        <h4 class="font-black text-base text-white">Lembar Nilai Belum Disahkan</h4>
                        <p class="text-xs text-slate-400 max-w-md mx-auto leading-relaxed">
                            Proses rekapitulasi capaian kompetensi semester ini sedang dikoordinasikan. Nilai akan otomatis tampil di sini segera setelah diverifikasi dan disahkan oleh pihak sekolah.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Tabel Jadwal Pelajaran Kelas -->
            <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🗓️</span>
                            <h3 class="font-black text-white text-base">Jadwal Kegiatan Belajar Mengajar (KBM)</h3>
                        </div>
                        <p class="text-slate-400 text-xs mt-0.5">Kelas {{ $siswa->kelas->nama_kelas ?? '-' }} &bull; Semester {{ $tahunAktif->semester ?? 'Ganjil' }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl bg-slate-950 border border-slate-800 text-xs font-bold font-mono text-slate-300">
                        {{ $jadwals->count() }} Sesi Pelajaran
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4">Hari KBM</th>
                                <th class="p-4">Jam Belajar</th>
                                <th class="p-4">Mata Pelajaran</th>
                                <th class="p-4">Guru Pengampu</th>
                                <th class="p-4 text-center">Ruang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 font-medium">
                            @forelse($jadwals as $j)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-md bg-blue-500/10 border border-blue-500/20 text-blue-300 font-black text-[10px] uppercase">
                                            {{ $j->hari->nama_hari ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="text-white font-bold block">Jam ke-{{ $j->jamPelajaran->urutan ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-500 font-mono">{{ $j->jamPelajaran->jam_mulai ?? '' }} - {{ $j->jamPelajaran->jam_selesai ?? '' }} WIB</span>
                                    </td>
                                    <td class="p-4 font-black text-white text-sm">
                                        {{ $j->mataPelajaran->nama_mapel ?? '-' }}
                                    </td>
                                    <td class="p-4 text-slate-300 font-medium">
                                        {{ $j->guru->nama_guru ?? '-' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2.5 py-1 bg-slate-950 border border-slate-800 rounded-lg font-mono font-bold text-slate-400 text-xs">
                                            {{ $j->ruang->nama_ruang ?? 'R.' . ($siswa->kelas->nama_kelas ?? 'Kelas') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-500">
                                        Jadwal pelajaran untuk kelas ini belum dipublikasikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
