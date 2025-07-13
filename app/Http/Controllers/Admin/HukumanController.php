<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Hukuman;
use App\Models\Peserta;
use App\Http\Controllers\Controller;
use App\Models\BuktiPelanggaran;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HukumanController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->user()->id;
        $peserta = Peserta::where('admin_id', $adminId)->get();

    // Ambil hukuman yang berelasi dengan peserta milik admin yang sedang login
        $hukuman = Hukuman::whereHas('peserta', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->with('peserta')->get();
            return view('admin.hukuman.index', compact('hukuman', 'peserta'));
        }

    public function bukti()
    {
        $adminId = auth('admin')->user()->id;
        $peserta = Peserta::where('admin_id', $adminId)->get();
        $pelanggaran = BuktiPelanggaran::all();
        // test
        return view('admin.hukuman.bukti', compact('pelanggaran', 'peserta'));
    }
    //storegae
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'peserta_id' => 'required',
    //         'nama' => 'required',
    //         'nilai' => 'required|numeric',
    //         'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $bukti = null;
    //     if ($request->hasFile('bukti')) {
    //         $bukti = $request->file('bukti')->store('bukti', 'public');
    //     }

    //     Hukuman::create([
    //         'peserta_id' => $request->peserta_id,
    //         'nama' => $request->nama,
    //         'nilai' => $request->nilai,
    //         'bukti' => $bukti,
    //     ]);

    //     return back()->with('success', 'Hukuman berhasil ditambahkan.');
    // }

    //public
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'peserta_id' => 'required',
    //         'nama' => 'required',
    //         'nilai' => 'required|numeric',
    //         'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $bukti = null;
    //     if ($request->hasFile('bukti')) {
    //         $file = $request->file('bukti');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('bukti'), $filename);
    //         $bukti = 'bukti/' . $filename; // path relatif ke folder public
    //     }

    //     Hukuman::create([
    //         'peserta_id' => $request->peserta_id,
    //         'nama' => $request->nama,
    //         'nilai' => $request->nilai,
    //         'bukti' => $bukti,
    //     ]);

    //     return back()->with('success', 'Hukuman berhasil ditambahkan.');
    // }


    // public function store(Request $request)
    // {
    //     // Jika input waktu_awal dan waktu_akhir ada, jalankan logika ambil dari bukti_pelanggaran
    //     if ($request->filled('waktu_awal') && $request->filled('waktu_akhir')) {
    //         $request->validate([
    //             'waktu_awal' => 'required|date',
    //             'waktu_akhir' => 'required|date|after_or_equal:waktu_awal',
    //         ]);

    //         $start = Carbon::parse($request->waktu_awal);
    //         $end = Carbon::parse($request->waktu_akhir);

    //         $buktiList = BuktiPelanggaran::whereBetween('waktu', [$start, $end])->get();

    //         foreach ($buktiList as $bukti) {
    //             $oldPath = public_path('bukti_pelanggaran/' . $bukti->image);

    //             if (File::exists($oldPath)) {
    //                 $newName = time() . '_' . Str::random(5) . '_' . $bukti->image;
    //                 $newPath = public_path('bukti/' . $newName);

    //                 File::copy($oldPath, $newPath);

    //                 Hukuman::create([
    //                     'peserta_id' => $request->peserta_id ?? null,
    //                     'nama' => $request->nama ?? 'Pelanggaran dari rekaman',
    //                     'nilai' => $request->nilai ?? 1,
    //                     'bukti' => 'bukti/' . $newName,
    //                 ]);
    //             }
    //         }

    //         return back()->with('success', 'Data dari bukti pelanggaran berhasil dimasukkan.');
    //     }

    //     // Jika tidak, proses input manual
    //     $request->validate([
    //         'peserta_id' => 'required',
    //         'nama' => 'required',
    //         'nilai' => 'required|numeric',
    //         'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $bukti = null;
    //     if ($request->hasFile('bukti')) {
    //         $file = $request->file('bukti');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('bukti'), $filename);
    //         $bukti = 'bukti/' . $filename;
    //     }

    //     Hukuman::create([
    //         'peserta_id' => $request->peserta_id,
    //         'nama' => $request->nama,
    //         'nilai' => $request->nilai,
    //         'bukti' => $bukti,
    //     ]);

    //     return back()->with('success', 'Hukuman berhasil ditambahkan.');
    // }

    // public function store(Request $request)
    // {
    //     $relativePath = 'bukti'; // untuk disimpan di DB

    //     // Proses otomatis berdasarkan waktu_awal dan waktu_akhir
    //     if ($request->filled('waktu_awal') && $request->filled('waktu_akhir')) {
    //         $request->validate([
    //             'waktu_awal' => 'required|date',
    //             'waktu_akhir' => 'required|date|after_or_equal:waktu_awal',
    //         ]);

    //         $start = Carbon::parse($request->waktu_awal);
    //         $end = Carbon::parse($request->waktu_akhir);

    //         $buktiList = BuktiPelanggaran::whereBetween('waktu', [$start, $end])->get();

    //         foreach ($buktiList as $bukti) {
    //             // File sudah ada di folder bukti, tidak perlu dipindahkan
    //             // Pastikan hanya ambil nama file-nya
    //             $filename = $bukti->image;

    //             // Simpan path relatif ke database
    //             Hukuman::create([
    //                 'peserta_id' => $request->peserta_id ?? null,
    //                 'nama' => $request->nama ?? 'Pelanggaran dari rekaman',
    //                 'nilai' => $request->nilai ?? 1,
    //                 'bukti' => $relativePath . '/' . $filename,
    //             ]);
    //         }

    //         return back()->with('success', 'Data dari bukti pelanggaran berhasil dimasukkan.');
    //     }

    //     // Proses input manual
    //     $request->validate([
    //         'peserta_id' => 'required',
    //         'nama' => 'required',
    //         'nilai' => 'required|numeric',
    //         'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $bukti = null;
    //     if ($request->hasFile('bukti')) {
    //         $file = $request->file('bukti');
    //         $filename = time() . '_' . $file->getClientOriginalName();

    //         // Pindah file upload ke folder bukti
    //         $uploadPath = '/home/sakibrao/public_html/bukti';
    //         if (!File::exists($uploadPath)) {
    //             File::makeDirectory($uploadPath, 0755, true);
    //         }

    //         $file->move($uploadPath, $filename);
    //         $bukti = $relativePath . '/' . $filename;
    //     }

    //     Hukuman::create([
    //         'peserta_id' => $request->peserta_id,
    //         'nama' => $request->nama,
    //         'nilai' => $request->nilai,
    //         'bukti' => $bukti,
    //     ]);

    //     return back()->with('success', 'Hukuman berhasil ditambahkan.');
    // }

    public function store(Request $request)
{
    $relativePath = 'bukti'; // path gambar yang akan disimpan di DB

    // === JIKA MENGISI WAKTU ===
    if ($request->filled('waktu_awal') && $request->filled('waktu_akhir')) {
        $request->validate([
            'peserta_id' => 'required',
            'waktu_awal' => 'required|date',
            'waktu_akhir' => 'required|date|after_or_equal:waktu_awal',
            'nama'       => 'nullable|string',
            'nilai'      => 'nullable|numeric',
        ]);

        $start = \Carbon\Carbon::parse($request->waktu_awal);
        $end = \Carbon\Carbon::parse($request->waktu_akhir);

        $buktiList = \App\Models\BuktiPelanggaran::whereBetween('waktu', [$start, $end])->get();

        if ($buktiList->isEmpty()) {
            return back()->with('error', 'Tidak ada bukti pelanggaran pada waktu tersebut.');
        }

        foreach ($buktiList as $bukti) {
            \App\Models\Hukuman::create([
                'peserta_id' => $request->peserta_id,
                'nama'       => $request->nama ?: 'Pelanggaran otomatis',
                'nilai'      => $request->nilai ?: 1,
                'bukti'      => $relativePath . '/' . $bukti->image,
            ]);
        }

        return back()->with('success', 'Hukuman berhasil dibuat dari data pelanggaran.');
    }

    // === JIKA MENGISI MANUAL (upload file) ===
    $request->validate([
        'peserta_id' => 'required',
        'nama'       => 'required|string',
        'nilai'      => 'required|numeric',
        'bukti'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $bukti = null;
    if ($request->hasFile('bukti')) {
        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();

        $uploadPath = public_path($relativePath);
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $filename);
        $bukti = $relativePath . '/' . $filename;
    }

    \App\Models\Hukuman::create([
        'peserta_id' => $request->peserta_id,
        'nama'       => $request->nama,
        'nilai'      => $request->nilai,
        'bukti'      => $bukti,
    ]);

    return back()->with('success', 'Hukuman berhasil ditambahkan.');
}




    



    public function destroy($id)
    {
        $h = Hukuman::findOrFail($id);
        $h->delete();
    
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function destroyBukti($id)
    {
        $bukti = BuktiPelanggaran::findOrFail($id);
        $bukti->delete();
    
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
    public function destroyAll()
    {
        
        BuktiPelanggaran::truncate();
        return redirect()->back()->with('success', 'Semua bukti berhasil dihapus.');
        
       
    }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'nilai' => 'required|numeric',
    //         'bukti' => 'nullable|image|max:2048',
    //     ]);

    //     $hukuman = Hukuman::findOrFail($id);

    //     $hukuman->nama = $request->nama;
    //     $hukuman->nilai = $request->nilai;

    //     if ($request->hasFile('bukti')) {
    //         // Simpan file baru
    //         $file = $request->file('bukti');
    //         $path = $file->store('bukti', 'public');

    //         // Hapus file lama (opsional)
    //         if ($hukuman->bukti && Storage::disk('public')->exists($hukuman->bukti)) {
    //             Storage::disk('public')->delete($hukuman->bukti);
    //         }

    //         $hukuman->bukti = $path;
    //     }

    //     $hukuman->save();

    //     return redirect()->back()->with('success', 'Hukuman berhasil diperbarui.');
    // }




    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'bukti' => 'nullable|image|max:2048',
        ]);

        $hukuman = Hukuman::findOrFail($id);
        $hukuman->nama = $request->nama;
        $hukuman->nilai = $request->nilai;

        // Path absolut ke folder bukti di public_html
        $destinationPath = '/home/sakibrao/public_html/bukti';
        $relativePath = 'bukti'; // untuk disimpan di database

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Hapus file lama jika ada
            $oldFilePath = '/home/sakibrao/public_html/' . $hukuman->bukti;
            if ($hukuman->bukti && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Simpan file baru ke folder bukti
            $file->move($destinationPath, $fileName);

            // Simpan path relatif ke database
            $hukuman->bukti = $relativePath . '/' . $fileName;
    }

        $hukuman->save();

        return redirect()->back()->with('success', 'Hukuman berhasil diperbarui.');
    }


}
