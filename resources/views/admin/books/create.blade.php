@extends('admin.layouts.app')

@section('title', 'Tambah Buku Baru')
@section('page-title', 'Tambah Buku')
@section('page-subtitle', 'Tambahkan data buku baru ke dalam perpustakaan / sistem')

@section('content')

<div class="max-w-3xl">

    {{-- Back Button --}}
    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-slate-200 transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Buku
    </a>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl">

        {{-- Form Header --}}
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">Form Input Buku</h2>
                <p class="text-xs text-slate-400">Lengkapi informasi judul, penulis, stok, dan detail lainnya.</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Judul Buku --}}
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="Contoh: Belajar Pemrograman Laravel 12 Modern"
                       class="w-full px-4 py-3 bg-slate-950 border @error('title') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                @error('title')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Penulis --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Penulis / Pengarang <span class="text-red-500">*</span></label>
                    <input type="text" name="author" value="{{ old('author') }}" required
                           placeholder="Contoh: Taylor Otwell"
                           class="w-full px-4 py-3 bg-slate-950 border @error('author') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('author')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}"
                           placeholder="Contoh: Gramedia / Informatika"
                           class="w-full px-4 py-3 bg-slate-950 border @error('publisher') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('publisher')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category') }}"
                           placeholder="Contoh: Teknologi, Sains"
                           class="w-full px-4 py-3 bg-slate-950 border @error('category') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('category')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Tahun Terbit</label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                           placeholder="Contoh: 2026"
                           class="w-full px-4 py-3 bg-slate-950 border @error('year') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('year')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" required
                           class="w-full px-4 py-3 bg-slate-950 border @error('stock') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('stock')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- ISBN --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Nomor ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                           placeholder="Contoh: 978-602-05-1234-5"
                           class="w-full px-4 py-3 bg-slate-950 border @error('isbn') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    @error('isbn')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cover Image --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Foto Cover Buku (Opsional)</label>
                    <input type="file" name="cover_image" accept="image/*"
                           class="w-full px-3 py-2 bg-slate-950 border @error('cover_image') border-red-500 @else border-slate-700 @enderror rounded-xl text-xs text-slate-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 transition">
                    @error('cover_image')
                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi / Sinopsis --}}
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Deskripsi / Sinopsis</label>
                <textarea name="description" rows="4"
                          placeholder="Tuliskan ringkasan cerita atau sinopsis buku di sini..."
                          class="w-full px-4 py-3 bg-slate-950 border @error('description') border-red-500 @else border-slate-700 @enderror rounded-xl text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition text-sm shadow-lg shadow-red-600/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Simpan Buku
                </button>
                <a href="{{ route('admin.books.index') }}"
                   class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold rounded-xl transition text-sm border border-slate-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
