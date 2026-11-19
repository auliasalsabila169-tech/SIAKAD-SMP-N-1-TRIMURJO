@extends('layouts.app')

@section('title', 'Manajemen Jadwal Pelajaran')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tu.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 font-bold hover:text-blue-300 transition mb-1">
                <span>&larr;</span> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">Manajemen Jadwal Pelajaran (KBM)</h1>
            <p class="text-slate-400 text-xs">Kewenangan Tata Usaha: Penetapan & Pembuatan Jadwal Pelajaran Seluruh Rombel</p>
        </div>
        <button onclick="document.getElementById('modalTambahJadwal').classList.remove('hidden')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-black tracking-wide transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
            <span>+</span> BUAT JADWAL KBM BARU
        </button>
    </div>

    <!-- Filter Kelas -->
    <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('tu.jadwal.index') }}" class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Filter Kelas:</span>
            <select name="kelas_id" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs font-bold focus:border-blue-500 outline-none">
                <option value="">-- Tampilkan Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>
                        Kelas {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})
                    </option>
                @endforeach
            </select>
        </form>

        <span class="text-xs text-slate-400 font-mono">
            Total {{ $jadwals->count() }} Sesi Jadwal Terdaftar
        </span>
    </div>

    <!-- Tabel Jadwal Pelajaran -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Rombel Kelas</th>
                        <th class="p-4">Hari KBM</th>
                        <th class="p-4">Slot Jam</th>
                        <th class="p-4">Rentang Waktu</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru Pengampu</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($jadwals as $j)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 font-black rounded-lg text-xs">
                                    {{ $j->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-blue-500/10 border border-blue-500/30 text-blue-300 font-black rounded-lg text-xs">
                                    {{ $j->hari->nama_hari ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-white text-sm">
                                Jam Ke-{{ $j->jamPelajaran->urutan ?? '-' }}
                            </td>
                            <td class="p-4 font-mono text-slate-300 text-xs font-bold">
                                {{ $j->jamPelajaran->jam_mulai ?? '' }} &ndash; {{ $j->jamPelajaran->jam_selesai ?? '' }} WIB
                            </td>
                            <td class="p-4 font-extrabold text-white text-sm">
                                {{ $j->mataPelajaran->nama_mapel ?? '-' }}
                                <span class="text-[10px] text-slate-400 font-mono block font-normal">{{ $j->mataPelajaran->kode_mapel ?? '' }}</span>
                            </td>
                            <td class="p-4">
                                <span class="text-slate-200 font-bold text-xs block">{{ $j->guru->nama_guru ?? '-' }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">NIP. {{ $j->guru->nip ?? '-' }}</span>
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('tu.jadwal.destroy', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 border border-rose-500/30 font-bold rounded-lg text-[11px] transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-500">Belum ada jadwal KBM yang dibuat oleh Tata Usaha.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Buat Jadwal Baru -->
<div id="modalTambahJadwal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-700">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-5">
            <div>
                <h3 class="font-black text-white text-base">Buat Jadwal Pelajaran Baru</h3>
                <p class="text-[11px] text-slate-400">Penetapan jadwal KBM resmi oleh staf Tata Usaha</p>
            </div>
            <button onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-sm font-bold">&times;</button>
        </div>

        <form action="{{ route('tu.jadwal.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Rombel Kelas *</label>
                <select name="kelas_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ $kelasId == $k->id_kelas ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Mata Pelajaran *</label>
                <select name="mapel_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $m)
                        <option value="{{ $m->id_mata_pelajaran }}">{{ $m->nama_mapel }} ({{ $m->kode_mapel }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Guru Pengampu *</label>
                <select name="guru_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                    <option value="">-- Pilih Guru Pengampu --</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Hari *</label>
                    <select name="hari_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                        <option value="">-- Pilih Hari --</option>
                        @foreach($haris as $h)
                            <option value="{{ $h->id_hari }}">{{ $h->nama_hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5 uppercase text-[10px] tracking-wider">Jam Pelajaran *</label>
                    <select name="jam_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-blue-500 font-medium">
                        <option value="">-- Pilih Jam --</option>
                        @foreach($jams as $jam)
                            <option value="{{ $jam->id_jam_pelajaran }}">Jam ke-{{ $jam->urutan }} ({{ $jam->jam_mulai }} - {{ $jam->jam_selesai }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-800 flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl transition shadow-lg shadow-blue-600/30">
                    SIMPAN JADWAL
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

