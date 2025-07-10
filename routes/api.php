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
    Log::info('Menerima request base64', ['data' => $request->all()]);

    $request->validate([
        'waktu' => 'required|date',
        'gambar_base64' => 'required|string',
        'filename' => 'required|string'
    ]);

    try {
        $filename = time() . '_' . $request->filename;

        $publicHtmlPath = '/home/sakibrao/public_html/bukti';

        // Buat folder jika belum ada
        if (!file_exists(public_path('bukti'))) {
            mkdir(public_path('bukti'), 0755, true);
        }
        $decoded = base64_decode($request->gambar_base64);

        file_put_contents($publicHtmlPath, $decoded);

        BuktiPelanggaran::create([
            'image' => $filename,
            'waktu' => $request->waktu
        ]);

        Log::info("✅ Gambar disimpan sebagai {$filename}");

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    } catch (\Exception $e) {
        Log::error("❌ Gagal menyimpan base64", ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Gagal menyimpan gambar'], 500);
    }
});