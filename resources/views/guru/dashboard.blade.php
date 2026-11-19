@extends('layouts.app')

@section('title', 'Dashboard Guru Mata Pelajaran')

@section('content')
<div class="space-y-8">

    <!-- HEADER KHUSUS GURU MATA PELAJARAN (Pengajaran & Input Nilai Mapel) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 border border-emerald-500/40 p-6 sm:p-8 shadow-2xl">
        <div class="absolute -right-12 -bottom-12 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-18 h-18 p-2.5 rounded-2xl bg-slate-950/90 border border-emerald-400/40 shadow-xl flex items-center justify-center shrink-0 ring-2 ring-emerald-400/20">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-black tracking-wide uppercase mb-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        PORTAL GURU MATA PELAJARAN
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $guru->nama_guru ?? 'Bpk/Ibu Guru' }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm mt-0.5">
                        NIP: <span class="font-mono font-bold text-emerald-400">{{ $guru->nip ?? '-' }}</span> &bull; 
                        Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun ?? '2025/2026' }}</strong> &bull; 
                        Semester: <strong class="text-white uppercase">{{ $tahunAktif->semester ?? 'Ganjil' }}</strong> &bull;
                        SMP Negeri 1 Trimurjo
                    </p>
                </div>
            </div>

            <!-- FITUR UTAMA EKSKLUSIF GURU: INPUT NILAI MATA PELAJARAN -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('guru.nilai.index') }}" class="px-5 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 rounded-2xl text-xs font-black tracking-wider uppercase transition shadow-xl shadow-emerald-500/25 flex items-center gap-2.5 active:scale-95 group">
                    <svg class="w-4 h-4 text-slate-950 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>✍️ MENU INPUT NILAI SISWA</span>
                </a>

                <div class="flex items-center gap-3.5 bg-slate-950/80 border border-slate-800 p-3.5 rounded-2xl shadow-md">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-lg font-black">
                        📚
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] font-extrabold uppercase tracking-wider block">Beban Mengajar</span>
                        <span class="text-xl font-black text-white font-mono">{{ $jadwals->count() }} <span class="text-xs text-emerald-400 font-bold uppercase font-sans">Sesi KBM</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS KHUSUS BEBAN MENGAJAR & PROGRES PENILAIAN GURU -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Rombel yang Diajar -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-emerald-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Kelas yang Diampu</span>
                <div class="text-3xl font-black text-white font-mono mt-1">
                    {{ $jadwals->pluck('id_kelas')->unique()->count() }} 
                    <span class="text-xs text-emerald-400 font-bold uppercase font-sans">Rombel</span>
                </div>
                <span class="text-[11px] text-slate-500 font-medium mt-1 block">
                    {{ $jadwals->pluck('id_mapel')->unique()->count() }} Mata Pelajaran Diampu
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl font-black">
                🏫
            </div>
        </div>

        <!-- Card 2: Total Siswa Diajar & Sudah Dinilai -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-teal-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Progres Nilai Mapel</span>
                <div class="text-3xl font-black text-teal-400 font-mono mt-1">
                    {{ $totalSiswaSudahDinilai }} <span class="text-xs text-slate-400 font-bold uppercase font-sans">/ {{ $totalSiswaDiajar }} Siswa</span>
                </div>
                <div class="w-full bg-slate-950 rounded-full h-2 mt-2 border border-slate-800 max-w-[140px]">
                    <div class="bg-teal-400 h-full rounded-full" style="width: {{ $persenKeseluruhan }}%"></div>
                </div>
                <span class="text-[10px] font-mono text-slate-400 mt-1 block">{{ $persenKeseluruhan }}% Nilai Terinput</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center text-2xl font-black">
                ✍️
            </div>
        </div>

        <!-- Card 3: Standar Ketuntasan (KKM) -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl flex items-center justify-between group hover:border-amber-500/40 transition">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider block">Standar Kelulusan (KKM)</span>
                <div class="text-3xl font-black text-amber-400 font-mono mt-1 flex items-baseline gap-2">
                    <span>75.0</span>
                    <span class="text-xs text-amber-300 font-bold font-sans">Poin</span>
                </div>
                <span class="text-[10px] text-slate-500 font-medium block mt-1">Pengetahuan, Keterampilan & Sikap</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-2xl font-black">
                🎯
            </div>
        </div>
    </div>

    <!-- FITUR KHUSUS GURU 1: DAFTAR KELAS KBM & AKSI INPUT NILAI SISWA PER KELAS -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">✍️</span>
                    <h3 class="font-black text-white text-base">Penugasan Mengajar & Formulir Penilaian Siswa</h3>
                </div>
                <p class="text-slate-400 text-xs mt-0.5">
                    Pilih rombel kelas KBM untuk menginput Nilai Pengetahuan (P), Keterampilan (K), Sikap (A/B/C/D), serta Catatan Capaian Kompetensi.
                </p>
            </div>
            <span class="px-3 py-1 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 font-mono text-xs font-bold">
                {{ $jadwals->count() }} Kelas Mengajar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Rombel Kelas</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Jadwal Sesi</th>
                        <th class="p-4 text-center">KKM</th>
                        <th class="p-4">Status Keterisian Nilai</th>
                        <th class="p-4 text-center">Aksi Penilaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($jadwals as $j)
                        @php
                            $prog = $progresPenilaian[$j->id_jadwal] ?? ['total' => 0, 'dinilai' => 0, 'persen' => 0, 'is_selesai' => false];
                        @endphp
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/30 text-blue-300 font-black rounded-xl text-xs">
                                    Kelas {{ $j->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-1 font-mono">Tingkat {{ $j->kelas->tingkat ?? '-' }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-black text-white text-sm block">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">KODE: {{ $j->mataPelajaran->kode_mapel ?? '-' }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-bold text-[10px] uppercase block w-fit mb-0.5">
                                    {{ $j->hari->nama_hari ?? '-' }}
                                </span>
                                <span class="text-white font-bold text-xs">Jam ke-{{ $j->jamPelajaran->urutan ?? '-' }}</span>
                                <span class="text-[10px] text-slate-500 block font-mono">{{ $j->jamPelajaran->jam_mulai ?? '' }} - {{ $j->jamPelajaran->jam_selesai ?? '' }} WIB</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 bg-slate-950 border border-slate-800 rounded-lg font-mono font-black text-emerald-400 text-xs">
                                    {{ $j->mataPelajaran->kkm ?? 75 }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span class="font-mono font-bold text-slate-300">{{ $prog['dinilai'] }} / {{ $prog['total'] }} Siswa</span>
                                    <span class="font-mono text-emerald-400 font-bold">{{ $prog['persen'] }}%</span>
                                </div>
                                <div class="w-full bg-slate-950 rounded-full h-2 overflow-hidden border border-slate-800 max-w-xs">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $prog['is_selesai'] ? 'bg-emerald-500' : 'bg-teal-500' }}" style="width: {{ $prog['persen'] }}%"></div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('guru.nilai.input', $j->id_jadwal) }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-emerald-600/30 inline-flex items-center gap-2 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>INPUT NILAI</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">
                                Belum ada penugasan jadwal mengajar untuk akun guru ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
