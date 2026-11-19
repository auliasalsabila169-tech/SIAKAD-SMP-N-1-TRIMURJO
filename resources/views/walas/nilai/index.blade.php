@extends('layouts.app')

@section('title', 'Rekapitulasi Nilai Siswa Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('walas.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-amber-400 font-bold hover:text-amber-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard Walas
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Rekapitulasi Nilai Siswa - Kelas {{ $kelas->nama_kelas ?? '' }}</h1>
            <p class="text-slate-400 text-xs">Kewenangan Wali Kelas: Merekap Seluruh Nilai Mata Pelajaran yang Disetorkan oleh Para Guru Pengampu</p>
        </div>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('walas.leger.cetak') }}" target="_blank" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-amber-600/30 flex items-center gap-2">
                <span>🖨️</span> CETAK LEGER RESMI
            </a>
        </div>
    </div>

    <!-- Status ACC TU & Ringkasan -->
    <div class="bg-slate-900 p-5 rounded-3xl border border-slate-800 shadow-xl flex flex-wrap items-center justify-between gap-4">
        <div>
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Status Pengesahan / ACC Rapor:</span>
            <div class="mt-1 flex items-center gap-2">
                @if($kelas && $kelas->is_acc_tu)
                    <span class="px-3.5 py-1.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 font-black text-xs flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        NILAI TELAH DISAHKAN OLEH SEKOLAH
                    </span>
                @else
                    <span class="px-3.5 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 font-black text-xs flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        MENUNGGU PENGESAHAN AKADEMIK
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3 text-xs">
            <span class="px-3.5 py-1.5 rounded-xl bg-slate-800 text-slate-300 font-bold font-mono">
                {{ $siswas->count() }} Siswa Binaan
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-slate-800 text-slate-300 font-bold font-mono">
                {{ $jadwals->count() }} Mata Pelajaran Terdata
            </span>
        </div>
    </div>

    <!-- Matriks Rekap Nilai Siswa Kelas -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="font-black text-white text-base">Lembar Rekapitulasi Nilai Akademik Siswa</h3>
                <p class="text-xs text-slate-400">Nilai akhir yang diinputkan langsung oleh masing-masing guru mata pelajaran</p>
            </div>
            <span class="text-xs font-bold text-amber-400 font-mono">Semester {{ $tahunAktif->semester_aktif ?? 'Ganjil' }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/90 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3.5 w-10 text-center">No</th>
                        <th class="p-3.5 w-28">NISN</th>
                        <th class="p-3.5 w-44">Nama Peserta Didik</th>
                        <th class="p-3.5 w-12 text-center">JK</th>
                        @foreach($jadwals as $j)
                            <th class="p-3.5 text-center" title="{{ $j->mataPelajaran->nama_mapel }}">
                                <span class="block truncate max-w-[90px]">{{ $j->mataPelajaran->nama_mapel }}</span>
                                <span class="text-[9px] text-slate-500 font-mono font-normal block">{{ $j->guru->nama_guru ?? '' }}</span>
                            </th>
                        @endforeach
                        <th class="p-3.5 text-center bg-amber-950/40 text-amber-300">Total</th>
                        <th class="p-3.5 text-center bg-amber-950/60 text-amber-300">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($siswas as $idx => $s)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-3.5 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                            <td class="p-3.5 font-mono font-bold text-amber-400 text-xs">{{ $s->nisn }}</td>
                            <td class="p-3.5 font-black text-white text-sm">{{ $s->nama }}</td>
                            <td class="p-3.5 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $s->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300' : 'bg-pink-500/10 text-pink-300' }}">
                                    {{ $s->jenis_kelamin }}
                                </span>
                            </td>
                            @foreach($jadwals as $j)
                                @php
                                    $n = $rekapNilai[$s->id_siswa][$j->mapel_id] ?? null;
                                @endphp
                                <td class="p-3.5 text-center font-mono font-bold">
                                    @if($n)
                                        <span class="{{ $n->nilai_akhir >= ($j->mataPelajaran->kkm ?? 75) ? 'text-emerald-400 font-black' : 'text-rose-400' }}">
                                            {{ $n->nilai_akhir }}
                                        </span>
                                        <span class="text-[9px] uppercase block font-semibold text-slate-400">
                                            {{ $n->nilai_sikap ? '('.$n->nilai_sikap.')' : '' }}
                                        </span>
                                    @else
                                        <span class="text-slate-600 font-normal">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="p-3.5 text-center font-mono font-black text-white bg-amber-950/20">
                                {{ $totalNilaiSiswa[$s->id_siswa]['total'] ?? 0 }}
                            </td>
                            <td class="p-3.5 text-center font-mono font-black text-amber-400 bg-amber-950/40 text-sm">
                                {{ $totalNilaiSiswa[$s->id_siswa]['rata_rata'] ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + $jadwals->count() }}" class="p-12 text-center text-slate-500">
                                Belum ada siswa di kelas binaan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

