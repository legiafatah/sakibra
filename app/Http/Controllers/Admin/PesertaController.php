<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Admin;
use App\Http\Controllers\Controller;

class PesertaController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->user()->id;

        $peserta = Peserta::where('admin_id', $adminId)->get();

        return view('admin.peserta.index', compact('peserta'));
    }
    //     public function index()
    // {
    //     $adminId = auth('admin')->user()->id;
    //     $peserta = Peserta::where('admin_id', $adminId)->get();

    //     return view('admin.peserta.index', compact('peserta'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:sd,smp,smk',
            'no_peserta' => 'required|integer',
        ]);

        $kodeUnik = random_int(10000, 99999); // kode unik 5 digit
        Peserta::create([
            'admin_id' => auth('admin')->user()->id, // asumsi peserta diinput oleh admin login
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_peserta' => $request->no_peserta,
            'kode' => $kodeUnik,
            'status' => 1, // default aktif
            'date' => now(),
        ]);

        return back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $item = Peserta::findOrFail($id);
        $item->delete();
    
        return redirect()->back()->with('success', 'Peserta berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required',
            'no_peserta' => 'required|numeric',
        ]);
    
        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_peserta' => $request->no_peserta,
        ]);
    
        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
    

}
