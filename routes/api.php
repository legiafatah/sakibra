<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\BuktiPelanggaran;

Route::post('/pelanggaran', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'waktu' => 'required|date',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Simpan file ke storage
    $path = $request->file('gambar')->store('public/bukti');
    $filename = basename($path);

    // Simpan ke tabel bukti_pelanggaran
    BuktiPelanggaran::create([
        'image' => $filename,
        'waktu' => $request->waktu
    ]);

    return response()->json(['message' => 'Data berhasil disimpan']);
});
