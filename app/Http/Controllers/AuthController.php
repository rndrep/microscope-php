<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {

    }

    public function register(Request  $request)
    {

    }

    public function loginForm()
    {
//        return view('login');
        return view('main.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                //TODO: check why don't redirect
                return redirect()->route('rocks.index');
            }
            return redirect()->intended();
        }
        return back()->withErrors([
            'email' => 'почта и/или пароль неверны'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
