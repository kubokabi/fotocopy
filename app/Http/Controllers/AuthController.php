<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function add(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'terms' => 'required',
        ]);

        // Buat pengguna baru
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Autentikasi pengguna setelah registrasi
        Auth::login($user);

        // Menyimpan informasi username ke dalam session
        $request->session()->put('name', Auth::user()->name);

        // Redirect ke halaman dashboard atau notifikasi berhasil
        return redirect()->intended('dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }

    public function verify(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Autentikasi berhasil
            $request->session()->regenerate();

            // Menyimpan informasi username ke dalam session
            $request->session()->put('name', Auth::user()->name);

            // Redirect ke halaman dashboard atau halaman yang diinginkan
            return redirect()->intended('dashboard');
        }

        // Autentikasi gagal, redirect kembali dengan pesan error
        return redirect()->back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
