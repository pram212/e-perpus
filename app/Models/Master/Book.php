<?php

namespace App\Models\Master;

use App\Models\Transaction\BookLoan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function users()
    {
        return $this->belongsToMany(BookLoan::class, 'book_loans');
    }
    
}
