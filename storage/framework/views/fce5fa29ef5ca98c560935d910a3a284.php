<?php $__env->startSection('title', 'Riwayat Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Riwayat Peminjaman'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar semua buku yang pernah Anda pinjam'); ?>

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


<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-white">Riwayat Peminjaman Saya</h2>
        <p class="text-xs text-slate-500 mt-0.5">Total <?php echo e($loans->total()); ?> catatan peminjaman</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <?php $__currentLoopData = ['' => 'Semua', 'active' => 'Aktif', 'overdue' => 'Terlambat', 'returned' => 'Dikembalikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('user.loans', $val ? ['status' => $val] : [])); ?>"
               class="px-3 py-1.5 rounded-xl text-xs font-semibold transition border
               <?php echo e($filter === ($val ?: null) || ($val === '' && !$filter)
                  ? 'bg-blue-600/20 text-blue-400 border-blue-500/30'
                  : 'bg-slate-800 text-slate-400 border-slate-700 hover:bg-slate-700'); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


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
                <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-800/30 transition <?php echo e($loan->status === 'overdue' ? 'bg-red-950/10' : ''); ?>">
                        <td class="px-6 py-4 text-slate-600 text-xs"><?php echo e($loans->firstItem() + $index); ?></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <?php if($loan->book->cover_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $loan->book->cover_image)); ?>" class="w-9 h-12 object-cover rounded border border-slate-700 shrink-0">
                                <?php else: ?>
                                    <div class="w-9 h-12 bg-slate-800 rounded border border-slate-700 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="text-slate-200 font-semibold text-xs leading-snug"><?php echo e(Str::limit($loan->book->title, 35)); ?></p>
                                    <p class="text-slate-500 text-[11px]"><?php echo e($loan->book->author); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs"><?php echo e($loan->loan_date->format('d M Y')); ?></td>
                        <td class="px-6 py-4 text-xs">
                            <span class="<?php echo e($loan->status === 'overdue' ? 'text-red-400 font-semibold' : 'text-slate-400'); ?>">
                                <?php echo e($loan->due_date->format('d M Y')); ?>

                            </span>
                            <?php if($loan->status === 'overdue'): ?>
                                <?php $days = \Carbon\Carbon::today()->diffInDays($loan->due_date); ?>
                                <p class="text-red-400 text-[10px] font-bold">+<?php echo e($days); ?> hari</p>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            <?php echo e($loan->return_date ? $loan->return_date->format('d M Y') : '-'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php if($loan->status === 'returned'): ?>
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold rounded-full">Dikembalikan</span>
                            <?php elseif($loan->status === 'overdue'): ?>
                                <span class="px-2 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-semibold rounded-full">Terlambat</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-semibold rounded-full">Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <?php if($loan->fine): ?>
                                <div>
                                    <p class="text-amber-400 font-semibold">Rp <?php echo e(number_format($loan->fine->total_amount, 0, ',', '.')); ?></p>
                                    <?php if($loan->fine->status === 'paid'): ?>
                                        <span class="text-emerald-400 text-[10px]">✓ Lunas</span>
                                    <?php else: ?>
                                        <span class="text-red-400 text-[10px]">Belum Lunas</span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-600">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($loan->status !== 'returned'): ?>
                                <form action="<?php echo e(route('user.return', $loan)); ?>" method="POST"
                                      onsubmit="return confirm('Konfirmasi pengembalian buku \'<?php echo e(addslashes($loan->book->title)); ?>\'?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 text-xs font-semibold rounded-lg border border-emerald-500/20 hover:border-emerald-500/40 transition whitespace-nowrap">
                                        Kembalikan
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-slate-600 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Belum ada riwayat peminjaman.
                            <a href="<?php echo e(route('user.catalog')); ?>" class="text-blue-400 hover:underline ml-1">Pinjam buku sekarang &rarr;</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($loans->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-800">
            <?php echo e($loans->withQueryString()->links('pagination::tailwind')); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projek_laravel - Copy\resources\views/user/loans.blade.php ENDPATH**/ ?>