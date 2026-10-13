<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function dashboard()
    {
        $totalUsers       = User::where('role', 'user')->count();
        $totalAdmins      = User::where('role', 'admin')->count();
        $totalSuperadmins = User::where('role', 'superadmin')->count();
        $totalBooks       = \App\Models\Book::count();
        $recentUsers      = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalSuperadmins', 'totalBooks', 'recentUsers'));
    }

    /**
     * Tampilkan daftar semua pengguna.
     */
    public function users(Request $request)
    {
        $search = $request->get('search');

        $users = User::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Tampilkan form tambah user baru.
     */
     public function createUser()
     {
         return view('admin.users.create');
     }

     /**
      * Simpan user baru ke database.
      */
     public function storeUser(Request $request)
     {
         $validated = $request->validate([
             'name'     => ['required', 'string', 'max:255'],
             'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
             'role'     => ['required', 'in:user,admin,superadmin'],
             'password' => ['required', 'string', 'min:8', 'confirmed'],
         ], [
             'name.required'      => 'Nama lengkap wajib diisi.',
             'name.max'           => 'Nama tidak boleh lebih dari 255 karakter.',
             'email.required'     => 'Email wajib diisi.',
             'email.email'        => 'Format email tidak valid.',
             'email.unique'       => 'Email sudah digunakan.',
             'role.required'      => 'Role wajib dipilih.',
             'role.in'            => 'Role tidak valid.',
             'password.required'  => 'Password wajib diisi.',
             'password.min'       => 'Password minimal 8 karakter.',
             'password.confirmed' => 'Konfirmasi password tidak cocok.',
         ]);

         User::create([
             'name'     => $validated['name'],
             'email'    => $validated['email'],
             'role'     => $validated['role'],
             'password' => Hash::make($validated['password']),
         ]);

         return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil ditambahkan.');
     }

    /**
     * Tampilkan form edit user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Simpan perubahan data user.
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:user,admin,superadmin'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus user (tidak bisa hapus diri sendiri).
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
