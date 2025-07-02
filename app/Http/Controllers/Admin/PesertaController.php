<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PesertaController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->user()->id;

        $pesertas = Peserta::where('admin_id', $adminId)->get();
        $lastPeserta = Peserta::where('admin_id', $adminId)
                    ->orderBy('no_peserta', 'desc')
                    ->first();
        $nextNo = $lastPeserta ? intval($lastPeserta->no_peserta) + 1 : 1;
        $formattedNo = str_pad($nextNo, 3, '0', STR_PAD_LEFT);

        return view('admin.peserta.index', compact('pesertas', 'formattedNo'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('peserta')->where(function ($query) {
                    return $query->where('admin_id', auth('admin')->user()->id);
                    }),
            ],
            'kategori' => 'required|in:sd,smp,smk',
        ], [
            'nama.unique' => 'Nama Peserta Sudah Terdaftar.',
        ]);

        $adminId = auth('admin')->user()->id;

        // Ambil no_peserta terakhir dari admin yang sama
        $lastPeserta = Peserta::where('admin_id', $adminId)
                        ->orderBy('no_peserta', 'desc')
                        ->first();

        // Hitung nomor berikutnya
        $nextNo = $lastPeserta ? intval($lastPeserta->no_peserta) + 1 : 1;

        // Batasi sampai 999
        if ($nextNo > 999) {
            return back()->withErrors(['no_peserta' => 'Nomor peserta sudah mencapai batas maksimum (999).']);
        }

        // Simpan hasil ke $formattedNo
        $formattedNo = str_pad($nextNo, 3, '0', STR_PAD_LEFT);

        $kodeUnik = random_int(10000, 99999); // kode unik 5 digit

        Peserta::create([
            'admin_id' => $adminId,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_peserta' => $formattedNo,
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
        $adminId = auth('admin')->user()->id;

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('peserta')->where(function ($query) use ($adminId) {
                    return $query->where('admin_id', $adminId);
                })->ignore((int) $id, 'id'),
            ],
            'kategori' => 'required',
            'no_peserta' => 'required|numeric',
        ], [
            'nama.unique' => 'Nama Peserta Sudah Terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('edit_modal_id', $id);
        }

        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_peserta' => $request->no_peserta,
        ]);

        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
    
}
