<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Juri;

class AdminController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->user()->id;
        $peserta = Peserta::where('admin_id', $adminId)->get();
        $juri = Juri::where('admin_id', $adminId)->get();
        return view('admin.dashboard', compact('juri', 'peserta'));
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);
    
    //     if (Auth::guard('admin')->attempt($credentials)) {
    //         $request->session()->regenerate(); // untuk keamanan session
    //         return redirect()->route('admin_dashboard');
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
        $admin = Admin::where('username', $credentials['username'])->first();

        if (!$admin) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        // Cek apakah status = 1
        if ($admin->status == 0) {
            return back()->with('error', 'Akun Anda tidak aktif');
        }

        // Lanjutkan proses login jika status aktif
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin_dashboard');
        }

        return back()->with('error', 'Password salah');
    }
    // public function toggleStatus(Request $request, $id)
    // {
    //     $admin = Admin::findOrFail($id);
    //     $newStatus = $request->status;
    //     $admin->status = $newStatus;
    //     $admin->save();

    //     $pesertaList = Peserta::where('admin_id', $admin->id)->get();
    //     foreach ($pesertaList as $peserta) {
    //         $peserta->status = $newStatus;
    //         $peserta->save();
    //     }
    //     $juriList = Juri::where('admin_id', $admin->id)->get();
    //     foreach ($juriList as $juri) {
    //         $juri->status = $newStatus;
    //         $juri->save();
    //     }
    
    //     return response()->json(['success' => true]);
    // }
    // public function toggleStatus(Request $request, $id)
    // {
    //     $admin = Admin::with(['peserta', 'juri'])->findOrFail($id);

    //     // Ubah status admin
    //     $admin->status = 0;
    //     $admin->save();

    //     // Nonaktifkan semua peserta yang dibuat oleh admin ini
    //     Peserta::where('admin_id', $admin->id)->update(['status' => 0]);

    //     // Nonaktifkan semua juri yang dibuat oleh admin ini
    //     Juri::where('admin_id', $admin->id)->update(['status' => 0]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Admin, peserta, dan juri berhasil dinonaktifkan.'
    //     ]);
    // }



    public function logout(Request $request)
    {
        Auth::guard('juri')->logout();
    
        // Hapus session jika ada tambahan manual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->to('/')->with('success', 'Berhasil logout');
    }

    public function dashboard()
    {
        return view('admin.dashboard'); // Pastikan file ini ada
    }

}
