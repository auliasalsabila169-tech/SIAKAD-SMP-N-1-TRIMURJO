@extends('layouts.app')

@section('title', 'Input Nilai Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-emerald-400 font-bold hover:text-emerald-300 transition mb-1.5">
                <span>&larr;</span> Kembali ke Dashboard Guru
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Formulir Penilaian Siswa: {{ $jadwal->mataPelajaran->nama_mapel }}</h1>
            <p class="text-slate-400 text-xs mt-1">
                Rombel: <span class="font-bold text-white">{{ $jadwal->kelas->nama_kelas }}</span> &bull; 
                Semester: <span class="font-bold text-emerald-400 uppercase">{{ $jadwal->tahunAjaran->semester_aktif ?? 'Ganjil' }}</span> &bull;
                Tahun Ajaran: <span class="font-bold text-white">{{ $jadwal->tahunAjaran->tahun ?? '2025/2026' }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2.5 rounded-2xl bg-slate-900 border border-slate-800 text-right shadow-md">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">KKM Mapel</span>
                <span class="text-xl font-black text-emerald-400 font-mono">{{ $jadwal->mataPelajaran->kkm ?? 75 }}</span>
            </div>
            <div class="px-4 py-2.5 rounded-2xl bg-slate-900 border border-slate-800 text-right shadow-md">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Siswa</span>
                <span class="text-xl font-black text-white font-mono">{{ $siswas->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Form Input Nilai -->
    <form action="{{ route('guru.nilai.store', $jadwal->id_jadwal) }}" method="POST">
        @csrf

        <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden mb-6">
            <div class="p-4 bg-slate-950/60 border-b border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Matriks Penilaian Capaian Pembelajaran (KBM)</span>
                </div>
                <span class="text-[11px] text-slate-400 font-mono">Skala Penilaian: 0 - 100</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4 w-28">NISN</th>
                            <th class="p-4 w-52">Nama Siswa</th>
                            <th class="p-4 w-32">Pengetahuan (P)</th>
                            <th class="p-4 w-32">Keterampilan (K)</th>
                            <th class="p-4 w-28 text-center">Nilai Akhir (NA)</th>
                            <th class="p-4 w-36">Predikat Sikap</th>
                            <th class="p-4">Deskripsi / Capaian Kompetensi Belajar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-medium">
                        @forelse($siswas as $idx => $s)
                            @php
                                $nilai = $existingNilai[$s->id_siswa] ?? null;
                                $pVal = $nilai ? $nilai->nilai_pengetahuan : 80;
                                $kVal = $nilai ? $nilai->nilai_keterampilan : 85;
                                $naVal = round(($pVal + $kVal) / 2, 2);
                            @endphp
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="p-4 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                <td class="p-4 font-mono font-bold text-blue-400 text-xs">{{ $s->nisn }}</td>
                                <td class="p-4 font-black text-white text-sm">
                                    {{ $s->nama }}
                                    <span class="block text-[10px] text-slate-400 font-normal">NIS: {{ $s->nis ?? '-' }}</span>
                                </td>
                                <td class="p-4">
                                    <input type="number" step="0.01" min="0" max="100" 
                                        name="nilai[{{ $s->id_siswa }}][pengetahuan]" 
                                        id="p_{{ $s->id_siswa }}"
                                        value="{{ $pVal }}" 
                                        oninput="calcNA({{ $s->id_siswa }})"
                                        required
                                        class="w-full px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white font-mono font-black text-center focus:outline-none focus:border-emerald-500 transition">
                                </td>
                                <td class="p-4">
                                    <input type="number" step="0.01" min="0" max="100" 
                                        name="nilai[{{ $s->id_siswa }}][keterampilan]" 
                                        id="k_{{ $s->id_siswa }}"
                                        value="{{ $kVal }}" 
                                        oninput="calcNA({{ $s->id_siswa }})"
                                        required
                                        class="w-full px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white font-mono font-black text-center focus:outline-none focus:border-emerald-500 transition">
                                </td>
                                <td class="p-4 text-center">
                                    <span id="na_{{ $s->id_siswa }}" class="px-3 py-1.5 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-300 font-mono font-black text-sm block">
                                        {{ number_format($naVal, 1) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <select name="nilai[{{ $s->id_siswa }}][sikap]" class="w-full px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white font-bold focus:outline-none focus:border-emerald-500 transition">
                                        <option value="A" {{ ($nilai && in_array(strtoupper($nilai->nilai_sikap), ['A', 'SB'])) ? 'selected' : '' }}>A - Sangat Baik</option>
                                        <option value="B" {{ (!$nilai || in_array(strtoupper($nilai->nilai_sikap), ['B'])) ? 'selected' : '' }}>B - Baik</option>
                                        <option value="C" {{ ($nilai && in_array(strtoupper($nilai->nilai_sikap), ['C'])) ? 'selected' : '' }}>C - Cukup</option>
                                        <option value="D" {{ ($nilai && in_array(strtoupper($nilai->nilai_sikap), ['D', 'K'])) ? 'selected' : '' }}>D - Kurang</option>
                                    </select>
                                </td>
                                <td class="p-4">
                                    <input type="text" 
                                        name="nilai[{{ $s->id_siswa }}][deskripsi]" 
                                        value="{{ $nilai ? $nilai->deskripsi : 'Menunjukkan penguasaan materi yang sangat baik dan aktif dalam diskusi kelompok.' }}" 
                                        placeholder="Catatan capaian siswa..."
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-200 placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-12 text-center text-slate-500">Tidak ada data siswa terdaftar di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Sticky Action Footer -->
            <div class="p-5 bg-slate-950 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Nilai Akhir (NA = (P + K) / 2) dihitung otomatis secara langsung dan tersinkronisasi ke Leger Wali Kelas.</span>
                </div>
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black tracking-wide rounded-xl text-xs uppercase transition shadow-xl shadow-emerald-600/30 flex items-center gap-2 active:scale-98 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    SIMPAN & SINKRONKAN NILAI
                </button>
            </div>
        </div>
    </form>

</div>

<script>
    function calcNA(siswaId) {
        const pInput = document.getElementById('p_' + siswaId);
        const kInput = document.getElementById('k_' + siswaId);
        const naSpan = document.getElementById('na_' + siswaId);
        if (pInput && kInput && naSpan) {
            const p = parseFloat(pInput.value) || 0;
            const k = parseFloat(kInput.value) || 0;
            const na = ((p + k) / 2).toFixed(1);
            naSpan.innerText = na;
        }
    }
</script>
@endsection
