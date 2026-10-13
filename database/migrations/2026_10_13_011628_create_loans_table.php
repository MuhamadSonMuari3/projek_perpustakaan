<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->date('loan_date');           // Tanggal pinjam
            $table->date('due_date');            // Tenggat waktu pengembalian
            $table->date('return_date')->nullable(); // Tanggal dikembalikan (null = belum kembali)
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
                                                 // active = sedang dipinjam
                                                 // returned = sudah dikembalikan
                                                 // overdue = terlambat
            $table->text('notes')->nullable();   // Catatan admin/petugas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
