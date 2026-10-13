@extends('user.layouts.app')

@section('title', 'Katalog Buku')
@section('page-title', 'Katalog Buku')
@section('page-subtitle', 'Jelajahi dan pinjam buku dari koleksi perpustakaan')

@section('content')

{{-- Flash Messages --}}
@foreach (['success' => 'emerald', 'error' => 'red', 'warning' => 'amber'] as $type => $color)
    @if(session($type))
        <div class="mb-6 p-4 rounded-xl bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-400 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($type === 'success') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                @endif
            </svg>
            {{ session($type) }}
        </div>
    @endif
@endforeach

{{-- Header + Search --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-white">Koleksi Buku Tersedia</h2>
        <p class="text-xs text-slate-500 mt-0.5">Total {{ $books->total() }} buku tersedia untuk dipinjam</p>
    </div>
    <form action="{{ route('user.catalog') }}" method="GET" class="flex flex-wrap items-center gap-2">
        @if($categories->count() > 0)
            <select name="category" onchange="this.form.submit()"
                    class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        @endif
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Cari judul atau penulis..."
               class="px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-56">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">Cari</button>
        @if($search || $category)
            <a href="{{ route('user.catalog') }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-400 text-sm rounded-xl transition">Reset</a>
        @endif
    </form>
</div>

{{-- Grid Buku --}}
@if($books->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-6">
        @foreach($books as $book)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden flex flex-col hover:border-slate-700 transition group">
                {{-- Cover --}}
                <div class="relative h-48 bg-slate-800 flex items-center justify-center overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="flex flex-col items-center text-slate-600">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span class="text-xs">Tanpa Cover</span>
                        </div>
                    @endif
                    {{-- Badge stok --}}
                    <div class="absolute top-2 right-2">
                        @if($book->stock > 5)
                            <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full shadow">{{ $book->stock }} tersedia</span>
                        @elseif($book->stock > 0)
                            <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full shadow">{{ $book->stock }} tersisa</span>
                        @endif
                    </div>
                </div>

                {{-- Info Buku --}}
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex-1">
                        @if($book->category)
                            <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-medium rounded-full">{{ $book->category }}</span>
                        @endif
                        <h3 class="text-sm font-bold text-white mt-2 leading-snug">{{ $book->title }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $book->author }}</p>
                        @if($book->year)
                            <p class="text-[11px] text-slate-500 mt-1">{{ $book->publisher ?? '' }}{{ $book->publisher && $book->year ? ' · ' : '' }}{{ $book->year }}</p>
                        @endif
                    </div>

                    {{-- Form Pinjam --}}
                    <form action="{{ route('user.borrow') }}" method="POST" class="mt-4 space-y-2">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div>
                            <label class="block text-[10px] text-slate-500 uppercase mb-1">Tanggal Kembali</label>
                            <input type="date" name="due_date" required
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                   value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                   class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-xs text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition flex items-center justify-center gap-1.5 shadow-lg shadow-blue-600/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Pinjam Buku
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($books->hasPages())
        <div class="mt-2">
            {{ $books->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif
@else
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-16 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <p class="text-slate-400 text-sm">Tidak ada buku yang tersedia saat ini.</p>
    </div>
@endif

@endsection
