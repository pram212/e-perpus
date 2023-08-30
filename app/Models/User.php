<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Master\Book;
use App\Models\Transaction\BookLoan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_loans')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class)->where('refund', false);
    }

    public function bookLoans() 
    {
        return $this->hasMany(User::class);
    }
}
