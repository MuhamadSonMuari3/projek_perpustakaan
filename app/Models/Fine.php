<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'loan_id',
        'user_id',
        'overdue_days',
        'amount_per_day',
        'total_amount',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at'       => 'date',
        'amount_per_day'=> 'decimal:2',
        'total_amount'  => 'decimal:2',
    ];

    // Relasi ke Loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
