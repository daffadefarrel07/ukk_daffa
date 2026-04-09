<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required|string|max:10',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended('/siswa/dashboard');
        }

return back()->withErrors(['nis' => 'NIS atau password salah'])->onlyInput('nis');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:10|unique:users,nis',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nis' => $data['nis'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect('/siswa/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
