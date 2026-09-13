<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba login dengan field 'name' sebagai username
        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

  


            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard/admin');
            } elseif ($user->role === 'sales') {
                return redirect()->intended('/dashboard/sales');
            }

            // fallback (seharusnya tidak terjadi)
            return redirect('/dashboard');
        }

        // Jika gagal, kembali dengan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
