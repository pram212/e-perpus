<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Revoke (hapus) token autentikasi pengguna saat logout
        $request->user()->tokens()->delete();

        return response()->json(['message' => "You'r Logged out"], 200);
    }
}
