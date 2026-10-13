<?php $__env->startSection('title', 'Beranda Perpustakaan'); ?>
<?php $__env->startSection('page-title', 'Beranda'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang di Portal Perpustakaan Digital'); ?>

<?php $__env->startSection('content'); ?>


<?php $__currentLoopData = ['success' => 'emerald', 'error' => 'red', 'warning' => 'amber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session($type)): ?>
        <div class="mb-6 p-4 rounded-xl bg-<?php echo e($color); ?>-500/10 border border-<?php echo e($color); ?>-500/20 text-<?php echo e($color); ?>-400 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <?php if($type === 'success'): ?> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                <?php elseif($type === 'warning'): ?> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <?php else: ?> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                <?php endif; ?>
            </svg>
            <?php echo e(session($type)); ?>

        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="bg-gradient-to-r from-slate-900 via-slate-900 to-blue-950/40 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-2xl relative overflow-hidden mb-6">
    <div class="relative z-10 max-w-2xl">
        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-medium rounded-full inline-block mb-3">Anggota Perpustakaan</span>
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
            Selamat Datang, <?php echo e(auth()->user()->name); ?>! 📚
        </h2>
        <p class="text-slate-400 text-sm leading-relaxed mb-4">
            Jelajahi koleksi buku kami, pinjam buku favorit Anda, dan pantau status peminjaman serta tagihan denda di sini.
        </p>
        <a href="<?php echo e(route('user.catalog')); ?>"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-600/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Jelajahi Katalog Buku
        </a>
    </div>
    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">Total</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($totalBorrowed); ?></p>
        <p class="text-xs text-slate-400">Total Pernah Dipinjam</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">Aktif</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($activeLoan); ?></p>
        <p class="text-xs text-slate-400">Sedang Dipinjam</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">Terlambat</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($overdueLoan); ?></p>
        <p class="text-xs text-slate-400">Melewati Tenggat</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <a href="<?php echo e(route('user.fines')); ?>" class="text-[10px] font-semibold text-amber-400 hover:text-amber-300 uppercase tracking-wider">Lihat &rarr;</a>
        </div>
        <p class="text-3xl font-bold text-white mb-1">Rp <?php echo e(number_format($totalFine, 0, ',', '.')); ?></p>
        <p class="text-xs text-slate-400">Denda Belum Dilunasi</p>
    </div>

</div>


<div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Aktivitas Terbaru
        </h3>
        <a href="<?php echo e(route('user.loans')); ?>" class="text-xs text-blue-400 hover:text-blue-300 font-medium transition">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800">
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tenggat</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                <?php $__empty_1 = true; $__currentLoopData = $recentLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <?php if($loan->book->cover_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $loan->book->cover_image)); ?>" class="w-8 h-10 object-cover rounded border border-slate-700 shrink-0">
                                <?php else: ?>
                                    <div class="w-8 h-10 bg-slate-800 rounded border border-slate-700 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="text-slate-200 font-medium text-xs leading-snug"><?php echo e(Str::limit($loan->book->title, 30)); ?></p>
                                    <p class="text-slate-500 text-[11px]"><?php echo e($loan->book->author); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs"><?php echo e($loan->loan_date->format('d M Y')); ?></td>
                        <td class="px-6 py-4 text-xs">
                            <span class="<?php echo e($loan->status !== 'returned' && \Carbon\Carbon::today()->gt($loan->due_date) ? 'text-red-400 font-semibold' : 'text-slate-400'); ?>">
                                <?php echo e($loan->due_date->format('d M Y')); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($loan->status === 'returned'): ?>
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold rounded-full">Dikembalikan</span>
                            <?php elseif($loan->status === 'overdue'): ?>
                                <span class="px-2 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-semibold rounded-full">Terlambat</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-semibold rounded-full">Dipinjam</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 text-sm">
                            Belum ada aktivitas peminjaman. <a href="<?php echo e(route('user.catalog')); ?>" class="text-blue-400 hover:underline">Pinjam buku sekarang &rarr;</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projek_laravel - Copy\resources\views/user/dashboard.blade.php ENDPATH**/ ?>