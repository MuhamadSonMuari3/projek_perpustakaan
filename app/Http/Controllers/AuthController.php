<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'name.max'          => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }

    /**
     * Menampilkan form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses otentikasi login pengguna.
     */
    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Coba Login Pengguna via Auth::attempt
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session untuk mencegah Session Fixation attack
            $request->session()->regenerate();

            // Redirect berdasarkan role: admin & superadmin ke admin dashboard, user ke dashboard user
            $destination = in_array(Auth::user()->role, ['admin', 'superadmin'])
                ? route('admin.dashboard')
                : route('user.dashboard');

            return redirect()->intended($destination)->with('success', 'Selamat datang kembali!');
        }

        // 3. Jika gagal, kembalikan response dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate dan regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}