@extends('user.layouts.app')

@section('title', 'Denda Saya')
@section('page-title', 'Denda Keterlambatan')
@section('page-subtitle', 'Informasi denda dan tagihan keterlambatan pengembalian buku')

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

{{-- Info Banner Denda --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="md:col-span-2 bg-gradient-to-r from-slate-900 via-slate-900 to-amber-950/30 border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden flex flex-col justify-between">
        <div class="relative z-10">
            <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold rounded-full inline-block mb-3">Ketentuan Denda</span>
            <h2 class="text-xl font-bold text-white mb-2">Informasi Tarif Keterlambatan</h2>
            <p class="text-slate-400 text-xs leading-relaxed">
                Tarif denda keterlambatan pengembalian buku adalah <strong class="text-amber-400">Rp 1.000 / hari</strong> per buku. Pembayaran denda dapat dilakukan secara langsung di meja sirkulasi perpustakaan.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center gap-2 text-[11px] text-slate-500">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pastikan mengembalikan buku tepat waktu untuk menghindari akumulasi denda.
        </div>
    </div>

    {{-- Card Total Denda Belum Lunas --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Tagihan</span>
                <span class="w-2.5 h-2.5 rounded-full {{ $totalUnpaid > 0 ? 'bg-red-400 animate-pulse' : 'bg-emerald-400' }}"></span>
            </div>
            <p class="text-3xl font-extrabold {{ $totalUnpaid > 0 ? 'text-red-400' : 'text-emerald-400' }} mt-2">
                Rp {{ number_format($totalUnpaid, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-500 mt-1">Denda yang belum dibayar</p>
        </div>
        @if($totalUnpaid == 0)
            <div class="mt-4 px-3 py-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Semua denda Anda telah lunas.
            </div>
        @else
            <div class="mt-4 px-3 py-2 bg-red-500/10 border border-red-500/20 text-red-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Segera lakukan pelunasan di petugas.
            </div>
        @endif
    </div>
</div>

{{-- Table Riwayat Denda --}}
<div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-800">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Daftar Denda Keterlambatan
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-900/50">
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Buku Terkait</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tenggat Waktu</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Keterlambatan</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tarif / Hari</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Denda</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($fines as $index => $fine)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ $fines->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <p class="text-slate-200 font-medium text-xs">{{ $fine->loan->book->title ?? '-' }}</p>
                            <p class="text-slate-500 text-[11px]">{{ $fine->loan->book->author ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $fine->loan ? $fine->loan->due_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-300 text-xs font-semibold">
                            {{ $fine->overdue_days }} hari
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            Rp {{ number_format($fine->amount_per_day, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-amber-400">
                            Rp {{ number_format($fine->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($fine->status === 'paid')
                                <span class="px-2.5 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold rounded-full">
                                    Lunas
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-semibold rounded-full">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Hebat! Anda tidak memiliki catatan denda keterlambatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($fines->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $fines->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif
</div>

@endsection
