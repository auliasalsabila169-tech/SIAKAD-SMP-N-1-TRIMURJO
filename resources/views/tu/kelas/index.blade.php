@extends('layouts.app')

@section('title', 'Data Rombongan Belajar')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tu.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 font-bold hover:text-blue-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Data Kelas & Rombongan Belajar</h1>
            <p class="text-slate-400 text-xs">Penetapan Wali Kelas, Tingkat Pendidikan, dan Kapasitas Rombel SMPN 1 Trimurjo</p>
        </div>
        <button onclick="document.getElementById('modalTambahKelas').classList.remove('hidden')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-extrabold tracking-wide transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
            <span>+</span> TAMBAH KELAS BARU
        </button>
    </div>

    <!-- Grid Card Kelas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($kelasList as $k)
            <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl flex flex-col justify-between hover:border-slate-700 transition relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 font-black rounded-lg text-xs">
                            TINGKAT {{ $k->tingkat }}
                        </span>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-950 border border-slate-800 rounded-lg">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-xs text-slate-300 font-mono font-bold">{{ $k->siswas->count() }} Siswa</span>
                        </div>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-2 tracking-tight">{{ $k->nama_kelas }}</h3>
                    <div class="inline-block px-2.5 py-1 bg-slate-800/80 rounded-md text-[11px] text-slate-400 font-medium">
                        Kurikulum: Merdeka / {{ $k->jurusan ?? 'Reguler' }}
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-800/80">
                    <span class="text-[10px] text-slate-400 uppercase font-black tracking-wider block">Wali Kelas Pengampu:</span>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="w-9 h-9 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                            WK
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-white truncate">
                                {{ $k->waliKelas->nama_guru ?? 'Belum Ditentukan' }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-mono">
                                NIP. {{ $k->waliKelas->nip ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-slate-900 border border-slate-800 p-12 rounded-3xl text-center text-slate-500">
                Belum ada data rombongan belajar yang terdaftar.
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Kelas Baru -->
<div id="modalTambahKelas" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-700">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-5">
            <div>
                <h3 class="font-black text-white text-base">Tambah Rombongan Belajar</h3>
                <p class="text-[11px] text-slate-400">Buat kelas baru dan tentukan guru wali kelas</p>
            </div>
            <button onclick="document.getElementById('modalTambahKelas').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-sm font-bold">&times;</button>
        </div>

        <form action="{{ route('tu.kelas.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Nama Kelas *</label>
                <input type="text" name="nama_kelas" required placeholder="Contoh: VII A, VIII B, IX C" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-medium">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Tingkat *</label>
                    <select name="tingkat" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                        <option value="7">Kelas 7</option>
                        <option value="8">Kelas 8</option>
                        <option value="9">Kelas 9</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Program / Jurusan</label>
                    <input type="text" name="jurusan" value="Reguler" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Tunjuk Wali Kelas</label>
                <select name="guru_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                    <option value="">-- Pilih Guru Sebagai Wali Kelas --</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id_guru }}">{{ $g->nama_guru }} (NIP: {{ $g->nip }})</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-5 border-t border-slate-800 flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('modalTambahKelas').classList.add('hidden')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl transition shadow-lg shadow-blue-600/30">
                    SIMPAN KELAS
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
