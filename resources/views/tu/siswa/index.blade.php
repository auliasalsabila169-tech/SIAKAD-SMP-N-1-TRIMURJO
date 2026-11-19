@extends('layouts.app')

@section('title', 'Data Siswa - Buku Induk')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tu.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 font-bold hover:text-blue-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Data Induk Siswa (Buku Induk)</h1>
            <p class="text-slate-400 text-xs">Standar Kurikulum Nasional & 94 Atribut Buku Induk Kemendikbud</p>
        </div>
        <button onclick="document.getElementById('modalTambahSiswa').classList.remove('hidden')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-extrabold tracking-wide transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
            <span>+</span> TAMBAH SISWA BARU
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">NIS</th>
                        <th class="p-4">NISN (Akun Login)</th>
                        <th class="p-4">Nama Peserta Didik</th>
                        <th class="p-4">JK</th>
                        <th class="p-4">Rombel</th>
                        <th class="p-4">Tempat, Tanggal Lahir</th>
                        <th class="p-4">Alamat Domisili</th>
                        <th class="p-4">Status Akun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($siswas as $s)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4 font-mono text-slate-400 font-semibold">{{ $s->nis }}</td>
                            <td class="p-4 font-mono font-bold text-blue-400 text-sm">{{ $s->nisn }}</td>
                            <td class="p-4 font-extrabold text-white text-sm">{{ $s->nama }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black {{ $s->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                                    {{ $s->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 font-bold rounded-lg text-xs">
                                    {{ $s->kelas->nama_kelas ?? 'Belum Diplot' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? date('d/m/Y', strtotime($s->tanggal_lahir)) : '-' }}</td>
                            <td class="p-4 text-slate-400 max-w-xs truncate">{{ $s->alamat ?? '-' }}</td>
                            <td class="p-4">
                                @if($s->user_id)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 font-bold rounded-lg text-[10px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Aktif (NISN)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-800 text-slate-500 rounded-lg text-[10px]">Manual</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center text-slate-500">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $siswas->links() }}
        </div>
    </div>

</div>

<!-- Modal Tambah Siswa Baru (Tegas, Elegan) -->
<div id="modalTambahSiswa" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-800 max-h-[90vh] overflow-y-auto text-white">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
            <div>
                <span class="text-blue-400 text-xs font-bold uppercase tracking-wider">Formulir Pendaftaran</span>
                <h3 class="font-extrabold text-white text-lg">Input Data Siswa Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="text-slate-400 hover:text-white text-2xl font-bold">&times;</button>
        </div>

        <form action="{{ route('tu.siswa.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Nomor Induk Siswa (NIS) *</label>
                    <input type="text" name="nis" required placeholder="contoh: 24003" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">NISN * (Untuk Login Akun Siswa)</label>
                    <input type="text" name="nisn" required placeholder="contoh: 0091234569" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Nama Lengkap Peserta Didik *</label>
                <input type="text" name="nama" required placeholder="Nama lengkap siswa" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Rombel / Kelas Awal *</label>
                    <select name="kelas_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="contoh: Lampung Tengah" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" placeholder="Nama dusun, RT/RW, desa..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-extrabold rounded-xl transition shadow-lg shadow-blue-600/30">
                    SIMPAN & BUAT AKUN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
