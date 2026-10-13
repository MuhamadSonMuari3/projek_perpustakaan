@extends('user.layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Daftar semua buku yang pernah Anda pinjam')

@section('content')

{{-- Flash Messages --}}
@foreach (['success' => 'emerald', 'error' => 'red', 'warning' => 'amber'] as $type => $color)
    @if(session($type))
        <div class="mb-6 p-4 rounded-xl bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-400 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($type === 'success') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                @elseif($type === 'warning') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                @endif
            </svg>
            {{ session($type) }}
        </div>
    @endif
@endforeach

{{-- Header + Filter --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-white">Riwayat Peminjaman Saya</h2>
        <p class="text-xs text-slate-500 mt-0.5">Total {{ $loans->total() }} catatan peminjaman</p>
    </div>
    <div class="flex flex-wrap gap-2">
        @foreach(['' => 'Semua', 'active' => 'Aktif', 'overdue' => 'Terlambat', 'returned' => 'Dikembalikan'] as $val => $label)
            <a href="{{ route('user.loans', $val ? ['status' => $val] : []) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-semibold transition border
               {{ $filter === ($val ?: null) || ($val === '' && !$filter)
                  ? 'bg-blue-600/20 text-blue-400 border-blue-500/30'
                  : 'bg-slate-800 text-slate-400 border-slate-700 hover:bg-slate-700' }}">
                {{ $label }}
            </a>
        @endforeach
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
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tenggat</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tgl Kembali</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($loans as $index => $loan)
                    <tr class="hover:bg-slate-800/30 transition {{ $loan->status === 'overdue' ? 'bg-red-950/10' : '' }}">
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ $loans->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($loan->book->cover_image)
                                    <img src="{{ asset('storage/' . $loan->book->cover_image) }}" class="w-9 h-12 object-cover rounded border border-slate-700 shrink-0">
                                @else
                                    <div class="w-9 h-12 bg-slate-800 rounded border border-slate-700 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-slate-200 font-semibold text-xs leading-snug">{{ Str::limit($loan->book->title, 35) }}</p>
                                    <p class="text-slate-500 text-[11px]">{{ $loan->book->author }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $loan->loan_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-xs">
                            <span class="{{ $loan->status === 'overdue' ? 'text-red-400 font-semibold' : 'text-slate-400' }}">
                                {{ $loan->due_date->format('d M Y') }}
                            </span>
                            @if($loan->status === 'overdue')
                                @php $days = \Carbon\Carbon::today()->diffInDays($loan->due_date); @endphp
                                <p class="text-red-400 text-[10px] font-bold">+{{ $days }} hari</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($loan->status === 'returned')
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold rounded-full">Dikembalikan</span>
                            @elseif($loan->status === 'overdue')
                                <span class="px-2 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-semibold rounded-full">Terlambat</span>
                            @else
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-semibold rounded-full">Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs">
                            @if($loan->fine)
                                <div>
                                    <p class="text-amber-400 font-semibold">Rp {{ number_format($loan->fine->total_amount, 0, ',', '.') }}</p>
                                    @if($loan->fine->status === 'paid')
                                        <span class="text-emerald-400 text-[10px]">✓ Lunas</span>
                                    @else
                                        <span class="text-red-400 text-[10px]">Belum Lunas</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($loan->status !== 'returned')
                                <form action="{{ route('user.return', $loan) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi pengembalian buku \'{{ addslashes($loan->book->title) }}\'?')">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 text-xs font-semibold rounded-lg border border-emerald-500/20 hover:border-emerald-500/40 transition whitespace-nowrap">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-600 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Belum ada riwayat peminjaman.
                            <a href="{{ route('user.catalog') }}" class="text-blue-400 hover:underline ml-1">Pinjam buku sekarang &rarr;</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($loans->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $loans->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif
</div>

@endsection
