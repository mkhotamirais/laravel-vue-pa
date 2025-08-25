<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|lowercase|email|max:255|unique:users',
            'password' => 'required|confirmed|min:3',
        ]);

        $user = User::create($credentials);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // return redirect()->intended(route('dashboard'));
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'msg' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        // return back()->with('msg', 'halo');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // return redirect('/');
        return redirect()->route('login');
    }
}
