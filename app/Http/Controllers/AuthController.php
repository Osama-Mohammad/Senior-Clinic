<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }


    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::guard('patient')->attempt($validated)) {
            // dd('Patient login successful');
            // patient.dashboard
            return redirect()->route('patient.show', Auth::guard('patient')->user())->with('success', 'Login successful');
        } elseif (Auth::guard('admin')->attempt($validated)) {

            return redirect()->route('admin.dashboard', Auth::guard('admin')->user())->with('success', 'Login successful');
        } elseif (Auth::guard('doctor')->attempt($validated)) {

            return redirect()->route('doctor.dashboard')->with('success', 'Login successful');
        } elseif (Auth::guard('secretary')->attempt($validated)) {
            dd('Secretary login successful');
            return redirect()->route('secretary.dashboard')->with('success', 'Login successful');
        } else {
            return back()->with('error', 'Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('patient')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        // Auth::guard('secretary')->logout();

        return redirect()->route('auth.loginPage')->with('success', 'Logout successful');
    }
}
