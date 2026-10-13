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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('overdue_days');         // Jumlah hari keterlambatan
            $table->decimal('amount_per_day', 10, 2)->default(1000); // Denda per hari (Rp)
            $table->decimal('total_amount', 10, 2);  // Total denda
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid'); // Status pembayaran
            $table->date('paid_at')->nullable();      // Tanggal pembayaran
            $table->text('notes')->nullable();        // Catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
