<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Merge guest session cart to user if necessary? 
            // The user requested: "generate guest session and as soon as use sign in or signup we will move guest session to user session"
            // Since I'm using session('cart'), it's already in the session.
            // If they login on a different device, we don't have a database-side cart yet.
            // For now, session-based cart persists across login if it's the same device.

            if (\Auth::user()->role === 'admin' || \Auth::user()->role === 'manager') {
                return redirect()->route('dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => \Hash::make($data['password']),
            'role' => 'customer',
        ]);

        \Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        \Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
