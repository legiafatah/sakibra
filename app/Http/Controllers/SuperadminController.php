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

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);
    
    //     if (Auth::guard('superadmin')->attempt($credentials)) {
    //         $request->session()->regenerate(); // regenerasi session agar lebih aman
    //         return redirect()->route('superadmin_dashboard');
    //     }
    
    //     return back()->with('error', 'Username atau password salah');
    // }


        public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah ada user dengan username tersebut
        $superadmin = Superadmin::where('username', $credentials['username'])->first();

        if (!$superadmin) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        // Cek apakah status = 1
        if ($superadmin->status == 0) {
            return back()->with('error', 'Akun Anda tidak aktif');
        }

        // Lanjutkan proses login jika status aktif
        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('superadmin_dashboard');
        }

        return back()->with('error', 'Password salah');
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
        $adminList = Admin::all(); // Ambil semua admin
        return view('superadmin.admin.index', compact('adminList'));
    }

        public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $superadmin = Auth::guard('superadmin')->user(); // Ganti guard jika pakai default

        if (!Hash::check($request->old_password, $superadmin->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        $superadmin->password = Hash::make($request->new_password);
        $superadmin->save();

        return back()->with('success', 'Password berhasil diubah.');
    }








}

