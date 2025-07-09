<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\BuktiPelanggaran;

// Route::post('/pelanggaran', function (Request $request) {
//     $validator = Validator::make($request->all(), [
//         'waktu' => 'required|date',
//         'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
//     ]);
 
//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     // Simpan file ke storage
//     $path = $request->file('gambar')->store('public/bukti');
//     $filename = basename($path);

//     // Simpan ke tabel bukti_pelanggaran
//     BuktiPelanggaran::create([
//         'image' => $filename,
//         'waktu' => $request->waktu
//     ]);

//     return response()->json(['message' => 'Data berhasil disimpan']);
// });

Route::post('/pelanggaran', function (Request $request) {
    Log::info('Menerima request pelanggaran', ['data' => $request->all()]);

    $validator = Validator::make($request->all(), [
        'waktu' => 'required|date',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        // Simpan file ke storage
        $path = $request->file('gambar')->store('public/bukti');
        $filename = basename($path);
        Log::info('Gambar berhasil disimpan', ['path' => $path]);

        // Simpan ke database
        $bukti = BuktiPelanggaran::create([
            'image' => $filename,
            'waktu' => $request->waktu
        ]);
        Log::info('Data bukti pelanggaran berhasil disimpan', ['bukti' => $bukti]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    } catch (\Exception $e) {
        Log::error('Terjadi kesalahan saat menyimpan data', ['exception' => $e->getMessage()]);
        return response()->json(['message' => 'Terjadi kesalahan server'], 500);
    }
});