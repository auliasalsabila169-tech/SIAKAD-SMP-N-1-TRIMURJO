<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIAKAD SMPN 1 Trimurjo</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                            950: '#0b1329',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #070d19;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom Modern Dark Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0b1329;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 9999px;
            border: 2px solid #0b1329;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
        }
        .active-nav {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.18) 0%, rgba(30, 64, 175, 0.25) 100%);
            border-left: 3px solid #3b82f6;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);
            font-weight: 700;
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
        .glass-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }
        .ambient-glow {
            background: radial-gradient(circle at 50% 0%, rgba(37, 99, 235, 0.12) 0%, transparent 65%);
        }
    </style>
</head>
<body class="text-slate-100 antialiased min-h-screen flex flex-col selection:bg-blue-600 selection:text-white ambient-glow">

    <!-- TOP NAVIGATION BAR DENGAN MENU 3 GARIS DI POJOK -->
    <header class="bg-slate-900/90 backdrop-blur-xl border-b border-slate-800/80 sticky top-0 z-40 shadow-xl no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand & Logo Resmi Sekolah -->
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 p-1 bg-slate-950/80 rounded-2xl border border-slate-700 shadow-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMPN 1 Trimurjo" class="w-full h-full object-contain drop-shadow">
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-base tracking-tight text-white leading-tight">SIAKAD TRIMURJO</span>
                            <span class="px-2 py-0.5 rounded-full bg-blue-500/15 border border-blue-400/30 text-blue-300 text-[10px] font-black uppercase tracking-wider">v2.5 RESMI</span>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">SMP Negeri 1 Trimurjo • Lampung Tengah</p>
                    </div>
                </div>

                <!-- User Profile & Action Menu 3 Garis di Pojok -->
                <div class="flex items-center gap-3.5">
                    @auth
                        @php
                            $user = Auth::user();
                            $roleName = $user->roles->first()?->name;
                            $roleBadgeColor = match($roleName) {
                                'Tata Usaha' => 'bg-amber-500/15 border-amber-500/30 text-amber-300',
                                'Wali Kelas' => 'bg-indigo-500/15 border-indigo-500/30 text-indigo-300',
                                'Guru'       => 'bg-emerald-500/15 border-emerald-500/30 text-emerald-300',
                                'Siswa'      => 'bg-sky-500/15 border-sky-500/30 text-sky-300',
                                default      => 'bg-blue-500/15 border-blue-400/30 text-blue-300',
                            };
                            $roleDotColor = match($roleName) {
                                'Tata Usaha' => 'bg-amber-400',
                                'Wali Kelas' => 'bg-indigo-400',
                                'Guru'       => 'bg-emerald-400',
                                'Siswa'      => 'bg-sky-400',
                                default      => 'bg-blue-400',
                            };
                        @endphp

                        <!-- User Profile Pill -->
                        <div class="hidden sm:flex items-center gap-3 py-1.5 px-3 rounded-2xl bg-slate-950/60 border border-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-xs shadow-md">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-xs text-white flex items-center gap-1.5 leading-tight">
                                    <span class="w-2 h-2 rounded-full {{ $roleDotColor }} animate-pulse"></span>
                                    <span>{{ $user->name }}</span>
                                </div>
                                <div class="text-[10px] uppercase tracking-wider font-extrabold font-mono mt-0.5">
                                    <span class="px-2 py-0.5 rounded-full border {{ $roleBadgeColor }}">
                                        @if($roleName)
                                            {{ $roleName }}
                                        @elseif($user->guru?->kelasWali)
                                            Wali Kelas {{ $user->guru->kelasWali->nama_kelas }}
                                        @elseif($user->guru)
                                            Guru Pengajar
                                        @elseif($user->siswa)
                                            Siswa Kelas {{ $user->siswa->kelas?->nama_kelas ?? 'VII' }}
                                        @else
                                            Pengguna
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL 3 GARIS (HAMBURGER MENU) DI POJOK TAMPILAN -->
                        <button type="button" onclick="toggleSidebarMenu()" class="p-3 rounded-2xl bg-slate-800/90 hover:bg-slate-700 text-white border border-slate-700/80 flex items-center justify-center transition shadow-lg group cursor-pointer hover:border-blue-500/50" title="Buka Menu Navigasi (3 Garis)">
                            <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- DRAWER / SLIDE-OVER MENU DARI TOMBOL 3 GARIS -->
    @auth
        <div id="drawerMenuBackdrop" onclick="toggleSidebarMenu()" class="hidden fixed inset-0 bg-slate-950/85 backdrop-blur-md z-50 transition-opacity"></div>

        <aside id="drawerMenuPanel" class="fixed top-0 right-0 h-full w-84 sm:w-96 bg-slate-900 border-l border-slate-800 z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">
            
            <!-- Drawer Header -->
            <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-950">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-xl">
                        📋
                    </div>
                    <div>
                        <h3 class="font-extrabold text-white text-base">Menu Navigasi</h3>
                        <p class="text-[11px] text-slate-400">Panel Kendali Pengguna</p>
                    </div>
                </div>
                <button type="button" onclick="toggleSidebarMenu()" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-lg font-bold transition cursor-pointer">&times;</button>
            </div>

            <!-- Identitas Pengguna di Drawer -->
            <div class="p-6 border-b border-slate-800/80 bg-slate-900/60">
                <div class="flex items-center gap-3.5">
                    <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-xl shadow-lg border border-blue-400/30">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="truncate">
                        <div class="font-extrabold text-sm text-white truncate">{{ $user->name }}</div>
                        <div class="text-[11px] text-slate-400 truncate font-mono">{{ $user->email }}</div>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full border text-[10px] font-black uppercase tracking-wider {{ $roleBadgeColor }}">
                            {{ $roleName ?? 'User' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- List Menu Navigasi Sesuai Hak Akses & Tugas Resmi -->
            <div class="flex-1 overflow-y-auto p-4 space-y-1.5 text-xs font-bold">
                <span class="block px-3 py-2 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                    MENU AKADEMIK TERPADU:
                </span>

                @if($roleName == 'Tata Usaha' || (!$roleName && !$user->guru && !$user->siswa))
                    <a href="{{ route('tu.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tu.dashboard') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📊</span>
                        <span>Dashboard Utama TU</span>
                    </a>
                    <a href="{{ route('tu.jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tu.jadwal.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📅</span>
                        <span>Buat & Kelola Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('tu.nilai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tu.nilai.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📑</span>
                        <span>Rekap & Pengesahan Nilai Kelas</span>
                    </a>
                    
                    <span class="block px-3 pt-4 pb-1.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        DATA POKOK PENDIDIKAN:
                    </span>
                    <a href="{{ route('tu.siswa.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('tu.siswa.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">🎓</span>
                        <span>Data Siswa Induk</span>
                    </a>
                    <a href="{{ route('tu.guru.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('tu.guru.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">👨‍🏫</span>
                        <span>Data Tenaga Pendidik</span>
                    </a>
                    <a href="{{ route('tu.kelas.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('tu.kelas.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">🏫</span>
                        <span>Data Rombel Kelas</span>
                    </a>

                @elseif($roleName == 'Wali Kelas' || ($user->guru && $user->guru->kelasWali))
                    <a href="{{ route('walas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('walas.dashboard') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📊</span>
                        <span>Dashboard Wali Kelas</span>
                    </a>
                    <a href="{{ route('walas.jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('walas.jadwal.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📅</span>
                        <span>Cek Jadwal KBM Kelas Binaan</span>
                    </a>
                    <a href="{{ route('walas.nilai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('walas.nilai.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📑</span>
                        <span>Rekap Semua Nilai dari Guru Mapel</span>
                    </a>
                    <a href="{{ route('walas.leger.cetak') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-500/10 text-amber-300 border border-amber-500/30 hover:bg-amber-500/20 transition font-bold">
                        <span class="text-base">🖨️</span>
                        <span>Cetak Leger Nilai Resmi</span>
                    </a>

                @elseif($roleName == 'Guru' || $user->guru)
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('guru.dashboard') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📚</span>
                        <span>Jadwal Mengajar Saya</span>
                    </a>
                    <a href="{{ route('guru.nilai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('guru.nilai.*') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">✍️</span>
                        <span>Menu Input Nilai Siswa</span>
                    </a>

                @elseif($roleName == 'Siswa' || $user->siswa)
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('siswa.dashboard') ? 'active-nav' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">📈</span>
                        <span>Jadwal Belajar & Rapor Siswa</span>
                    </a>
                @endif
            </div>

            <!-- Drawer Footer: Logout -->
            <div class="p-5 border-t border-slate-800 bg-slate-950">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-500/30 text-xs font-black tracking-wider uppercase transition flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <span>🚪</span>
                        <span>KELUAR DARI SISTEM</span>
                    </button>
                </form>
            </div>

        </aside>

        <script>
            function toggleSidebarMenu() {
                const backdrop = document.getElementById('drawerMenuBackdrop');
                const panel = document.getElementById('drawerMenuPanel');
                if (panel.classList.contains('translate-x-full')) {
                    panel.classList.remove('translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    panel.classList.add('translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const panel = document.getElementById('drawerMenuPanel');
                    if (panel && !panel.classList.contains('translate-x-full')) {
                        toggleSidebarMenu();
                    }
                }
            });
        </script>
    @endauth

    <!-- CONTENT WRAPPER -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1">
        
        <!-- Alerts & Notification Banners -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 text-xs font-semibold flex items-center justify-between shadow-xl shadow-emerald-950/40 no-print animate-fade-in">
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-sm">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white font-black text-base px-2 cursor-pointer">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs font-semibold flex items-center justify-between shadow-xl shadow-rose-950/40 no-print animate-fade-in">
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-xl bg-rose-500/20 border border-rose-400/30 flex items-center justify-center text-sm">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white font-black text-base px-2 cursor-pointer">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER RESMI (Bersih, Minimalis & Elegan) -->
    <footer class="bg-slate-900/90 border-t border-slate-800/80 py-6 text-center text-xs text-slate-500 no-print mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                <span>© {{ date('Y') }} <strong class="text-slate-300">SMP Negeri 1 Trimurjo</strong> • Sistem Informasi Akademik Terpadu</span>
            </div>
            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-mono">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">MySQL Database</span>
                <span>•</span>
                <span class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-300 border border-blue-500/20">Kurikulum Merdeka</span>
            </div>
        </div>
    </footer>

</body>
</html>
