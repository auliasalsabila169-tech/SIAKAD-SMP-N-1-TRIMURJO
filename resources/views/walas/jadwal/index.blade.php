@extends('layouts.app')

@section('title', 'Pengecekan Jadwal KBM Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('walas.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-amber-400 font-bold hover:text-amber-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard Walas
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Pengecekan Jadwal KBM - Kelas {{ $kelas->nama_kelas ?? '' }}</h1>
            <p class="text-slate-400 text-xs">Kewenangan Wali Kelas: Memantau & Mengecek Jadwal Pelajaran yang Diterbitkan Tata Usaha</p>
        </div>
        <div class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-right">
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Status Jadwal</span>
            <span class="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Diterbitkan Tata Usaha
            </span>
        </div>
    </div>

    <!-- Jadwal Table (Read-Only untuk Walas) -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Hari KBM</th>
                        <th class="p-4">Slot Jam</th>
                        <th class="p-4">Rentang Waktu</th>
                        <th class="p-4">Kode Mapel</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru Pengampu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($jadwals as $j)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 font-black rounded-lg text-xs">
                                    {{ $j->hari->nama_hari ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-white text-sm">
                                Jam Ke-{{ $j->jamPelajaran->urutan ?? '-' }}
                            </td>
                            <td class="p-4 font-mono text-slate-300 text-xs font-bold">
                                {{ $j->jamPelajaran->jam_mulai ?? '' }} &ndash; {{ $j->jamPelajaran->jam_selesai ?? '' }} WIB
                            </td>
                            <td class="p-4 font-mono font-bold text-blue-400 text-xs">
                                {{ $j->mataPelajaran->kode_mapel ?? '-' }}
                            </td>
                            <td class="p-4 font-extrabold text-white text-sm">
                                {{ $j->mataPelajaran->nama_mapel ?? '-' }}
                            </td>
                            <td class="p-4">
                                <span class="text-slate-200 font-bold text-xs block">{{ $j->guru->nama_guru ?? '-' }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">NIP. {{ $j->guru->nip ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">
                                Jadwal KBM untuk kelas ini belum diterbitkan oleh bagian Tata Usaha.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
