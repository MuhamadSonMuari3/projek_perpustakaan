<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'category',
        'stock',
        'description',
        'cover_image',
    ];

    // Relasi ke Loan
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
