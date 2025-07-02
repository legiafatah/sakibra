<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Juri;
use App\Models\AksesJuri;
use App\Models\DetailKategori;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Excel as BaseExcel;

class PenilaianController extends Controller
{
    public function index()
    {
        $adminId = Auth::guard('admin')->user()->id;

        $kategori = Kategori::where(function ($query) use ($adminId) {
            $query->whereHas('aksesjuri.juri', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })->orWhere(function ($q) use ($adminId) {
                // Data kategori yang belum punya aksesjuri,
                // tapi dibuat oleh admin yang sedang login
                $q->doesntHave('aksesjuri')->where('admin_id', $adminId);
            });
        })->get();

        $detailKategori = DetailKategori::where(function ($query) use ($adminId) {
            $query->whereHas('kategori.aksesjuri.juri', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })->orWhere(function ($q) use ($adminId) {
                $q->whereHas('kategori', function ($sub) use ($adminId) {
                    $sub->doesntHave('aksesjuri')->where('admin_id', $adminId);
                });
            });
        })->with('kategori')->get();
        return view('admin.penilaian.index', compact('kategori', 'detailKategori'));
    }




    public function detailKategori()
    {
         $adminId = Auth::guard('admin')->user()->id;

        $kategori = Kategori::where(function ($query) use ($adminId) {
            $query->whereHas('aksesjuri.juri', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })->orWhere(function ($q) use ($adminId) {
                // Data kategori yang belum punya aksesjuri,
                // tapi dibuat oleh admin yang sedang login
                $q->doesntHave('aksesjuri')->where('admin_id', $adminId);
            });
        })->get();

        $detailKategori = DetailKategori::where(function ($query) use ($adminId) {
            $query->whereHas('kategori.aksesjuri.juri', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })->orWhere(function ($q) use ($adminId) {
                $q->whereHas('kategori', function ($sub) use ($adminId) {
                    $sub->doesntHave('aksesjuri')->where('admin_id', $adminId);
                });
            });
        })->with('kategori')->get();
        return view('admin.penilaian.detail', compact('kategori', 'detailKategori'));
    }

   

    public function kategoriForm()
    {
        $kategori = Kategori::all();
        return view('penilaian.kategori', compact('kategori'));
    }

    public function simpanKategori(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori')->where(fn ($q) => $q->where('admin_id', auth('admin')->user()->id)),
            ],
        ], [
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ]);


        Kategori::create([
            
            'admin_id' => auth('admin')->user()->id,
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'excel_file' => 'required|mimes:xlsx',
        ]);

        $data = Excel::toArray([], $request->file('excel_file'));

        $rows = $data[0]; // ambil sheet pertama

        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // skip header
            if (isset($row[0]) && $row[0] !== null) {
                \App\Models\DetailKategori::create([
                    'nama' => $row[0],
                    'kategori_id' => $request->kategori_id
                ]);
            }
        }

        return back()->with('success', 'Berhasil mengimpor detail kategori.');
    }
    public function downloadTemplate()
    {
        $data = [
            ['nama'],
            ['Contoh Detail 1'],
            ['Contoh Detail 2'],
            ['Contoh Detail 3'],
        ];

        $filename = 'template_detail_kategori.xlsx';

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        }, $filename);
    }

    public function simpanDetailKategori(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255'
        ]);

        DetailKategori::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Detail kategori berhasil ditambahkan.');
    }

    public function destroyDetail($id)
    {
        $detail = DetailKategori::findOrFail($id);
        $detail->delete();
    
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }


    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
    
        // Cek apakah ada relasi detail kategori dengan kategori ini
        if ($kategori->detailKategori()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori sudah terpakai, tidak dapat dihapus.');
        }
    
        $kategori->delete();
    
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
    

    public function updateKategori(Request $request, $id)
    {
        $adminId = auth('admin')->user()->id;

        $validator = Validator::make($request->all(), [
            // 'nama' => 'required|string|max:255',
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori')->where(function ($query) use ($adminId) {
                return $query->where('admin_id', $adminId);
            })->ignore($id),
            ],
        ], [
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ]);

         if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('edit_kategori_id', $id); // untuk trigger modal edit
            }

        $kategori = Kategori::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function updateDetail(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        $detail = DetailKategori::findOrFail($id);
        $detail->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->back()->with('success', 'Detail kategori berhasil diperbarui.');
    }




}
