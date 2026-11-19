<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - SIAKAD SMP Negeri 1 Trimurjo</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #050811;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .hero-pattern {
            background-image: 
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.25) 0%, transparent 55%),
                radial-gradient(circle at bottom left, rgba(30, 64, 175, 0.28) 0%, transparent 60%),
                linear-gradient(135deg, rgba(5, 9, 20, 0.96) 0%, rgba(11, 22, 52, 0.92) 50%, rgba(3, 7, 16, 0.98) 100%),
                url('{{ asset('images/gedung-sekolah.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .glass-panel {
            background: rgba(11, 17, 32, 0.88);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25), 0 0 24px rgba(59, 130, 246, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 selection:bg-blue-600 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Background Glows -->
    <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[160px] pointer-events-none"></div>

    <!-- Container Utama Card Login Eksekutif -->
    <div class="max-w-5xl w-full glass-panel rounded-[32px] shadow-[0_30px_90px_rgba(0,0,0,0.75)] overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[690px] relative z-10 border border-slate-800/80">
        
        <!-- KOLOM KIRI: IDENTITAS RESMI SEKOLAH & AKUN PENGUJIAN CEPAT (7 Col) -->
        <div class="lg:col-span-7 hero-pattern p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden text-white border-b lg:border-b-0 lg:border-r border-slate-800/80">
            
            <!-- Top Header & Badges Resmi Sekolah -->
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 p-2 bg-slate-950/90 backdrop-blur-2xl rounded-2xl border border-white/20 shadow-2xl flex items-center justify-center shrink-0 ring-1 ring-white/10">
                        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-black uppercase tracking-widest border border-blue-400/30 shadow-sm">
                                SISTEM RESMI
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-extrabold border border-amber-400/30 flex items-center gap-1 shadow-sm">
                                <span>⭐</span> TERAKREDITASI A
                            </span>
                        </div>
                        <h2 class="font-black text-base sm:text-lg text-white tracking-tight leading-snug">
                            SMP NEGERI 1 TRIMURJO
                        </h2>
                        <p class="text-[11px] text-slate-400 font-medium">Kabupaten Lampung Tengah</p>
                    </div>
                </div>

                <div class="space-y-4 max-w-lg mt-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-950/70 text-blue-300 text-xs font-bold rounded-xl border border-blue-500/30 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="font-mono text-[11px] tracking-wide">NPSN: 10802082 &bull; SIAKAD TERPADU v2.5</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.12] tracking-tight">
                        Sistem Informasi Akademik Sekolah
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-normal">
                        Layanan digital terintegrasi untuk pengelolaan kurikulum, jadwal KBM, penilaian capaian kompetensi peserta didik, serta penerbitan Leger Nilai resmi secara akuntabel.
                    </p>
                </div>
            </div>

            <!-- Bottom Quick Demo Accounts -->
            <div class="relative z-10 mt-10 pt-6 border-t border-white/10">
                <div class="flex items-center justify-between mb-3.5">
                    <span class="text-[11px] font-extrabold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="text-amber-400">⚡</span> Akun Pengujian Cepat (Klik untuk Otomatis Mengisi):
                    </span>
                    <span class="text-[10px] text-emerald-400 font-bold font-mono flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        LAYANAN AKTIF
                    </span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
                    <!-- TU -->
                    <button type="button" onclick="fillDemo('tu@smpn1trimurjo.sch.id', 'password')" class="p-3 rounded-2xl bg-slate-950/70 hover:bg-amber-600/20 backdrop-blur-md border border-white/10 hover:border-amber-400/60 text-left transition duration-200 group cursor-pointer active:scale-95 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] text-amber-300 font-black group-hover:text-amber-200">TATA USAHA</span>
                            <span class="text-xs">💼</span>
                        </div>
                        <span class="font-mono text-[11px] text-white font-bold truncate block">Staf TU</span>
                        <span class="text-[9px] text-slate-400 block truncate">Jadwal & ACC</span>
                    </button>

                    <!-- Walas (Pak Arya) -->
                    <button type="button" onclick="fillDemo('aryapratama19@gmail.com', 'password')" class="p-3 rounded-2xl bg-slate-950/70 hover:bg-indigo-600/20 backdrop-blur-md border border-white/10 hover:border-indigo-400/60 text-left transition duration-200 group cursor-pointer active:scale-95 shadow-sm" title="Akun Wali Kelas VII B (Pak Arya)">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] text-indigo-300 font-black group-hover:text-indigo-200">WALI KELAS</span>
                            <span class="text-xs">📋</span>
                        </div>
                        <span class="font-mono text-[11px] text-white font-bold truncate block">Pak Arya</span>
                        <span class="text-[9px] text-slate-400 block truncate">Leger Kelas VII B</span>
                    </button>

                    <!-- Guru -->
                    <button type="button" onclick="fillDemo('budi@smpn1trimurjo.sch.id', 'password')" class="p-3 rounded-2xl bg-slate-950/70 hover:bg-emerald-600/20 backdrop-blur-md border border-white/10 hover:border-emerald-400/60 text-left transition duration-200 group cursor-pointer active:scale-95 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] text-emerald-300 font-black group-hover:text-emerald-200">GURU</span>
                            <span class="text-xs">✍️</span>
                        </div>
                        <span class="font-mono text-[11px] text-white font-bold truncate block">Bpk. Budi</span>
                        <span class="text-[9px] text-slate-400 block truncate">Input Nilai Mapel</span>
                    </button>

                    <!-- Siswa -->
                    <button type="button" onclick="fillDemo('0091234567', 'password')" class="p-3 rounded-2xl bg-slate-950/70 hover:bg-sky-600/20 backdrop-blur-md border border-white/10 hover:border-sky-400/60 text-left transition duration-200 group cursor-pointer active:scale-95 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] text-sky-300 font-black group-hover:text-sky-200">SISWA</span>
                            <span class="text-xs">🎓</span>
                        </div>
                        <span class="font-mono text-[11px] text-white font-bold truncate block">Ahmad (NISN)</span>
                        <span class="text-[9px] text-slate-400 block truncate">Rapor & Jadwal</span>
                    </button>
                </div>
                <div class="text-[10px] text-slate-400 mt-3.5 flex items-center justify-between">
                    <span>Sandi Akses Default: <strong class="text-white font-mono bg-white/10 px-2 py-0.5 rounded">password</strong></span>
                    <span class="text-slate-400 font-mono">SMP NEGERI 1 TRIMURJO</span>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM LOGIN RESMI & ELEGAN (5 Col) -->
        <div class="lg:col-span-5 p-8 sm:p-12 flex flex-col justify-center bg-slate-950/95 text-white relative">
            
            <div class="mb-7">
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 font-extrabold text-[10px] uppercase tracking-widest mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>AUTENTIKASI PENGGUNA</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Masuk Akun</h3>
                <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">
                    Masukkan <strong>Email Dinas</strong> (Guru/Staf) atau <strong>Nomor NISN</strong> (Siswa) beserta kata sandi Anda.
                </p>
            </div>

            @if($errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold flex items-center gap-2.5 shadow-lg shadow-rose-950/30">
                    <span class="text-base">⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2.5 shadow-lg shadow-emerald-950/30">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider flex items-center justify-between">
                        <span>Email Resmi atau NISN Siswa</span>
                        <span class="text-[10px] font-mono text-slate-500">Wajib diisi</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="login_id" id="login_id" 
                            value="{{ old('login_id', 'tu@smpn1trimurjo.sch.id') }}" required autofocus
                            placeholder="nama@smpn1trimurjo.sch.id / 0091234567"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/15 focus:outline-none transition font-medium input-glow">
                        <svg class="w-4 h-4 text-slate-400 absolute left-4 top-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                        <a href="javascript:alert('Silakan hubungi ruang Tata Usaha SMPN 1 Trimurjo untuk permohonan reset sandi akun Anda.');" class="text-blue-400 hover:text-blue-300 text-xs font-semibold transition">
                            Lupa sandi?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password" value="password" required
                            placeholder="••••••••"
                            class="w-full pl-11 pr-12 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-blue-500 focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/15 focus:outline-none transition font-medium input-glow">
                        <svg class="w-4 h-4 text-slate-400 absolute left-4 top-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-white p-1 transition cursor-pointer" title="Tampilkan/Sembunyikan Sandi">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-400 cursor-pointer select-none">
                        <input type="checkbox" name="remember" checked class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-950">
                        <span class="text-slate-300 font-medium">Ingat sesi perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-500 hover:to-indigo-500 text-white rounded-2xl text-sm font-extrabold tracking-wide uppercase shadow-lg shadow-blue-600/30 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2.5 cursor-pointer mt-2 group">
                    <span>MASUK SEKARANG</span>
                    <span class="group-hover:translate-x-1 transition">&rarr;</span>
                </button>
            </form>

            <!-- FITUR DAFTAR SEKARANG (BERSIH & ELEGAN) -->
            <div class="mt-7 pt-6 border-t border-slate-800/80">
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-4 text-center">
                    <p class="text-xs text-slate-400 mb-2.5 font-medium">
                        Belum memiliki akun?
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl bg-slate-800 hover:bg-blue-600/20 text-blue-400 hover:text-blue-300 font-black text-xs uppercase tracking-wider border border-blue-500/30 hover:border-blue-500/50 transition shadow-sm active:scale-98">
                        <span>✨</span>
                        <span>DAFTAR SEKARANG</span>
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" onclick="alert('Ruang Administrasi SMPN 1 Trimurjo\nJam Pelayanan: Senin - Sabtu (07.00 - 14.00 WIB)\nKontak: Ruang Tata Usaha SMPN 1 Trimurjo\nKabupaten Lampung Tengah');" class="text-[11px] text-slate-500 hover:text-slate-300 transition inline-flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Bantuan Sistem & Administrator</span>
                    </button>
                </div>
            </div>

        </div>

    </div>

    <script>
        function fillDemo(login, pwd) {
            document.getElementById('login_id').value = login;
            document.getElementById('password').value = pwd;
            document.getElementById('login_id').focus();
        }

        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.innerText = '🙈';
            } else {
                pwdInput.type = 'password';
                eyeIcon.innerText = '👁️';
            }
        }
    </script>

</body>
</html>
