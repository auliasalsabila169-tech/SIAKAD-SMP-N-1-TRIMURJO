@extends('layouts.app')

@section('title', 'Rekapitulasi Nilai Seluruh Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tu.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 font-bold hover:text-blue-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Rekapitulasi Nilai Akademik Siswa</h1>
            <p class="text-slate-400 text-xs">Kewenangan Tata Usaha: Akses Pemantauan Seluruh Nilai Siswa dari Setiap Kelas</p>
        </div>
        <div class="flex items-center gap-3">
            @if($kelas)
                <form action="{{ route('tu.nilai.acc', $kelas->id_kelas) }}" method="POST" class="inline">
                    @csrf
                    @if($kelas->is_acc_tu)
                        <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                            <span>✅</span>
                            <span>STATUS: DISAHKAN (KLIK UNTUK KUNCI)</span>
                        </button>
                    @else
                        <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                            <span>🔒</span>
                            <span>SAHKAN & TERBITKAN KE SISWA</span>
                        </button>
                    @endif
                </form>
            @endif

            <button onclick="window.print()" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold border border-slate-700 transition flex items-center gap-2">
                <span>🖨️</span> Cetak Rekap
            </button>
        </div>
    </div>

    <!-- Filter Pilihan Kelas -->
    <div class="bg-slate-900 p-5 rounded-3xl border border-slate-800 shadow-xl flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('tu.nilai.index') }}" class="flex items-center gap-3">
            <span class="text-xs font-black text-slate-300 uppercase tracking-wider">PILIH KELAS:</span>
            <select name="kelas_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs font-bold focus:border-blue-500 outline-none">
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $selectedKelasId == $k->id_kelas ? 'selected' : '' }}>
                        Kelas {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }}) - Wali: {{ $k->waliKelas->nama_guru ?? 'Belum Ada' }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="flex items-center gap-3 text-xs">
            <span class="px-3 py-1.5 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-300 font-bold">
                Tahun Ajaran: {{ $tahunAktif->tahun ?? '2025/2026' }} ({{ $tahunAktif->semester_aktif ?? 'Ganjil' }})
            </span>
            <span class="px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 font-bold font-mono">
                {{ $siswas->count() }} Siswa Terdaftar
            </span>
        </div>
    </div>

    <!-- Matriks Rekap Nilai Kelas -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="font-black text-white text-base">Tabel Rekapitulasi Nilai: {{ $kelas->nama_kelas ?? 'Pilih Kelas' }}</h3>
                <p class="text-xs text-slate-400">Nilai akhir mata pelajaran yang diinputkan oleh para guru pengampu</p>
            </div>
            <span class="text-xs text-emerald-400 font-bold">● Data Real-time Terhubung</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/90 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3.5 w-10 text-center">No</th>
                        <th class="p-3.5 w-28">NISN</th>
                        <th class="p-3.5 w-44">Nama Siswa</th>
                        <th class="p-3.5 w-12 text-center">JK</th>
                        @foreach($jadwals as $j)
                            <th class="p-3.5 text-center" title="{{ $j->mataPelajaran->nama_mapel }}">
                                <span class="block truncate max-w-[90px]">{{ $j->mataPelajaran->nama_mapel }}</span>
                                <span class="text-[9px] text-slate-500 font-mono font-normal">KKM: {{ $j->mataPelajaran->kkm ?? 75 }}</span>
                            </th>
                        @endforeach
                        <th class="p-3.5 text-center bg-blue-950/40 text-blue-300">Total</th>
                        <th class="p-3.5 text-center bg-blue-950/60 text-blue-300">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($siswas as $idx => $s)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-3.5 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                            <td class="p-3.5 font-mono font-bold text-blue-400 text-xs">{{ $s->nisn }}</td>
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
                            <td class="p-3.5 text-center font-mono font-black text-white bg-blue-950/20">
                                {{ $ringkasanSiswa[$s->id_siswa]['total'] ?? 0 }}
                            </td>
                            <td class="p-3.5 text-center font-mono font-black text-blue-400 bg-blue-950/40 text-sm">
                                {{ $ringkasanSiswa[$s->id_siswa]['rata_rata'] ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + $jadwals->count() }}" class="p-12 text-center text-slate-500">
                                Belum ada siswa terdaftar di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

