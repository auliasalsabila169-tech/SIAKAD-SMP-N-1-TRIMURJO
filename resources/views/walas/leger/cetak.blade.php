<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEGER NILAI AKADEMIK - KELAS {{ $kelas->nama_kelas ?? '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #f8fafc;
        }
        @media print {
            body {
                background: #fff;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: landscape;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="p-6">

    <!-- Action Bar (No-Print) -->
    <div class="max-w-6xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center no-print">
        <div>
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Output Resmi Akademik</span>
            <h1 class="text-base font-black text-slate-900">Lembar Leger Nilai Siswa (Siap Cetak)</h1>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-2">
                🖨️ Cetak Dokumen (PDF)
            </button>
            <button onclick="window.close()" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Container Cetak Kertas -->
    <div class="max-w-6xl mx-auto bg-white p-8 md:p-12 shadow-lg border border-slate-200 print:shadow-none print:border-none print:p-0">
        
        <!-- Kop Surat Sekolah -->
        <div class="border-b-4 border-double border-slate-900 pb-4 mb-6 flex items-center justify-between text-center">
            <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo" class="w-20 h-20 object-contain">
            <div class="flex-1 px-4">
                <h3 class="text-sm font-bold uppercase tracking-widest">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                <h3 class="text-sm font-bold uppercase tracking-widest">DINAS PENDIDIKAN DAN KEBUDAYAAN</h3>
                <h1 class="text-xl font-black uppercase tracking-wider mt-1">SMP NEGERI 1 TRIMURJO</h1>
                <p class="text-xs text-slate-600 mt-0.5">Kecamatan Trimurjo, Kabupaten Lampung Tengah, Provinsi Lampung</p>
            </div>
            <div class="w-20"></div>
        </div>

        <!-- Judul Leger -->
        <div class="text-center mb-6">
            <h2 class="text-base font-bold uppercase tracking-wider underline">LEGER NILAI HASIL BELAJAR SISWA</h2>
            <div class="flex justify-between text-xs mt-3 px-2">
                <div>
                    <div><strong>Kelas:</strong> {{ $kelas->nama_kelas ?? '-' }} (Tingkat {{ $kelas->tingkat ?? '-' }})</div>
                    <div><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->nama_guru ?? '-' }}</div>
                </div>
                <div class="text-right">
                    <div><strong>Tahun Ajaran:</strong> {{ $tahunAktif->tahun ?? '2025/2026' }}</div>
                    <div><strong>Semester:</strong> {{ $tahunAktif->semester_aktif ?? 'Ganjil' }}</div>
                </div>
            </div>
        </div>

        <!-- Matriks Tabel Leger Nilai -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-slate-900 text-[11px]">
                <thead>
                    <tr class="bg-slate-100 text-center font-bold">
                        <th rowspan="2" class="border border-slate-900 p-2 w-8">No</th>
                        <th rowspan="2" class="border border-slate-900 p-2 w-24">NIS / NISN</th>
                        <th rowspan="2" class="border border-slate-900 p-2 text-left">Nama Peserta Didik</th>
                        <th rowspan="2" class="border border-slate-900 p-2 w-10">JK</th>
                        @foreach($jadwals as $j)
                            <th colspan="2" class="border border-slate-900 p-1.5">{{ $j->mataPelajaran->kode_mapel ?? 'Mapel' }}</th>
                        @endforeach
                        <th rowspan="2" class="border border-slate-900 p-2 w-16">Total Nilai</th>
                        <th rowspan="2" class="border border-slate-900 p-2 w-16">Rata-rata</th>
                    </tr>
                    <tr class="bg-slate-50 text-center text-[10px] font-bold">
                        @foreach($jadwals as $j)
                            <th class="border border-slate-900 p-1 w-12">NA</th>
                            <th class="border border-slate-900 p-1 w-8">Sikap</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $idx => $s)
                        <tr class="text-center">
                            <td class="border border-slate-900 p-1.5">{{ $idx + 1 }}</td>
                            <td class="border border-slate-900 p-1.5 font-mono">{{ $s->nisn }}</td>
                            <td class="border border-slate-900 p-1.5 text-left font-bold">{{ $s->nama }}</td>
                            <td class="border border-slate-900 p-1.5">{{ $s->jenis_kelamin }}</td>
                            
                            @foreach($jadwals as $j)
                                @php
                                    $n = $rekapNilai[$s->id_siswa][$j->mapel_id] ?? null;
                                @endphp
                                <td class="border border-slate-900 p-1.5 font-bold">
                                    {{ $n ? $n->nilai_akhir : '-' }}
                                </td>
                                <td class="border border-slate-900 p-1.5 uppercase font-bold text-[10px]">
                                    {{ $n ? $n->nilai_sikap : '-' }}
                                </td>
                            @endforeach

                            <td class="border border-slate-900 p-1.5 font-bold bg-slate-50">
                                {{ $totalNilaiSiswa[$s->id_siswa]['total'] ?? 0 }}
                            </td>
                            <td class="border border-slate-900 p-1.5 font-bold bg-slate-50">
                                {{ $totalNilaiSiswa[$s->id_siswa]['rata_rata'] ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + ($jadwals->count() * 2) }}" class="p-4 text-center border border-slate-900">
                                Tidak ada data siswa di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan Pengesahan -->
        <div class="mt-12 flex justify-between text-xs px-8">
            <div class="text-center">
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala SMP Negeri 1 Trimurjo</p>
                <div class="h-20"></div>
                <p class="font-bold underline">PRAYITNO UNTORO, S.Pd., M.M.</p>
                <p>NIP. 196805121994121002</p>
            </div>

            <div class="text-center">
                <p>Trimurjo, {{ date('d F Y') }}</p>
                <p class="font-bold">Wali Kelas {{ $kelas->nama_kelas ?? '' }}</p>
                <div class="h-20"></div>
                <p class="font-bold underline">{{ $kelas->waliKelas->nama_guru ?? 'Wali Kelas' }}</p>
                <p>NIP. {{ $kelas->waliKelas->nip ?? '-' }}</p>
            </div>
        </div>

    </div>

</body>
</html>

