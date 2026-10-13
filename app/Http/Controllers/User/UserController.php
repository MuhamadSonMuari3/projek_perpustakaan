<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const FINE_PER_DAY = 1000; // Rp 1.000 per hari keterlambatan

    /**
     * Dashboard utama pengguna.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $totalBorrowed  = Loan::where('user_id', $user->id)->count();
        $activeLoan     = Loan::where('user_id', $user->id)->where('status', 'active')->count();
        $overdueLoan    = Loan::where('user_id', $user->id)->where('status', 'overdue')->count();
        $totalFine      = Fine::where('user_id', $user->id)->where('status', 'unpaid')->sum('total_amount');

        $recentLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Update status overdue secara otomatis
        Loan::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        return view('user.dashboard', compact(
            'totalBorrowed', 'activeLoan', 'overdueLoan', 'totalFine', 'recentLoans'
        ));
    }

    /**
     * Halaman daftar buku (katalog) untuk dipinjam.
     */
    public function catalog(Request $request)
    {
        $search   = $request->get('search');
        $category = $request->get('category');

        $books = Book::when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        $categories = Book::whereNotNull('category')->distinct()->pluck('category');

        return view('user.catalog', compact('books', 'search', 'category', 'categories'));
    }

    /**
     * Proses peminjaman buku.
     */
    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id'  => ['required', 'exists:books,id'],
            'due_date' => ['required', 'date', 'after:today'],
        ], [
            'book_id.required'  => 'Pilih buku yang ingin dipinjam.',
            'book_id.exists'    => 'Buku tidak ditemukan.',
            'due_date.required' => 'Pilih tanggal pengembalian.',
            'due_date.after'    => 'Tanggal pengembalian harus setelah hari ini.',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek stok buku
        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis, tidak dapat dipinjam.');
        }

        // Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $existingLoan = Loan::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['active', 'overdue'])
            ->first();

        if ($existingLoan) {
            return back()->with('error', 'Anda masih meminjam buku ini. Kembalikan terlebih dahulu.');
        }

        // Buat catatan peminjaman
        Loan::create([
            'user_id'   => Auth::id(),
            'book_id'   => $request->book_id,
            'loan_date' => Carbon::today(),
            'due_date'  => $request->due_date,
            'status'    => 'active',
        ]);

        // Kurangi stok buku
        $book->decrement('stock');

        return redirect()->route('user.loans')->with('success', "Buku \"{$book->title}\" berhasil dipinjam! Harap dikembalikan paling lambat " . Carbon::parse($request->due_date)->format('d M Y') . '.');
    }

    /**
     * Halaman riwayat peminjaman user.
     */
    public function loans(Request $request)
    {
        $user   = Auth::user();
        $filter = $request->get('status');

        // Update status overdue secara otomatis
        Loan::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $loans = Loan::with(['book', 'fine'])
            ->where('user_id', $user->id)
            ->when($filter, fn($q) => $q->where('status', $filter))
            ->latest()
            ->paginate(10);

        return view('user.loans', compact('loans', 'filter'));
    }

    /**
     * Proses pengembalian buku.
     */
    public function returnBook(Loan $loan)
    {
        // Validasi: hanya pemilik yang bisa kembalikan
        if ($loan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($loan->status === 'returned') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $returnDate  = Carbon::today();
        $overdueDays = max(0, $returnDate->diffInDays($loan->due_date, false) * -1);

        // Update status loan
        $loan->update([
            'return_date' => $returnDate,
            'status'      => 'returned',
        ]);

        // Kembalikan stok buku
        $loan->book->increment('stock');

        // Hitung dan buat denda jika terlambat
        if ($overdueDays > 0) {
            $totalFine = $overdueDays * self::FINE_PER_DAY;

            Fine::updateOrCreate(
                ['loan_id' => $loan->id],
                [
                    'user_id'        => Auth::id(),
                    'overdue_days'   => $overdueDays,
                    'amount_per_day' => self::FINE_PER_DAY,
                    'total_amount'   => $totalFine,
                    'status'         => 'unpaid',
                ]
            );

            return redirect()->route('user.fines')
                ->with('warning', "Buku berhasil dikembalikan. Anda terlambat {$overdueDays} hari. Denda sebesar Rp " . number_format($totalFine, 0, ',', '.') . ' perlu segera dilunasi.');
        }

        return redirect()->route('user.loans')
            ->with('success', "Buku \"{$loan->book->title}\" berhasil dikembalikan tepat waktu. Terima kasih!");
    }

    /**
     * Halaman denda pengguna.
     */
    public function fines()
    {
        $fines = Fine::with(['loan.book'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $totalUnpaid = Fine::where('user_id', Auth::id())
            ->where('status', 'unpaid')
            ->sum('total_amount');

        return view('user.fines', compact('fines', 'totalUnpaid'));
    }
}
