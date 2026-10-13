@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('page-title', 'Tambah Pengguna')
@section('page-subtitle', 'Buat akun pengguna baru (User, Admin, atau Superadmin)')

@section('content')

<div class="max-w-2xl">

    {{-- Back Button --}}
    <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-slate-200 transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar User
    </a>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl">

        {{-- Form Header --}}
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">Form Pengguna Baru</h2>
                <p class="text-xs text-slate-400">Isi detail akun pengguna yang ingin didaftarkan ke sistem.</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Muhammad Adnan"
                       class="w-full px-4 py-3 bg-slate-950 border @error('name') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                @error('name')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat Email --}}
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="Contoh: user@example.com"
                       class="w-full px-4 py-3 bg-slate-950 border @error('email') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                @error('email')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role / Hak Akses --}}
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Role / Hak Akses</label>
                <select name="role" required
                        class="w-full px-4 py-3 bg-slate-950 border @error('role') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Pengguna Biasa)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Administrator)</option>
                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin (Super Administrator)</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="pt-2 border-t border-slate-800 space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-slate-950 border @error('password') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                           placeholder="Ulangi password">
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition text-sm shadow-lg shadow-red-600/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Simpan Pengguna
                </button>
                <a href="{{ route('admin.users') }}"
                   class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold rounded-xl transition text-sm border border-slate-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
