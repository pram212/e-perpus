<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::when(request('search'), fn ($kategori) => 
                $kategori->where('email', 'like', '%'  .  request('search') . '%')
                ->orWhere('name', 'like', '%'  .  request('search') . '%')
            )
            ->paginate(10)
            ->withQueryString();

        $requests = request()->all();

        return Inertia::render('User/IndexUser', compact('users', 'requests'));
    }
}
