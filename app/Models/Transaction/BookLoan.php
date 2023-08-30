<?php

namespace App\Models\Transaction;

use App\Models\Master\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function bookLoanDetail() 
    {
        return $this->hasMany(BookLoanDetail::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

}
