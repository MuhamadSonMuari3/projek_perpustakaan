<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\User\UserController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Khusus Tamu / Belum Login (Middleware Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Khusus Pengguna Terautentikasi (Middleware Auth)
Route::middleware('auth')->group(function () {

    // Profil / Info Akun
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Action Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ===== ROUTE USER PANEL =====
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/catalog',   [UserController::class, 'catalog'])->name('catalog');
        Route::post('/borrow',   [UserController::class, 'borrowBook'])->name('borrow');
        Route::get('/loans',     [UserController::class, 'loans'])->name('loans');
        Route::post('/return/{loan}', [UserController::class, 'returnBook'])->name('return');
        Route::get('/fines',     [UserController::class, 'fines'])->name('fines');
    });
});

// ===== ROUTE KHUSUS ADMIN =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen User
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Manajemen Buku
    Route::resource('books', BookController::class)->except(['show']);
});