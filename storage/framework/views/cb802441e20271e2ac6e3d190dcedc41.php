<?php $__env->startSection('title', 'Katalog Buku'); ?>
<?php $__env->startSection('page-title', 'Katalog Buku'); ?>
<?php $__env->startSection('page-subtitle', 'Jelajahi dan pinjam buku dari koleksi perpustakaan'); ?>

<?php $__env->startSection('content'); ?>


<?php $__currentLoopData = ['success' => 'emerald', 'error' => 'red', 'warning' => 'amber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session($type)): ?>
        <div class="mb-6 p-4 rounded-xl bg-<?php echo e($color); ?>-500/10 border border-<?php echo e($color); ?>-500/20 text-<?php echo e($color); ?>-400 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <?php if($type === 'success'): ?> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                <?php else: ?> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <?php endif; ?>
            </svg>
            <?php echo e(session($type)); ?>

        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-white">Koleksi Buku Tersedia</h2>
        <p class="text-xs text-slate-500 mt-0.5">Total <?php echo e($books->total()); ?> buku tersedia untuk dipinjam</p>
    </div>
    <form action="<?php echo e(route('user.catalog')); ?>" method="GET" class="flex flex-wrap items-center gap-2">
        <?php if($categories->count() > 0): ?>
            <select name="category" onchange="this.form.submit()"
                    class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat); ?>" <?php echo e($category == $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        <?php endif; ?>
        <input type="text" name="search" value="<?php echo e($search); ?>"
               placeholder="Cari judul atau penulis..."
               class="px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-56">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">Cari</button>
        <?php if($search || $category): ?>
            <a href="<?php echo e(route('user.catalog')); ?>" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-400 text-sm rounded-xl transition">Reset</a>
        <?php endif; ?>
    </form>
</div>


<?php if($books->count() > 0): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-6">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden flex flex-col hover:border-slate-700 transition group">
                
                <div class="relative h-48 bg-slate-800 flex items-center justify-center overflow-hidden">
                    <?php if($book->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $book->cover_image)); ?>" alt="<?php echo e($book->title); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <?php else: ?>
                        <div class="flex flex-col items-center text-slate-600">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span class="text-xs">Tanpa Cover</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-2 right-2">
                        <?php if($book->stock > 5): ?>
                            <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full shadow"><?php echo e($book->stock); ?> tersedia</span>
                        <?php elseif($book->stock > 0): ?>
                            <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full shadow"><?php echo e($book->stock); ?> tersisa</span>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex-1">
                        <?php if($book->category): ?>
                            <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-medium rounded-full"><?php echo e($book->category); ?></span>
                        <?php endif; ?>
                        <h3 class="text-sm font-bold text-white mt-2 leading-snug"><?php echo e($book->title); ?></h3>
                        <p class="text-xs text-slate-400 mt-0.5"><?php echo e($book->author); ?></p>
                        <?php if($book->year): ?>
                            <p class="text-[11px] text-slate-500 mt-1"><?php echo e($book->publisher ?? ''); ?><?php echo e($book->publisher && $book->year ? ' · ' : ''); ?><?php echo e($book->year); ?></p>
                        <?php endif; ?>
                    </div>

                    
                    <form action="<?php echo e(route('user.borrow')); ?>" method="POST" class="mt-4 space-y-2">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                        <div>
                            <label class="block text-[10px] text-slate-500 uppercase mb-1">Tanggal Kembali</label>
                            <input type="date" name="due_date" required
                                   min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                   max="<?php echo e(date('Y-m-d', strtotime('+30 days'))); ?>"
                                   value="<?php echo e(date('Y-m-d', strtotime('+7 days'))); ?>"
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php if($books->hasPages()): ?>
        <div class="mt-2">
            <?php echo e($books->withQueryString()->links('pagination::tailwind')); ?>

        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-16 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <p class="text-slate-400 text-sm">Tidak ada buku yang tersedia saat ini.</p>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projek_laravel - Copy\resources\views/user/catalog.blade.php ENDPATH**/ ?>