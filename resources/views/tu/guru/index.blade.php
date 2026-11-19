@extends('layouts.app')

@section('title', 'Data Tenaga Pendidik')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tu.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 font-bold hover:text-blue-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Data Tenaga Pendidik (Guru)</h1>
            <p class="text-slate-400 text-xs">Total Guru Terdaftar: <strong class="text-white">{{ $gurus->total() }} Pegawai</strong></p>
        </div>
        <button onclick="document.getElementById('modalTambahGuru').classList.remove('hidden')" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white rounded-xl text-xs font-extrabold tracking-wide transition shadow-lg shadow-teal-600/30 flex items-center gap-2">
            <span>+</span> TAMBAH GURU BARU
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">NIP</th>
                        <th class="p-4">Nama Lengkap & Gelar</th>
                        <th class="p-4">JK</th>
                        <th class="p-4">Email Login</th>
                        <th class="p-4">No. HP</th>
                        <th class="p-4">Tugas Tambahan</th>
                        <th class="p-4">Alamat Domisili</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($gurus as $g)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4 font-mono text-slate-300 font-bold">{{ $g->nip }}</td>
                            <td class="p-4 font-extrabold text-white text-sm">{{ $g->nama_guru }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black {{ $g->jenis_kelamin == 'L' ? 'bg-sky-500/10 text-sky-300 border border-sky-500/20' : 'bg-pink-500/10 text-pink-300 border border-pink-500/20' }}">
                                    {{ $g->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                </span>
                            </td>
                            <td class="p-4 font-mono text-blue-400 font-semibold">{{ $g->user->email ?? '-' }}</td>
                            <td class="p-4 text-slate-300 font-mono">{{ $g->no_hp ?? '-' }}</td>
                            <td class="p-4">
                                @if($g->kelasWali)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 font-bold rounded-lg text-xs">
                                        <span>👑</span> Wali Kelas {{ $g->kelasWali->nama_kelas }}
                                    </span>
                                @else
                                    <span class="text-slate-500 text-xs">Guru Mata Pelajaran</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-400 max-w-xs truncate">{{ $g->alamat ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-500">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $gurus->links() }}
        </div>
    </div>

</div>

<!-- Modal Tambah Guru Baru -->
<div id="modalTambahGuru" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-800 text-white">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
            <div>
                <span class="text-teal-400 text-xs font-bold uppercase tracking-wider">Formulir Tenaga Pendidik</span>
                <h3 class="font-extrabold text-white text-lg">Input Data Guru Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahGuru').classList.add('hidden')" class="text-slate-400 hover:text-white text-2xl font-bold">&times;</button>
        </div>

        <form action="{{ route('tu.guru.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Nomor Induk Pegawai (NIP) *</label>
                <input type="text" name="nip" required placeholder="contoh: 198501012010011005" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Nama Lengkap & Gelar *</label>
                <input type="text" name="nama_guru" required placeholder="contoh: Rahmat Hidayat, S.Pd." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">No. WhatsApp / HP</label>
                    <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Email Akun Login *</label>
                <input type="email" name="email" required placeholder="nama@smpn1trimurjo.sch.id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none">
                <span class="text-[10px] text-slate-400 mt-1 block">* Password default akun: <strong>password</strong></span>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" placeholder="Alamat domisili guru..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white focus:ring-2 focus:ring-teal-500 focus:outline-none"></textarea>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalTambahGuru').classList.add('hidden')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-500 text-white font-extrabold rounded-xl transition shadow-lg shadow-teal-600/30">
                    SIMPAN GURU
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
