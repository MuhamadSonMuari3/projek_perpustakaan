<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Tampilkan daftar buku dengan pencarian & pagination.
     */
    public function index(Request $request)
    {
        $search   = $request->get('search');
        $category = $request->get('category');

        $books = Book::when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->latest()
            ->paginate(10);

        // Ambil daftar kategori unik untuk filter
        $categories = Book::whereNotNull('category')->distinct()->pluck('category');

        return view('admin.books.index', compact('books', 'search', 'category', 'categories'));
    }

    /**
     * Tampilkan form tambah buku.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Simpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['nullable', 'string', 'max:255'],
            'year'        => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            'isbn'        => ['nullable', 'string', 'max:50', 'unique:books,isbn'],
            'category'    => ['nullable', 'string', 'max:100'],
            'stock'       => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required'    => 'Judul buku wajib diisi.',
            'author.required'   => 'Nama penulis wajib diisi.',
            'year.integer'      => 'Tahun terbit harus berupa angka.',
            'isbn.unique'       => 'Nomor ISBN sudah terdaftar.',
            'stock.required'    => 'Jumlah stok wajib diisi.',
            'stock.min'         => 'Jumlah stok minimal 0.',
            'cover_image.image' => 'File cover harus berupa gambar.',
            'cover_image.max'   => 'Ukuran gambar cover maksimal 2MB.',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Simpan perubahan data buku.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['nullable', 'string', 'max:255'],
            'year'        => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            'isbn'        => ['nullable', 'string', 'max:50', 'unique:books,isbn,' . $book->id],
            'category'    => ['nullable', 'string', 'max:100'],
            'stock'       => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required'    => 'Judul buku wajib diisi.',
            'author.required'   => 'Nama penulis wajib diisi.',
            'year.integer'      => 'Tahun terbit harus berupa angka.',
            'isbn.unique'       => 'Nomor ISBN sudah terdaftar.',
            'stock.required'    => 'Jumlah stok wajib diisi.',
            'stock.min'         => 'Jumlah stok minimal 0.',
            'cover_image.image' => 'File cover harus berupa gambar.',
            'cover_image.max'   => 'Ukuran gambar cover maksimal 2MB.',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Hapus buku dari database.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
