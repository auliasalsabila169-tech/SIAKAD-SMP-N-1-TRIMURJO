<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Baru - SIAKAD SMP Negeri 1 Trimurjo</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .hero-pattern {
            background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.94) 0%, rgba(30, 58, 138, 0.90) 50%, rgba(15, 23, 42, 0.96) 100%), url('{{ asset('images/gedung-sekolah.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        input[type="date"] {
            color-scheme: dark;
            cursor: pointer;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(1.2);
            cursor: pointer;
            opacity: 0.9;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
            background-color: rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="max-w-4xl w-full bg-slate-900 rounded-[28px] shadow-2xl overflow-hidden border border-slate-800">
        
        <!-- Header Section -->
        <div class="hero-pattern p-6 sm:p-8 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-14 h-14 p-1.5 bg-slate-950/80 backdrop-blur-md rounded-2xl border border-white/20 shadow-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/30 text-blue-300 text-[10px] font-extrabold uppercase tracking-widest border border-blue-400/30 mb-0.5">
                        REGISTRASI PENGGUNA BARU
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                        Pendaftaran Akun SIAKAD SMPN 1 Trimurjo
                    </h1>
                </div>
            </div>

            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-bold transition border border-slate-700 w-fit">
                <span>&larr;</span>
                <span>Sudah Punya Akun? Masuk</span>
            </a>
        </div>

        <!-- Alert Error -->
        @if($errors->any())
            <div class="m-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span>⚠️</span>
                    <span>Terdapat beberapa kesalahan data input:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6 sm:p-10">
            
            <!-- Role Toggle Selector -->
            <div class="mb-8">
                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                    PILIH JENIS PENDAFTARAN:
                </span>
                <div class="grid grid-cols-2 gap-4 max-w-md">
                    <button type="button" id="tabBtnSiswa" onclick="switchRole('siswa')" class="p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-blue-500 bg-blue-500/10 text-blue-400 shadow-lg shadow-blue-500/10">
                        <span class="text-lg">🎒</span>
                        <span>DAFTAR SEBAGAI SISWA</span>
                    </button>
                    <button type="button" id="tabBtnGuru" onclick="switchRole('guru')" class="p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-slate-800 bg-slate-950/60 text-slate-400 hover:border-slate-700">
                        <span class="text-lg">👨‍🏫</span>
                        <span>DAFTAR SEBAGAI GURU</span>
                    </button>
                </div>
            </div>

            <!-- FORM 1: PENDAFTARAN SISWA -->
            <form id="formSiswa" action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role_type" value="siswa">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Nama Lengkap Peserta Didik *
                        </label>
                        <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Ahmad Rizky Pratama" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            NISN (Digunakan untuk Login) *
                        </label>
                        <input type="number" name="nisn" required value="{{ old('nisn') }}" placeholder="10 Digit NISN Kemendikbud" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none font-mono transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            NIS (Nomor Induk Siswa di Sekolah) *
                        </label>
                        <input type="number" name="nis" required value="{{ old('nis') }}" placeholder="Contoh: 8901" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none font-mono transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Tingkat Kelas Siswa *
                            </label>
                            <span class="text-[10px] text-blue-400 font-bold">⚡ Rombel Otomatis</span>
                        </div>
                        <select name="tingkat" id="pilihTingkat" required onchange="tampilkanRombelOtomatis(this.value)" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-blue-500 focus:outline-none transition font-medium">
                            <option value="">-- Pilih Tingkat Kelas --</option>
                            <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>Tingkat 7</option>
                            <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>Tingkat 8</option>
                            <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>Tingkat 9</option>
                        </select>
                        <p id="infoRombelOtomatis" class="text-[11px] text-slate-400 mt-1.5 hidden font-medium">
                            Rombel kelas (<span id="labelRombelOtomatis" class="font-bold text-blue-400 font-mono">VII A</span>, dst.) dialokasikan secara otomatis oleh sistem sekolah.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Jenis Kelamin *
                        </label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-blue-500 focus:outline-none transition font-medium">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Trimurjo, Lampung Tengah" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Tanggal Lahir
                        </label>
                        <div class="relative">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                                onclick="this.showPicker()"
                                class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-blue-500 focus:outline-none cursor-pointer transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Nomor HP / WhatsApp
                        </label>
                        <input type="tel" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none font-mono transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Agama
                        </label>
                        <select name="agama" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-blue-500 focus:outline-none transition font-medium">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Alamat Domisili Siswa
                        </label>
                        <textarea name="alamat" rows="2" placeholder="Nama Jalan, Desa, RT/RW, Kecamatan Trimurjo" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none transition">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Kata Sandi Baru *
                        </label>
                        <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Konfirmasi Kata Sandi *
                        </label>
                        <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi kata sandi" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:outline-none transition">
                    </div>

                </div>

                <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400">
                        * Setelah mendaftar, akun siswa langsung aktif dan dapat login menggunakan <strong>NISN</strong>.
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-blue-600/30 transition">
                        DAFTARKAN AKUN SISWA SEKARANG
                    </button>
                </div>
            </form>

            <!-- FORM 2: PENDAFTARAN GURU (HIDDEN BY DEFAULT) -->
            <form id="formGuru" action="{{ route('register.post') }}" method="POST" class="space-y-5 hidden">
                @csrf
                <input type="hidden" name="role_type" value="guru">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Nama Lengkap Guru Beserta Gelar *
                        </label>
                        <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Dra. Siti Rahmawati, M.Pd." class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            NIP / NUPTK *
                        </label>
                        <input type="text" name="nip" required value="{{ old('nip') }}" placeholder="19xxxxxxxxxxxxxxxx" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none font-mono transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Alamat Email Resmi (Digunakan untuk Login) *
                        </label>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="nama@smpn1trimurjo.sch.id" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none font-medium transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Jenis Kelamin *
                        </label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-teal-500 focus:outline-none transition font-medium">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Nomor HP / WhatsApp
                        </label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none font-mono transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Alamat Domisili
                        </label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap tempat tinggal" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none transition">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Kata Sandi Baru *
                        </label>
                        <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">
                            Konfirmasi Kata Sandi *
                        </label>
                        <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi kata sandi" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-teal-500 focus:outline-none transition">
                    </div>

                </div>

                <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400">
                        * Akun Guru terhubung langsung dengan sistem KBM dan manajemen penilaian mata pelajaran.
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-teal-600 hover:bg-teal-500 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-teal-600/30 transition">
                        DAFTARKAN AKUN GURU SEKARANG
                    </button>
                </div>
            </form>

        </div>

    </div>

    <script>
        function switchRole(role) {
            const formSiswa = document.getElementById('formSiswa');
            const formGuru = document.getElementById('formGuru');
            const btnSiswa = document.getElementById('tabBtnSiswa');
            const btnGuru = document.getElementById('tabBtnGuru');

            if (role === 'siswa') {
                formSiswa.classList.remove('hidden');
                formGuru.classList.add('hidden');

                btnSiswa.className = "p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-blue-500 bg-blue-500/10 text-blue-400 shadow-lg shadow-blue-500/10";
                btnGuru.className = "p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-slate-800 bg-slate-950/60 text-slate-400 hover:border-slate-700";
            } else {
                formSiswa.classList.add('hidden');
                formGuru.classList.remove('hidden');

                btnGuru.className = "p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-teal-500 bg-teal-500/10 text-teal-300 shadow-lg shadow-teal-500/10";
                btnSiswa.className = "p-3.5 rounded-2xl border-2 transition flex items-center justify-center gap-2.5 font-black text-xs uppercase tracking-wider border-slate-800 bg-slate-950/60 text-slate-400 hover:border-slate-700";
            }
        }
        function tampilkanRombelOtomatis(tingkat) {
            const info = document.getElementById('infoRombelOtomatis');
            const label = document.getElementById('labelRombelOtomatis');
            if (tingkat) {
                let contoh = tingkat === '7' ? 'VII A / VII B' : (tingkat === '8' ? 'VIII A / VIII B' : 'IX A / IX B');
                label.innerText = contoh;
                info.classList.remove('hidden');
            } else {
                info.classList.add('hidden');
            }
        }

        // Jalankan saat pertama kali dimuat jika ada nilai sebelumnya
        document.addEventListener('DOMContentLoaded', function() {
            const selectTingkat = document.getElementById('pilihTingkat');
            if (selectTingkat && selectTingkat.value) {
                tampilkanRombelOtomatis(selectTingkat.value);
            }
        });
    </script>

</body>
</html>

