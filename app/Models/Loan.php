<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_date'   => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke Fine
    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    // Hitung jumlah hari keterlambatan
    public function getOverdueDaysAttribute(): int
    {
        $compareDate = $this->return_date ?? Carbon::today();
        if ($compareDate->gt($this->due_date)) {
            return $compareDate->diffInDays($this->due_date);
        }
        return 0;
    }

    // Apakah sudah terlambat?
    public function getIsOverdueAttribute(): bool
    {
        return Carbon::today()->gt($this->due_date) && $this->status !== 'returned';
    }
}
