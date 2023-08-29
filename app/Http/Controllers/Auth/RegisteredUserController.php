<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nirm' => ['numeric', 'unique:'. Profile::class],
            'phone' => ['unique:'. Profile::class],
        ],
        [
            'name.required' => 'nama lengkap wajib diisi',
            'name.string' => 'nama lengkap tidak boleh menandung angka',
            'email.required' => 'email wajib diisi',
            'email.email' => 'masukan alamat email yang valid cth: jhon@mail.com',
            'password.required' => 'password wajib diisi',
            'password.confirmed' => 'konfirmasi password salah',
            'nirm.required' => 'nirm wajib diisi',
            'nirm.unique' => 'nirm ini sudah terdaftar',
            'nirm.numeric' => 'nirm harus berupa angka',
            'phone.unique' => 'no telepon ini sudah terdaftar',
            'phone.required' => 'telepon wajib diisi',

        ]
    );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->profile()->create([
            'nirm'=> $request->nirm,
            'phone'=> $request->phone,
            'address'=> $request->address
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
