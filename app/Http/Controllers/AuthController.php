<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Tampilkan formulir pendaftaran akun baru (Siswa & Guru)
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('auth.register', compact('kelasList'));
    }

    /**
     * Proses pendaftaran akun baru untuk Siswa atau Guru
     */
    public function register(Request $request)
    {
        $role = $request->input('role_type');

        if ($role === 'siswa') {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nisn' => 'required|numeric|digits_between:5,20|unique:siswas,nisn',
                'nis' => 'required|numeric|digits_between:3,20|unique:siswas,nis',
                'jenis_kelamin' => 'required|in:L,P',
                'tingkat' => 'nullable|in:7,8,9',
                'kelas_id' => 'nullable|exists:kelas,id_kelas',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'nama.required' => 'Nama lengkap wajib diisi.',
                'nisn.required' => 'NISN wajib diisi.',
                'nisn.unique' => 'NISN tersebut sudah terdaftar di sistem.',
                'nis.required' => 'NIS wajib diisi.',
                'nis.unique' => 'NIS tersebut sudah terdaftar di sistem.',
                'jenis_kelamin.required' => 'Pilih jenis kelamin.',
                'password.required' => 'Kata sandi wajib diisi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]);

            $assignedKelasNama = 'VII A';

            DB::transaction(function () use ($request, &$assignedKelasNama) {
                // Email akun siswa dibentuk dari NISN atau opsional
                $email = $request->email ? trim($request->email) : $request->nisn . '@siswa.smpn1trimurjo.sch.id';

                $user = User::create([
                    'name' => $request->nama,
                    'email' => $email,
                    'password' => Hash::make($request->password),
                ]);

                $user->assignRole('Siswa');

                // Alokasi otomatis rombel kelas berdasarkan pilihan Tingkat (7, 8, atau 9)
                $tingkat = $request->input('tingkat', '7') ?: '7';
                
                if ($request->filled('kelas_id')) {
                    $targetKelas = Kelas::find($request->kelas_id);
                } else {
                    // Cari kelas di tingkat yang dipilih dengan jumlah siswa paling sedikit agar merata
                    $targetKelas = Kelas::where('tingkat', (string)$tingkat)
                        ->withCount('siswas')
                        ->orderBy('siswas_count', 'asc')
                        ->orderBy('nama_kelas', 'asc')
                        ->first();

                    if (!$targetKelas) {
                        $namaDefault = match((string)$tingkat) {
                            '8' => 'VIII A',
                            '9' => 'IX A',
                            default => 'VII A',
                        };
                        $targetKelas = Kelas::firstOrCreate(
                            ['nama_kelas' => $namaDefault, 'tingkat' => (string)$tingkat],
                            ['jurusan' => 'Umum']
                        );
                    }
                }

                $assignedKelasNama = $targetKelas->nama_kelas;

                Siswa::create([
                    'user_id' => $user->id_user,
                    'kelas_id' => $targetKelas->id_kelas,
                    'nis' => $request->nis,
                    'nisn' => $request->nisn,
                    'nama' => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'agama' => $request->agama ?? 'Islam',
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                ]);
            });

            return redirect()->route('login')->with('success', "Akun Siswa berhasil didaftarkan! Rombel otomatis Anda: Kelas {$assignedKelasNama}. Silakan masuk menggunakan NISN dan kata sandi Anda.");

        } elseif ($role === 'guru') {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|max:50|unique:guru,nip',
                'email' => 'required|email|max:255|unique:users,email',
                'jenis_kelamin' => 'required|in:L,P',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'nama.required' => 'Nama lengkap dan gelar guru wajib diisi.',
                'nip.required' => 'NIP guru wajib diisi.',
                'nip.unique' => 'NIP tersebut sudah terdaftar di sistem.',
                'email.required' => 'Alamat email dinas/pribadi wajib diisi.',
                'email.unique' => 'Email tersebut sudah digunakan akun lain.',
                'password.required' => 'Kata sandi wajib diisi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]);

            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->nama,
                    'email' => strtolower(trim($request->email)),
                    'password' => Hash::make($request->password),
                ]);

                $user->assignRole('Guru');

                Guru::create([
                    'user_id' => $user->id_user,
                    'nip' => $request->nip,
                    'nama_guru' => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                ]);
            });

            return redirect()->route('login')->with('success', 'Akun Guru berhasil didaftarkan! Silakan masuk menggunakan Email dan kata sandi Anda.');
        }

        return back()->withErrors(['role_type' => 'Silakan pilih peran yang ingin didaftarkan (Siswa atau Guru).']);
    }

    /**
     * Proses otentikasi login fleksibel (Email atau NISN Siswa)
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ], [
            'login_id.required' => 'Email atau NISN wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = trim($request->input('login_id'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 1. Cari user berdasarkan Email
        $user = User::where('email', $loginInput)->first();

        // 2. Jika tidak ditemukan dan input berupa angka, cari via NISN atau NIS Siswa
        if (!$user) {
            $siswa = Siswa::where('nisn', $loginInput)->orWhere('nis', $loginInput)->first();
            if ($siswa && $siswa->user_id) {
                $user = User::find($siswa->user_id);
            }
        }

        // 3. Verifikasi kredensial
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'login_id' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('login_id');
    }

    /**
     * Alihkan pengguna ke dashboard yang sesuai dengan rolenya
     */
    protected function redirectBasedOnRole(User $user)
    {
        if ($user->hasRole('Tata Usaha')) {
            return redirect()->route('tu.dashboard');
        } elseif ($user->hasRole('Wali Kelas')) {
            return redirect()->route('walas.dashboard');
        } elseif ($user->hasRole('Guru')) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        // Fallback berdasarkan relasi
        if ($user->guru) {
            if ($user->guru->kelasWali) {
                return redirect()->route('walas.dashboard');
            }
            return redirect()->route('guru.dashboard');
        } elseif ($user->siswa) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect()->route('tu.dashboard');
    }

    /**
     * Logout pengguna dari sistem
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
