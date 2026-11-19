@extends('layouts.app')

@section('title', 'Menu Input Nilai Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-emerald-400 font-bold hover:text-emerald-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard Guru
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Formulir & Menu Input Nilai Siswa</h1>
            <p class="text-slate-400 text-xs">Kewenangan Guru: Memberikan Nilai Pengetahuan, Keterampilan, dan Sikap pada Kelas yang Diampu</p>
        </div>
        <div class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-right">
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Tahun Ajaran</span>
            <span class="text-xs font-bold text-emerald-400 font-mono">{{ $tahunAktif->tahun ?? '2025/2026' }} ({{ $tahunAktif->semester_aktif ?? 'Ganjil' }})</span>
        </div>
    </div>

    <!-- Grid Card Kelas KBM yang Diampu untuk Input Nilai -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jadwals as $j)
            <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl flex flex-col justify-between hover:border-emerald-500/50 transition group relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition"></div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/30 text-blue-300 font-black rounded-lg text-xs">
                            KELAS {{ $j->kelas->nama_kelas ?? '-' }}
                        </span>
                        <span class="text-xs font-mono font-bold text-emerald-400">
                            KKM: {{ $j->mataPelajaran->kkm ?? 75 }}
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-white mb-1 group-hover:text-emerald-300 transition">
                        {{ $j->mataPelajaran->nama_mapel ?? '-' }}
                    </h3>
                    <p class="text-xs text-slate-400 font-mono">Kode: {{ $j->mataPelajaran->kode_mapel ?? '-' }}</p>

                    <div class="mt-4 pt-3 border-t border-slate-800/80 space-y-1.5 text-xs text-slate-400">
                        <div class="flex items-center justify-between">
                            <span>Jadwal KBM:</span>
                            <span class="font-bold text-white">{{ $j->hari->nama_hari ?? '-' }}, Jam {{ $j->jamPelajaran->urutan ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Jumlah Siswa:</span>
                            <span class="font-bold text-slate-300 font-mono">{{ $j->kelas?->siswas ? $j->kelas->siswas->count() : 0 }} Siswa</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-800">
                    <a href="{{ route('guru.nilai.input', $j->id_jadwal) }}" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>INPUT NILAI KELAS INI</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-slate-900 border border-slate-800 p-12 rounded-3xl text-center text-slate-500">
                Belum ada jadwal mengajar yang diplot untuk Anda oleh Tata Usaha.
            </div>
        @endforelse
    </div>

</div>
@endsection

