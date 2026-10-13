@extends('admin.layouts.app')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')
@section('page-subtitle', 'Kelola katalog buku, stok, dan informasi buku')

@section('content')

{{-- Flash Messages --}}
@if (session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- Header + Actions & Filter --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-white">Daftar Katalog Buku</h2>
        <p class="text-xs text-slate-500 mt-0.5">Total {{ $books->total() }} buku terdaftar</p>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <a href="{{ route('admin.books.create') }}"
           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Buku
        </a>

        <form action="{{ route('admin.books.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if($categories->count() > 0)
                <select name="category" onchange="this.form.submit()"
                        class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            @endif

            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari judul, penulis, ISBN..."
                   class="px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-60">
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-red-600/20">Cari</button>
            @if($search || $category)
                <a href="{{ route('admin.books.index') }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-400 text-sm rounded-xl transition">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-900/50">
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Penerbit & Tahun</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse ($books as $index => $book)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ $books->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                         class="w-11 h-14 object-cover rounded-lg border border-slate-800 shadow shrink-0">
                                @else
                                    <div class="w-11 h-14 rounded-lg bg-slate-800 border border-slate-700/60 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-slate-200 font-semibold leading-snug">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Penulis: {{ $book->author }}</p>
                                    @if($book->isbn)
                                        <p class="text-[10px] text-slate-500">ISBN: {{ $book->isbn }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($book->category)
                                <span class="px-2.5 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-medium rounded-full">
                                    {{ $book->category }}
                                </span>
                            @else
                                <span class="text-slate-600 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            <p>{{ $book->publisher ?? '-' }}</p>
                            @if($book->year)
                                <p class="text-slate-500 text-[11px]">Tahun {{ $book->year }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($book->stock > 5)
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-semibold rounded-lg">
                                    {{ $book->stock }} eks
                                </span>
                            @elseif($book->stock > 0)
                                <span class="px-2 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-semibold rounded-lg">
                                    {{ $book->stock }} eks (Menipis)
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-semibold rounded-lg">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium rounded-lg border border-slate-700 hover:border-slate-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku {{ $book->title }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs font-medium rounded-lg border border-red-500/20 hover:border-red-500/40 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Belum ada buku yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    @if($books->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $books->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif
</div>

@endsection
