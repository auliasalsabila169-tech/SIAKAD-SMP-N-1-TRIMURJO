@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')
<div class="space-y-8">

    <!-- HERO HEADER DASHBOARD TU (Eksekutif & Elegan) -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-2xl">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 p-2 rounded-2xl bg-slate-950/80 border border-white/20 shadow-xl flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs font-extrabold uppercase tracking-widest mb-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        PUSAT ADMINISTRASI & TATA USAHA
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Panel Utama Akademik Sekolah
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm mt-0.5">
                        Tahun Ajaran: <strong class="text-amber-400 font-mono">{{ $tahunAktif->tahun ?? '2025/2026' }}</strong> &bull; Semester: <strong class="text-white uppercase">{{ $tahunAktif->semester_aktif ?? 'Ganjil' }}</strong> &bull; SMP Negeri 1 Trimurjo
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 bg-slate-950/80 border border-slate-800 px-5 py-3 rounded-2xl w-fit shadow-md">
                <span class="text-2xl">⚡</span>
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Mode Manajemen Cepat</span>
                    <span class="text-xs font-bold text-emerald-400">Klik Kartu untuk Manajemen Data</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FITUR KHUSUS TATA USAHA: PEMBUATAN JADWAL & AKSES NILAI SELURUH KELAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('tu.jadwal.index') }}" class="p-5 rounded-2xl bg-gradient-to-r from-blue-950/60 to-slate-900 border border-blue-500/30 hover:border-blue-400 flex items-center justify-between group transition shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-2xl font-bold">
                    📅
                </div>
                <div>
                    <span class="text-[10px] text-blue-400 font-extrabold uppercase tracking-wider block">Kewenangan Eksklusif Tata Usaha</span>
                    <h3 class="text-base font-black text-white group-hover:text-blue-300 transition">Buat & Kelola Jadwal Pelajaran</h3>
                    <p class="text-xs text-slate-400">Atur jadwal KBM resmi untuk seluruh rombel kelas</p>
                </div>
            </div>
            <span class="text-blue-400 font-black text-lg group-hover:translate-x-1 transition">&rarr;</span>
        </a>

        <a href="{{ route('tu.nilai.index') }}" class="p-5 rounded-2xl bg-gradient-to-r from-indigo-950/60 to-slate-900 border border-indigo-500/30 hover:border-indigo-400 flex items-center justify-between group transition shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl font-bold">
                    📑
                </div>
                <div>
                    <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider block">Akses Nilai Terpadu Tata Usaha</span>
                    <h3 class="text-base font-black text-white group-hover:text-indigo-300 transition">Rekap Semua Nilai Setiap Kelas</h3>
                    <p class="text-xs text-slate-400">Akses pemantauan nilai seluruh siswa dari setiap guru mapel</p>
                </div>
            </div>
            <span class="text-indigo-400 font-black text-lg group-hover:translate-x-1 transition">&rarr;</span>
        </a>
    </div>

    <!-- STATS CARDS INTERAKTIF (KLIK KARTU LANGSUNG TAMPIL DENGAN FITUR EDIT & KELOLA) -->
    <div>
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                RINGKASAN DATA POKOK (KLIK KARTU UNTUK LIHAT & KELOLA DATA):
            </span>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <!-- Card 1: Siswa -->
            <div onclick="openModalData('modalDataSiswa')" class="bg-slate-900 rounded-2xl p-5 sm:p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-blue-500 hover:scale-[1.02] active:scale-[0.99] transition cursor-pointer select-none">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-blue-300 transition">PESERTA DIDIK</span>
                    <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400 text-lg border border-blue-500/20 group-hover:bg-blue-500 group-hover:text-white transition">🎓</span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-black text-white font-mono">{{ $totalSiswa }}</span>
                    <span class="text-xs text-blue-400 font-bold">Siswa</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Terdaftar di Buku Induk</span>
                    <span class="text-blue-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka & Kelola &rarr;
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
            </div>

            <!-- Card 2: Guru -->
            <div onclick="openModalData('modalDataGuru')" class="bg-slate-900 rounded-2xl p-5 sm:p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-teal-500 hover:scale-[1.02] active:scale-[0.99] transition cursor-pointer select-none">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-teal-300 transition">TENAGA PENDIDIK</span>
                    <span class="p-2 rounded-xl bg-teal-500/10 text-teal-400 text-lg border border-teal-500/20 group-hover:bg-teal-500 group-hover:text-white transition">👨‍🏫</span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-black text-white font-mono">{{ $totalGuru }}</span>
                    <span class="text-xs text-teal-400 font-bold">Guru</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Pengampu & Wali Kelas</span>
                    <span class="text-teal-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka & Kelola &rarr;
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 to-emerald-500"></div>
            </div>

            <!-- Card 3: Kelas -->
            <div onclick="openModalData('modalDataKelas')" class="bg-slate-900 rounded-2xl p-5 sm:p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-indigo-500 hover:scale-[1.02] active:scale-[0.99] transition cursor-pointer select-none">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-indigo-300 transition">ROMBEL BELAJAR</span>
                    <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400 text-lg border border-indigo-500/20 group-hover:bg-indigo-500 group-hover:text-white transition">🏫</span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-black text-white font-mono">{{ $totalKelas }}</span>
                    <span class="text-xs text-indigo-400 font-bold">Kelas</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Tingkat 7, 8 & 9</span>
                    <span class="text-indigo-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka & Kelola &rarr;
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            </div>

            <!-- Card 4: Mapel -->
            <div onclick="openModalData('modalDataMapel')" class="bg-slate-900 rounded-2xl p-5 sm:p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-amber-500 hover:scale-[1.02] active:scale-[0.99] transition cursor-pointer select-none">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-amber-300 transition">KURIKULUM</span>
                    <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400 text-lg border border-amber-500/20 group-hover:bg-amber-500 group-hover:text-white transition">📖</span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-black text-white font-mono">{{ $totalMapel }}</span>
                    <span class="text-xs text-amber-400 font-bold">Mata Pelajaran</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Standar Kurikulum Nasional</span>
                    <span class="text-amber-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka & Kelola &rarr;
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            </div>

        </div>
    </div>

    <!-- DATA OVERVIEW TABLES (Kontras, Jelas & Setiap Baris Bisa Diklik) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Tabel Siswa Terbaru -->
        <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                <div>
                    <h2 class="font-extrabold text-base text-white tracking-tight">Data Siswa Terbaru</h2>
                    <p class="text-slate-400 text-xs">Pencatatan Buku Induk Peserta Didik</p>
                </div>
                <button onclick="openModalData('modalDataSiswa')" class="px-3 py-1.5 rounded-xl bg-blue-600/20 hover:bg-blue-600/40 text-blue-300 text-xs font-bold transition flex items-center gap-1.5 border border-blue-500/30">
                    <span>⚡</span> Buka Data Siswa
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                            <th class="pb-3">NISN</th>
                            <th class="pb-3">Nama Lengkap</th>
                            <th class="pb-3">Kelas</th>
                            <th class="pb-3">JK</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-medium">
                        @foreach($siswas as $s)
                            <tr class="hover:bg-slate-800/60 transition">
                                <td class="py-3 font-mono font-bold text-blue-400">{{ $s->nisn }}</td>
                                <td class="py-3 font-bold text-white">{{ $s->nama }}</td>
                                <td class="py-3">
                                    <span class="px-2.5 py-1 bg-blue-500/10 border border-blue-500/30 text-blue-300 rounded-lg font-bold text-[11px]">
                                        {{ $s->kelas->nama_kelas ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold {{ $s->jenis_kelamin == 'L' ? 'bg-sky-500/20 text-sky-300' : 'bg-pink-500/20 text-pink-300' }}">
                                        {{ $s->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <button onclick="editSiswa({{ json_encode($s) }})" class="px-2.5 py-1 rounded-lg bg-blue-500/20 hover:bg-blue-500/40 text-blue-300 font-bold text-[11px] transition">
                                        ✏️ Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Tenaga Pendidik -->
        <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                <div>
                    <h2 class="font-extrabold text-base text-white tracking-tight">Tenaga Pendidik</h2>
                    <p class="text-slate-400 text-xs">Daftar Guru Pengajar & Wali Kelas</p>
                </div>
                <button onclick="openModalData('modalDataGuru')" class="px-3 py-1.5 rounded-xl bg-teal-600/20 hover:bg-teal-600/40 text-teal-300 text-xs font-bold transition flex items-center gap-1.5 border border-teal-500/30">
                    <span>⚡</span> Buka Data Guru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                            <th class="pb-3">NIP Pegawai</th>
                            <th class="pb-3">Nama Lengkap</th>
                            <th class="pb-3">Penugasan</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-medium">
                        @foreach($gurus as $g)
                            <tr class="hover:bg-slate-800/60 transition">
                                <td class="py-3 font-mono text-slate-300">{{ $g->nip }}</td>
                                <td class="py-3 font-bold text-white">{{ $g->nama_guru }}</td>
                                <td class="py-3">
                                    @if($g->kelasWali)
                                        <span class="px-2.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 rounded-lg font-bold text-[11px]">
                                            Wali Kelas {{ $g->kelasWali->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-[11px]">Guru Mapel</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <button onclick="editGuru({{ json_encode($g) }})" class="px-2.5 py-1 rounded-lg bg-teal-500/20 hover:bg-teal-500/40 text-teal-300 font-bold text-[11px] transition">
                                        ✏️ Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL 1: DATA SISWA LENGKAP (LIHAT, TAMBAH, EDIT & HAPUS)                 -->
<!-- ========================================================================= -->
<div id="modalDataSiswa" class="hidden fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-5">
    <div class="bg-slate-900 rounded-3xl max-w-5xl w-full p-6 shadow-2xl border border-slate-700 max-h-[92vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-blue-500/10 border border-blue-500/30 text-blue-400 flex items-center justify-center text-xl font-black">
                    🎓
                </div>
                <div>
                    <h3 class="font-black text-white text-lg">Manajemen Peserta Didik</h3>
                    <p class="text-xs text-slate-400">Total {{ $totalSiswa }} Siswa Terdaftar &bull; Kelola, Edit & Tambah Data Langsung di Sini</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleSiswaView('formTambah')" id="btnTambahSiswa" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-black tracking-wide transition shadow-lg shadow-blue-600/30 flex items-center gap-1.5">
                    <span>+</span> Tambah Siswa Baru
                </button>
                <button onclick="closeModalData('modalDataSiswa')" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-base font-bold transition">&times;</button>
            </div>
        </div>

        <!-- FORM TAMBAH / EDIT SISWA -->
        <div id="boxFormSiswa" class="hidden my-4 p-5 rounded-2xl bg-slate-950 border border-blue-500/40">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h4 id="judulFormSiswa" class="text-sm font-black text-blue-400">Tambah Siswa Baru</h4>
                <button type="button" onclick="toggleSiswaView('tabel')" class="text-xs text-slate-400 hover:text-white">&times; Batal</button>
            </div>

            <form id="formSiswaAction" action="{{ route('tu.siswa.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div id="siswaMethodSpoof"></div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" id="s_nama" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">NISN *</label>
                        <input type="text" name="nisn" id="s_nisn" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">NIS *</label>
                        <input type="text" name="nis" id="s_nis" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="s_jk" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 outline-none">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Kelas Rombel</label>
                        <select name="kelas_id" id="s_kelas" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 outline-none">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($allKelas as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">No. HP / Kontak</label>
                        <input type="text" name="telepon" id="s_telepon" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleSiswaView('tabel')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-bold">Batal</button>
                    <button type="submit" id="btnSimpanSiswa" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl">Simpan Data</button>
                </div>
            </form>
        </div>

        <!-- Search Bar -->
        <div class="my-3">
            <input type="text" id="cariSiswa" onkeyup="filterSiswa()" placeholder="🔍 Cari siswa berdasarkan nama, NISN, atau kelas..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-xs focus:border-blue-500 outline-none">
        </div>

        <!-- Tabel Siswa -->
        <div class="overflow-y-auto flex-1 my-1">
            <table class="w-full text-left text-xs" id="tabelDataSiswa">
                <thead class="bg-slate-950/90 sticky top-0 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-3">NIS</th>
                        <th class="p-3">NISN</th>
                        <th class="p-3">Nama Siswa</th>
                        <th class="p-3">JK</th>
                        <th class="p-3">Rombel</th>
                        <th class="p-3">Kontak</th>
                        <th class="p-3 text-right">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($allSiswas as $s)
                        <tr class="hover:bg-slate-800/40 transition item-siswa">
                            <td class="p-3 font-mono text-slate-400">{{ $s->nis }}</td>
                            <td class="p-3 font-mono font-bold text-blue-400">{{ $s->nisn }}</td>
                            <td class="p-3 font-black text-white text-sm nama-siswa">{{ $s->nama }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $s->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                                    {{ $s->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 font-bold rounded-lg text-xs kelas-siswa">
                                    {{ $s->kelas->nama_kelas ?? 'Belum Diplot' }}
                                </span>
                            </td>
                            <td class="p-3 font-mono text-slate-400">{{ $s->telepon ?? '-' }}</td>
                            <td class="p-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editSiswa({{ json_encode($s) }})" class="px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/40 text-blue-300 border border-blue-500/30 font-bold rounded-lg text-[11px] transition">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('tu.siswa.destroy', $s->id_siswa) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa {{ $s->nama }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 border border-rose-500/30 font-bold rounded-lg text-[11px] transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">Belum ada data siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
            <span>Dapat mengedit dan menghapus data langsung dari panel ini.</span>
            <button onclick="closeModalData('modalDataSiswa')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: DATA GURU LENGKAP (LIHAT, TAMBAH, EDIT & HAPUS)                  -->
<!-- ========================================================================= -->
<div id="modalDataGuru" class="hidden fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-5">
    <div class="bg-slate-900 rounded-3xl max-w-5xl w-full p-6 shadow-2xl border border-slate-700 max-h-[92vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-teal-500/10 border border-teal-500/30 text-teal-400 flex items-center justify-center text-xl font-black">
                    👨‍🏫
                </div>
                <div>
                    <h3 class="font-black text-white text-lg">Data Tenaga Pendidik & Guru</h3>
                    <p class="text-xs text-slate-400">Total {{ $totalGuru }} Guru &bull; Kelola, Edit & Tambah Data Guru Langsung di Sini</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleGuruView('formTambah')" id="btnTambahGuru" class="px-4 py-2 bg-teal-600 hover:bg-teal-500 text-slate-950 rounded-xl text-xs font-black tracking-wide transition shadow-lg shadow-teal-600/30 flex items-center gap-1.5">
                    <span>+</span> Tambah Guru Baru
                </button>
                <button onclick="closeModalData('modalDataGuru')" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-base font-bold transition">&times;</button>
            </div>
        </div>

        <!-- FORM TAMBAH / EDIT GURU -->
        <div id="boxFormGuru" class="hidden my-4 p-5 rounded-2xl bg-slate-950 border border-teal-500/40">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h4 id="judulFormGuru" class="text-sm font-black text-teal-400">Tambah Guru Baru</h4>
                <button type="button" onclick="toggleGuruView('tabel')" class="text-xs text-slate-400 hover:text-white">&times; Batal</button>
            </div>

            <form id="formGuruAction" action="{{ route('tu.guru.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div id="guruMethodSpoof"></div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Nama Guru & Gelar *</label>
                        <input type="text" name="nama_guru" id="g_nama" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">NIP *</label>
                        <input type="text" name="nip" id="g_nip" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Email Resmi (Akun Login) *</label>
                        <input type="email" name="email" id="g_email" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-teal-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="g_jk" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-teal-500 outline-none">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="g_nohp" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Alamat</label>
                        <input type="text" name="alamat" id="g_alamat" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-teal-500 outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleGuruView('tabel')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-bold">Batal</button>
                    <button type="submit" id="btnSimpanGuru" class="px-5 py-2 bg-teal-600 hover:bg-teal-500 text-slate-950 font-black rounded-xl">Simpan Data Guru</button>
                </div>
            </form>
        </div>

        <!-- Tabel Guru -->
        <div class="overflow-y-auto flex-1 my-3">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/90 sticky top-0 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-3">NIP</th>
                        <th class="p-3">Nama Lengkap & Gelar</th>
                        <th class="p-3">JK</th>
                        <th class="p-3">Penugasan</th>
                        <th class="p-3">Kontak / Email</th>
                        <th class="p-3 text-right">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($allGurus as $g)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-3 font-mono font-bold text-teal-400">{{ $g->nip }}</td>
                            <td class="p-3 font-black text-white text-sm">{{ $g->nama_guru }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $g->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                                    {{ $g->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="p-3">
                                @if($g->kelasWali)
                                    <span class="px-2.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 rounded-lg font-bold text-xs">
                                        Wali Kelas {{ $g->kelasWali->nama_kelas }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-800 text-slate-400 rounded-lg text-xs font-semibold">
                                        Guru Mapel
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 text-slate-300">
                                <div>{{ $g->user->email ?? '-' }}</div>
                                <div class="font-mono text-slate-500 text-[11px]">{{ $g->no_hp ?? '-' }}</div>
                            </td>
                            <td class="p-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editGuru({{ json_encode($g) }})" class="px-3 py-1.5 bg-teal-600/20 hover:bg-teal-600/40 text-teal-300 border border-teal-500/30 font-bold rounded-lg text-[11px] transition">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('tu.guru.destroy', $g->id_guru) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru {{ $g->nama_guru }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 border border-rose-500/30 font-bold rounded-lg text-[11px] transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
            <span>Data guru langsung tersinkronisasi ke penugasan KBM.</span>
            <button onclick="closeModalData('modalDataGuru')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 3: DATA KELAS (LIHAT, TAMBAH, EDIT & HAPUS)                         -->
<!-- ========================================================================= -->
<div id="modalDataKelas" class="hidden fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-5">
    <div class="bg-slate-900 rounded-3xl max-w-4xl w-full p-6 shadow-2xl border border-slate-700 max-h-[92vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 flex items-center justify-center text-xl font-black">
                    🏫
                </div>
                <div>
                    <h3 class="font-black text-white text-lg">Data Rombongan Belajar (Kelas)</h3>
                    <p class="text-xs text-slate-400">Total {{ $totalKelas }} Rombel &bull; Kelola, Edit & Tambah Kelas Langsung di Sini</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleKelasView('formTambah')" id="btnTambahKelas" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-black tracking-wide transition shadow-lg shadow-indigo-600/30 flex items-center gap-1.5">
                    <span>+</span> Tambah Kelas Baru
                </button>
                <button onclick="closeModalData('modalDataKelas')" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-base font-bold transition">&times;</button>
            </div>
        </div>

        <!-- FORM TAMBAH / EDIT KELAS -->
        <div id="boxFormKelas" class="hidden my-4 p-5 rounded-2xl bg-slate-950 border border-indigo-500/40">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h4 id="judulFormKelas" class="text-sm font-black text-indigo-400">Tambah Kelas Baru</h4>
                <button type="button" onclick="toggleKelasView('tabel')" class="text-xs text-slate-400 hover:text-white">&times; Batal</button>
            </div>

            <form id="formKelasAction" action="{{ route('tu.kelas.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div id="kelasMethodSpoof"></div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Nama Kelas *</label>
                        <input type="text" name="nama_kelas" id="k_nama" required placeholder="Contoh: VII A, VIII B" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Tingkat *</label>
                        <select name="tingkat" id="k_tingkat" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 outline-none">
                            <option value="7">Kelas 7</option>
                            <option value="8">Kelas 8</option>
                            <option value="9">Kelas 9</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Tunjuk Wali Kelas</label>
                        <select name="guru_id" id="k_guru" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 outline-none">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($allGurus as $g)
                                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleKelasView('tabel')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-bold">Batal</button>
                    <button type="submit" id="btnSimpanKelas" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-xl">Simpan Rombel</button>
                </div>
            </form>
        </div>

        <!-- Grid Kelas -->
        <div class="overflow-y-auto flex-1 my-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($allKelas as $k)
                    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 flex flex-col justify-between hover:border-indigo-500/50 transition">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2.5 py-1 bg-indigo-500/10 text-indigo-400 font-black rounded-lg text-[10px]">
                                    TINGKAT {{ $k->tingkat }}
                                </span>
                                <span class="font-mono text-xs text-slate-300 font-bold">{{ $k->siswas->count() }} Siswa</span>
                            </div>
                            <h4 class="text-xl font-black text-white">{{ $k->nama_kelas }}</h4>
                            <span class="text-[11px] text-slate-500">Program: {{ $k->jurusan ?? 'Reguler' }}</span>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase block">Wali Kelas:</span>
                                <span class="text-xs font-bold text-amber-300">{{ $k->waliKelas->nama_guru ?? 'Belum Ditentukan' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="editKelas({{ json_encode($k) }})" class="p-1.5 rounded-lg bg-indigo-500/20 hover:bg-indigo-500/40 text-indigo-300 text-xs font-bold transition" title="Edit Rombel">
                                    ✏️
                                </button>
                                <form action="{{ route('tu.kelas.destroy', $k->id_kelas) }}" method="POST" onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 text-xs font-bold transition" title="Hapus Rombel">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 col-span-3 text-center py-8">Belum ada rombel kelas yang dibuat.</p>
                @endforelse
            </div>
        </div>

        <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
            <span>Rombongan belajar tahun ajaran aktif.</span>
            <button onclick="closeModalData('modalDataKelas')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 4: KURIKULUM & MAPEL (LIHAT, TAMBAH, EDIT & HAPUS)                  -->
<!-- ========================================================================= -->
<div id="modalDataMapel" class="hidden fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-5">
    <div class="bg-slate-900 rounded-3xl max-w-3xl w-full p-6 shadow-2xl border border-slate-700 max-h-[92vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl font-black">
                    📖
                </div>
                <div>
                    <h3 class="font-black text-white text-lg">Kurikulum & Mata Pelajaran</h3>
                    <p class="text-xs text-slate-400">Total {{ $totalMapel }} Mata Pelajaran &bull; Kelola & Edit Langsung di Sini</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleMapelView('formTambah')" id="btnTambahMapel" class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-slate-950 rounded-xl text-xs font-black tracking-wide transition shadow-lg shadow-amber-600/30 flex items-center gap-1.5">
                    <span>+</span> Tambah Mapel Baru
                </button>
                <button onclick="closeModalData('modalDataMapel')" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-base font-bold transition">&times;</button>
            </div>
        </div>

        <!-- FORM TAMBAH / EDIT MAPEL -->
        <div id="boxFormMapel" class="hidden my-4 p-5 rounded-2xl bg-slate-950 border border-amber-500/40">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h4 id="judulFormMapel" class="text-sm font-black text-amber-400">Tambah Mata Pelajaran Baru</h4>
                <button type="button" onclick="toggleMapelView('tabel')" class="text-xs text-slate-400 hover:text-white">&times; Batal</button>
            </div>

            <form id="formMapelAction" action="{{ route('tu.mapel.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div id="mapelMethodSpoof"></div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Kode Mapel *</label>
                        <input type="text" name="kode_mapel" id="m_kode" required placeholder="Contoh: MP-001" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Nama Mata Pelajaran *</label>
                        <input type="text" name="nama_mapel" id="m_nama" required placeholder="Contoh: Matematika" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">KKM Standar *</label>
                        <input type="number" name="kkm" id="m_kkm" required value="75" min="0" max="100" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono focus:border-amber-500 outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleMapelView('tabel')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-bold">Batal</button>
                    <button type="submit" id="btnSimpanMapel" class="px-5 py-2 bg-amber-600 hover:bg-amber-500 text-slate-950 font-black rounded-xl">Simpan Mapel</button>
                </div>
            </form>
        </div>

        <!-- Tabel Mapel -->
        <div class="overflow-y-auto flex-1 my-3">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/90 sticky top-0 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-3">Kode Mapel</th>
                        <th class="p-3">Nama Mata Pelajaran</th>
                        <th class="p-3 text-center">KKM</th>
                        <th class="p-3 text-right">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($allMapels as $m)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-3 font-mono font-bold text-amber-400">{{ $m->kode_mapel }}</td>
                            <td class="p-3 font-bold text-white text-sm">{{ $m->nama_mapel }}</td>
                            <td class="p-3 text-center">
                                <span class="px-2.5 py-1 bg-slate-950 border border-slate-800 rounded-lg font-mono font-black text-emerald-400 text-xs">
                                    {{ $m->kkm ?? 75 }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editMapel({{ json_encode($m) }})" class="px-3 py-1 bg-amber-500/20 hover:bg-amber-500/40 text-amber-300 border border-amber-500/30 font-bold rounded-lg text-[11px] transition">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('tu.mapel.destroy', $m->id_mata_pelajaran) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran {{ $m->nama_mapel }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 border border-rose-500/30 font-bold rounded-lg text-[11px] transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">Belum ada mata pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
            <span>Standar kurikulum nasional SMPN 1 Trimurjo.</span>
            <button onclick="closeModalData('modalDataMapel')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT KONTROL MODAL & MODE EDIT INLINE                               -->
<!-- ========================================================================= -->
<script>
    function openModalData(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModalData(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // 1. Logika Siswa (Tambah & Edit)
    function toggleSiswaView(mode) {
        const box = document.getElementById('boxFormSiswa');
        if (mode === 'formTambah') {
            document.getElementById('judulFormSiswa').innerText = 'Tambah Siswa Baru';
            document.getElementById('formSiswaAction').action = '{{ route("tu.siswa.store") }}';
            document.getElementById('siswaMethodSpoof').innerHTML = '';
            document.getElementById('s_nama').value = '';
            document.getElementById('s_nisn').value = '';
            document.getElementById('s_nis').value = '';
            document.getElementById('s_telepon').value = '';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    function editSiswa(data) {
        openModalData('modalDataSiswa');
        const box = document.getElementById('boxFormSiswa');
        document.getElementById('judulFormSiswa').innerText = 'Edit Data Siswa: ' + data.nama;
        document.getElementById('formSiswaAction').action = '/tu/siswa/' + data.id_siswa;
        document.getElementById('siswaMethodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('s_nama').value = data.nama || '';
        document.getElementById('s_nisn').value = data.nisn || '';
        document.getElementById('s_nis').value = data.nis || '';
        document.getElementById('s_jk').value = data.jenis_kelamin || 'L';
        document.getElementById('s_kelas').value = data.kelas_id || '';
        document.getElementById('s_telepon').value = data.telepon || '';

        box.classList.remove('hidden');
        box.scrollIntoView({ behavior: 'smooth' });
    }

    function filterSiswa() {
        const q = document.getElementById('cariSiswa').value.toLowerCase();
        const rows = document.querySelectorAll('#tabelDataSiswa .item-siswa');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    }

    // 2. Logika Guru (Tambah & Edit)
    function toggleGuruView(mode) {
        const box = document.getElementById('boxFormGuru');
        if (mode === 'formTambah') {
            document.getElementById('judulFormGuru').innerText = 'Tambah Guru Baru';
            document.getElementById('formGuruAction').action = '{{ route("tu.guru.store") }}';
            document.getElementById('guruMethodSpoof').innerHTML = '';
            document.getElementById('g_nama').value = '';
            document.getElementById('g_nip').value = '';
            document.getElementById('g_email').value = '';
            document.getElementById('g_nohp').value = '';
            document.getElementById('g_alamat').value = '';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    function editGuru(data) {
        openModalData('modalDataGuru');
        const box = document.getElementById('boxFormGuru');
        document.getElementById('judulFormGuru').innerText = 'Edit Data Guru: ' + data.nama_guru;
        document.getElementById('formGuruAction').action = '/tu/guru/' + data.id_guru;
        document.getElementById('guruMethodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('g_nama').value = data.nama_guru || '';
        document.getElementById('g_nip').value = data.nip || '';
        document.getElementById('g_email').value = (data.user ? data.user.email : '') || '';
        document.getElementById('g_jk').value = data.jenis_kelamin || 'L';
        document.getElementById('g_nohp').value = data.no_hp || '';
        document.getElementById('g_alamat').value = data.alamat || '';

        box.classList.remove('hidden');
        box.scrollIntoView({ behavior: 'smooth' });
    }

    // 3. Logika Kelas (Tambah & Edit)
    function toggleKelasView(mode) {
        const box = document.getElementById('boxFormKelas');
        if (mode === 'formTambah') {
            document.getElementById('judulFormKelas').innerText = 'Tambah Rombel Kelas Baru';
            document.getElementById('formKelasAction').action = '{{ route("tu.kelas.store") }}';
            document.getElementById('kelasMethodSpoof').innerHTML = '';
            document.getElementById('k_nama').value = '';
            document.getElementById('k_tingkat').value = '7';
            document.getElementById('k_guru').value = '';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    function editKelas(data) {
        openModalData('modalDataKelas');
        const box = document.getElementById('boxFormKelas');
        document.getElementById('judulFormKelas').innerText = 'Edit Rombel Kelas: ' + data.nama_kelas;
        document.getElementById('formKelasAction').action = '/tu/kelas/' + data.id_kelas;
        document.getElementById('kelasMethodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('k_nama').value = data.nama_kelas || '';
        document.getElementById('k_tingkat').value = data.tingkat || '7';
        document.getElementById('k_guru').value = data.guru_id || '';

        box.classList.remove('hidden');
        box.scrollIntoView({ behavior: 'smooth' });
    }

    // 4. Logika Mapel (Tambah & Edit)
    function toggleMapelView(mode) {
        const box = document.getElementById('boxFormMapel');
        if (mode === 'formTambah') {
            document.getElementById('judulFormMapel').innerText = 'Tambah Mata Pelajaran Baru';
            document.getElementById('formMapelAction').action = '{{ route("tu.mapel.store") }}';
            document.getElementById('mapelMethodSpoof').innerHTML = '';
            document.getElementById('m_kode').value = '';
            document.getElementById('m_nama').value = '';
            document.getElementById('m_kkm').value = '75';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    function editMapel(data) {
        openModalData('modalDataMapel');
        const box = document.getElementById('boxFormMapel');
        document.getElementById('judulFormMapel').innerText = 'Edit Mata Pelajaran: ' + data.nama_mapel;
        document.getElementById('formMapelAction').action = '/tu/mapel/' + data.id_mata_pelajaran;
        document.getElementById('mapelMethodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('m_kode').value = data.kode_mapel || '';
        document.getElementById('m_nama').value = data.nama_mapel || '';
        document.getElementById('m_kkm').value = data.kkm || 75;

        box.classList.remove('hidden');
        box.scrollIntoView({ behavior: 'smooth' });
    }

    // Tutup modal jika tekan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modalData"]').forEach(function(m) {
                m.classList.add('hidden');
            });
        }
    });
</script>
@endsection
