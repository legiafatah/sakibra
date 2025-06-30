<?php

namespace App\Http\Controllers\Juri;

use Illuminate\Http\Request;
use App\Models\AksesJuri;
use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\DetailKategori;
use App\Models\HasilPenilaian;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HasilPenilaianController extends Controller
{
    public function index()
    {
        $juri = Auth::guard('juri')->user();
    
        if (!$juri) {
            return redirect()->route('juri_login')->with('error', 'Silakan login dulu.');
        }
    
        $kategori = $juri->aksesjuri->load('kategori');

        return view('juri.penilaian.index', compact('kategori'));
    }


    public function showLoginForm()
    {
        return view('juri.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('username', 'password');
    
        // Coba login pakai guard juri
        if (Auth::guard('juri')->attempt($credentials)) {
            // Login sukses
            return redirect()->route('juri_penilaian');
        }
    
        // Gagal login
        return back()->with('error', 'Username atau password salah');
    }

    
    public function logout(Request $request)
    {
        Auth::guard('juri')->logout();
    
        // Hapus session jika ada tambahan manual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->to('/')->with('success', 'Berhasil logout');
    }



    // public function mulai($kategori)
    // {
    //     $juri = auth('juri')->user();

    //     $kategoriObj = Kategori::findOrFail($kategori);  

    //     // Ambil peserta yang belum pernah dinilai oleh juri ini di kategori ini
    //     $sudahDinilai = HasilPenilaian::where('juri_id', $juri->id)
    //     ->whereHas('detailKategori', function ($query) use ($kategori) {
    //         $query->where('kategori_id', $kategori);
    //     })
    //     ->pluck('peserta_id')
    //     ->toArray();

    //     $peserta = Peserta::whereNotIn('id', $sudahDinilai)->get();

    //     $detailKategori = DetailKategori::where('kategori_id', $kategori)->get();

    //     return view('juri.penilaian.penilaian', [
    //         'kategori' => $kategoriObj->nama,      
    //         'kategori_id' => $kategoriObj->id,      
    //         'peserta' => $peserta,
    //         'detailKategori' => $detailKategori
    //     ]);
    // }


    public function mulai($kategori)
    {
        $juri = auth('juri')->user();

        $kategoriObj = Kategori::findOrFail($kategori);  

        // Ambil peserta yang sudah dinilai juri ini di kategori ini
        $sudahDinilai = HasilPenilaian::where('juri_id', $juri->id)
            ->whereHas('detailKategori', function ($query) use ($kategori) {
                $query->where('kategori_id', $kategori);
            })
            ->pluck('peserta_id')
            ->toArray();

        // Ambil peserta yang belum dinilai dan sesuai admin_id
        $peserta = Peserta::where('admin_id', $kategoriObj->admin_id) // filter by admin
            ->whereNotIn('id', $sudahDinilai)
            ->get();

        $detailKategori = DetailKategori::where('kategori_id', $kategori)->get();

        return view('juri.penilaian.penilaian', [
            'kategori' => $kategoriObj->nama,      
            'kategori_id' => $kategoriObj->id,      
            'peserta' => $peserta,
            'detailKategori' => $detailKategori
        ]);
    }


    public function submit(Request $request)
    {
        foreach ($request->nilai as $n) {
            HasilPenilaian::create([ 
                'juri_id' => auth('juri')->id(),
                'peserta_id' => $n['peserta_id'],
                'detail_kategori_id' => $n['detail_kategori_id'],
                'peringkat_id' => $n['peringkat_id'] ?? null,
                'nilai' => $n['nilai'],
                'status' => '1',
            ]);
        }

        return response()->json(['status' => 'sukses']);
    }

    



}
