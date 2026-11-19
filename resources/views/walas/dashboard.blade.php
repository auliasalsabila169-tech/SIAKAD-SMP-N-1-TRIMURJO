@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="space-y-8">

    <!-- HEADER KHUSUS WALI KELAS (Kepemimpinan Rombel & Rekapitulasi Leger) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-950 via-slate-900 to-indigo-950 border border-amber-500/40 p-6 sm:p-8 shadow-2xl">
        <div class="absolute -right-12 -bottom-12 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-18 h-18 p-2.5 rounded-2xl bg-slate-950/90 border border-amber-400/40 shadow-xl flex items-center justify-center shrink-0 ring-2 ring-amber-400/20">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-black tracking-wide uppercase mb-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        PORTAL WALI KELAS &bull; KELAS {{ $kelas->nama_kelas ?? 'BINAAN' }}
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Manajemen & Leger Rapor Kelas {{ $kelas->nama_kelas ?? '' }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm mt-0.5">
                        Wali Kelas: <strong class="text-amber-300">{{ Auth::user()->name }}</strong> &bull;
                        Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun ?? '2025/2026' }}</strong> &bull;
                        Semester: <strong class="text-white uppercase">{{ $tahunAktif->semester ?? 'Ganjil' }}</strong>
                    </p>
                </div>
            </div>

            <!-- FITUR UTAMA EKSKLUSIF WALI KELAS: CETAK LEGER & REKAP SEMUA NILAI -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('walas.leger.cetak') }}" target="_blank" class="px-5 py-3.5 bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 hover:from-amber-400 hover:to-yellow-400 text-slate-950 rounded-2xl text-xs font-black tracking-wider uppercase transition shadow-xl shadow-amber-500/25 flex items-center gap-2.5 active:scale-95 group">
                    <svg class="w-4 h-4 text-slate-950 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>🖨️ CETAK BUKU LEGER RESMI</span>
                </a>

                <a href="{{ route('walas.nilai.index') }}" class="px-4 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-xs font-black tracking-wider uppercase transition shadow-lg shadow-indigo-600/30 flex items-center gap-2 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>REKAP SEMUA NILAI GURU</span>
                </a>

                <a href="{{ route('walas.jadwal.index') }}" class="px-4 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700 rounded-2xl text-xs font-bold tracking-wider uppercase transition shadow-md flex items-center gap-2 active:scale-95">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>JADWAL KELAS</span>
                </a>
            </div>
        </div>
    </div>

    <!-- STATS KHUSUS KELAS BINAAN WALI KELAS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Siswa Binaan & Rasio Gender -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-amber-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Peserta Didik Binaan</span>
                <div class="text-3xl font-black text-white font-mono mt-1">
                    {{ $siswas->count() }} <span class="text-xs text-amber-400 font-bold uppercase font-sans">Siswa</span>
                </div>
                <div class="mt-2 flex items-center gap-2 text-[11px] font-bold">
                    <span class="px-2 py-0.5 rounded bg-sky-500/10 text-sky-400 border border-sky-500/20 font-mono">
                        {{ $siswaLaki }} Laki-laki
                    </span>
                    <span class="px-2 py-0.5 rounded bg-pink-500/10 text-pink-400 border border-pink-500/20 font-mono">
                        {{ $siswaPerempuan }} Perempuan
                    </span>
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-2xl font-black">
                👥
            </div>
        </div>

        <!-- Card 2: Kelengkapan Nilai dari Guru-Guru Mapel -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-indigo-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Nilai Guru Mapel Masuk</span>
                <div class="text-3xl font-black text-indigo-400 font-mono mt-1">
                    {{ $totalMapelLengkap }} <span class="text-xs text-slate-400 font-bold uppercase font-sans">/ {{ count($mapelMonitoring) }} Mapel</span>
                </div>
                <span class="text-[11px] text-slate-400 mt-2 block font-medium">
                    {{ count($mapelMonitoring) - $totalMapelLengkap }} Mapel menunggu penyelesaian
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl font-black">
                📊
            </div>
        </div>

        <!-- Card 3: Status Leger Akademik -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-emerald-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Status Leger Rapor</span>
                <div class="text-xl font-black text-emerald-400 mt-2 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Tersinkronisasi
                </div>
                <span class="text-[10px] text-slate-500 font-medium block mt-1">Standar Kurikulum Merdeka</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl font-black">
                📑
            </div>
        </div>
    </div>

    <!-- FITUR KHUSUS WALI KELAS 1: RADAR MONITORING KETERISIAN NILAI DARI SELURUH GURU MATA PELAJARAN -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">📡</span>
                    <h3 class="font-black text-white text-base">Radar Pemantauan Penilaian dari Seluruh Guru Mata Pelajaran</h3>
                </div>
                <p class="text-slate-400 text-xs mt-0.5">
                    Wali Kelas memantau kepatuhan seluruh guru mata pelajaran dalam menyetor nilai siswa Kelas {{ $kelas->nama_kelas ?? '' }} sebelum Leger Rapor dicetak.
                </p>
            </div>
            <a href="{{ route('walas.nilai.index') }}" class="px-4 py-2 bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white border border-indigo-500/30 rounded-xl text-xs font-bold transition flex items-center gap-2 w-fit">
                <span>Lihat Matriks Lengkap</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru Pengampu</th>
                        <th class="p-4 text-center">Siswa Dinilai</th>
                        <th class="p-4">Progres Penilaian</th>
                        <th class="p-4 text-center">Status Leger</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($mapelMonitoring as $mm)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <span class="font-bold text-white text-sm block">{{ $mm['mapel'] }}</span>
                                <span class="text-[10px] font-mono text-slate-400">KODE: {{ $mm['kode'] }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-200 block">{{ $mm['guru'] }}</span>
                                <span class="text-[10px] font-mono text-slate-500">NIP: {{ $mm['nip'] }}</span>
                            </td>
                            <td class="p-4 text-center font-mono font-bold text-slate-300">
                                {{ $mm['sudah_dinilai'] }} / {{ $mm['total_siswa'] }}
                            </td>
                            <td class="p-4">
                                <div class="w-full bg-slate-950 rounded-full h-2.5 overflow-hidden border border-slate-800 max-w-xs">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $mm['is_lengkap'] ? 'bg-emerald-500' : 'bg-amber-500' }}" style="width: {{ $mm['persen'] }}%"></div>
                                </div>
                                <span class="text-[10px] font-mono text-slate-400 mt-1 block">{{ $mm['persen'] }}% Terisi</span>
                            </td>
                            <td class="p-4 text-center">
                                @if($mm['is_lengkap'])
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 font-extrabold text-[10px] uppercase">
                                        ✅ Lengkap
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 font-extrabold text-[10px] uppercase">
                                        ⏳ Belum Lengkap
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">Belum ada mata pelajaran yang terjadwal di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- FITUR KHUSUS WALI KELAS 2: DIREKTORI PESERTA DIDIK KELAS BINAAN -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">📋</span>
                    <h3 class="font-black text-white text-base">Buku Induk Peserta Didik Kelas {{ $kelas->nama_kelas ?? '' }}</h3>
                </div>
                <p class="text-slate-400 text-xs mt-0.5">Data Pokok Siswa Binaan Wali Kelas untuk Kelengkapan Rapor</p>
            </div>
            <span class="px-3 py-1 rounded-xl bg-slate-950 border border-slate-800 text-amber-400 font-mono text-xs font-bold">
                {{ $siswas->count() }} Siswa Binaan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">NISN</th>
                        <th class="p-4">Nama Peserta Didik</th>
                        <th class="p-4 text-center">Jenis Kelamin</th>
                        <th class="p-4">Tempat, Tanggal Lahir</th>
                        <th class="p-4">Kontak / HP</th>
                        <th class="p-4">Alamat Domisili</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($siswas as $s)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4 font-mono font-bold text-amber-400 text-sm">{{ $s->nisn }}</td>
                            <td class="p-4 font-bold text-white text-sm">{{ $s->nama }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $s->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                                    {{ $s->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? date('d/m/Y', strtotime($s->tanggal_lahir)) : '-' }}</td>
                            <td class="p-4 font-mono text-slate-400">{{ $s->telepon ?? '-' }}</td>
                            <td class="p-4 text-slate-400 max-w-xs truncate">{{ $s->alamat ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Belum ada siswa yang terdaftar di kelas binaan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
