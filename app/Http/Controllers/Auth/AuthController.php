<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => [
                'required',
                'string',
                'regex:/^[a-zA-Z][a-zA-Z0-9_-]*$/'
            ],
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Arahkan berdasarkan role pengguna
            $user = Auth::user();
            if ($user->role === 'admin  ') {
                return redirect()->intended('/admin-dashboard');
            } elseif ($user->role === 'mentor') {
                return redirect()->intended('/mentor-dashboard');
            } elseif ($user->role === 'peserta') {
                return redirect()->intended('/peserta-dashboard');
            }


            // Fallback jika role tidak dikenali (opsional)
            return redirect('/login')->withErrors(['username' => 'Role pengguna tidak valid.']);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}