<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Ringkasan dan statistik sistem'); ?>

<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>


<div class="bg-gradient-to-r from-slate-900 via-slate-900 to-red-950/40 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-2xl relative overflow-hidden mb-6">
    <div class="relative z-10 max-w-2xl">
        <span class="px-3 py-1 bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-medium rounded-full inline-block mb-3">Administrator</span>
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
            Selamat Datang, <?php echo e(auth()->user()->name); ?>! 👋
        </h2>
        <p class="text-slate-400 text-sm leading-relaxed">
            Anda sedang berada di panel administrasi. Kelola pengguna dan pantau statistik sistem dari sini.
        </p>
    </div>
    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <a href="<?php echo e(route('admin.books.index')); ?>" class="text-[10px] font-semibold text-amber-400 hover:text-amber-300 uppercase tracking-wider">Kelola &rarr;</a>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($totalBooks); ?></p>
        <p class="text-xs text-slate-400">Total Koleksi Buku</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">User</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($totalUsers); ?></p>
        <p class="text-xs text-slate-400">Pengguna Biasa</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">Admin</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($totalAdmins + $totalSuperadmins); ?></p>
        <p class="text-xs text-slate-400"><?php echo e($totalAdmins); ?> Admin &bull; <?php echo e($totalSuperadmins); ?> Superadmin</p>
    </div>

    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-slate-600 uppercase tracking-wider">Total</span>
        </div>
        <p class="text-3xl font-bold text-white mb-1"><?php echo e($totalUsers + $totalAdmins + $totalSuperadmins); ?></p>
        <p class="text-xs text-slate-400">Total Semua Akun</p>
    </div>

</div>


<div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
            Pengguna Terbaru
        </h3>
        <a href="<?php echo e(route('admin.users')); ?>" class="text-xs text-red-400 hover:text-red-300 font-medium transition">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800">
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-700 text-slate-300 font-semibold flex items-center justify-center text-xs">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <span class="text-slate-200 font-medium"><?php echo e($user->name); ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400"><?php echo e($user->email); ?></td>
                        <td class="px-6 py-4">
                            <?php if($user->role === 'superadmin'): ?>
                                <span class="px-2 py-0.5 bg-purple-500/10 text-purple-400 border border-purple-500/20 text-[10px] font-semibold rounded-full uppercase">Superadmin</span>
                            <?php elseif($user->role === 'admin'): ?>
                                <span class="px-2 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-semibold rounded-full uppercase">Admin</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-semibold rounded-full uppercase">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs"><?php echo e($user->created_at->format('d M Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada pengguna terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projek_laravel - Copy\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>