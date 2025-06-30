<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Superadmin;
use App\Models\Admin;


class SuperadminController extends Controller
{
    public function showLoginForm()
    {
        return view('superadmin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate(); // regenerasi session agar lebih aman
            return redirect()->route('superadmin_dashboard');
        }
    
        return back()->with('error', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::guard('superadmin')->logout();
    
        // Hapus session jika ada tambahan manual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('superadmin_login')->with('success', 'Berhasil logout');
    }


    public function dashboard()
    {
        // dd(!Auth::guard('superadmin')->check());
        return view('superadmin.dashboard'); // Pastikan file ini ada
    }









}

