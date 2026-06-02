<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Hanya admin dan kurir yang bisa login ke panel web
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah')->withInput();
        }

        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'kurir'])) {
            Auth::logout();
            return back()->with('error', 'Akun Anda tidak memiliki akses ke panel admin')->withInput();
        }

        $request->session()->regenerate();

        return match($user->role) {
            'kurir' => redirect()->route('kurir.dashboard'),
            default => redirect()->route('admin.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
