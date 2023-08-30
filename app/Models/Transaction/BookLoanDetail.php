<?php

namespace App\Models\Transaction;

use App\Models\Master\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoanDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function bookLoan()
    {
        return $this->belongsTo(BookLoan::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
