<?php

namespace App\Http\Controllers;

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

        //part where it checks what the email and passsword matches too
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('petowner')->attempt($credentials)) {
            return redirect()->route('pet-owner.dashboard');
        } elseif (Auth::guard('boardingcenter')->attempt($credentials)) {
            return redirect()->route('pet-boardingcenter.dashboard');
        } elseif (Auth::guard('trainingcenter')->attempt($credentials)) {
            return redirect()->route('pet-trainingcenter.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
