<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin default.
     * Email: admin@admin.com | Password: admin12345
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Super Admin',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('admin12345'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Akun admin berhasil dibuat: admin@admin.com | password: admin12345');
    }
}
