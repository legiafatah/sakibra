<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\AksesJuri;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AddJuriController extends Controller
{
    public function index()
    {
        
        $adminId = auth('admin')->user()->id;
        $juri = Juri::where('admin_id', $adminId)->get();
        $kategori = Kategori::where('admin_id', $adminId)->get();
        $aksesJuri = AksesJuri::with(['juri', 'kategori'])
        ->whereHas('juri', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->whereHas('kategori', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->get();
        return view('admin.juri.index', compact('juri', 'kategori','aksesJuri'));
    }

    public function aksesJuri()
    {
        $adminId = auth('admin')->user()->id;
        $juri = Juri::where('admin_id', $adminId)->get();
        $kategori = Kategori::where('admin_id', $adminId)->get();
        $aksesJuri = AksesJuri::with(['juri', 'kategori'])
        ->whereHas('juri', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->whereHas('kategori', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->get();

        return view('admin.juri.akses', compact('juri', 'kategori', 'aksesJuri'));
    }

    public function create()
    {
        return view('admin.juri.create');
    }


    public function storeAksesJuri(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'juri_id' => 'required|exists:juri,id',
        ]);
    
        // Cek duplikat juri pada kategori (jika ingin mencegah input ganda)
        $cek = AksesJuri::where('kategori_id', $request->kategori_id)
                        ->where('juri_id', $request->juri_id)
                        ->first();
    
        if ($cek) {
            return back()->with('error', 'Juri ini sudah memiliki akses penilaian tersebut.');
        }
    
        AksesJuri::create([
            'kategori_id' => $request->kategori_id,
            'juri_id' => $request->juri_id,
        ]);
    
        return back()->with('success', 'Akses Juri berhasil ditambahkan');
    }
    




    public function storeJuri(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:L,P',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('juri')->where(function ($query) {
                    return $query->where('admin_id', auth('admin')->user()->id);
                }),
            ],
            'password' => 'required|string|min:4',
        ], [
            'username.unique' => 'Username sudah digunakan.',
        ]);
       
        
        Juri::create([
            // 'admin_id' => Auth::guard('admin')->id(), // pastikan guard admin kamu sudah diset
            'admin_id' => auth('admin')->user()->id,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => '1',
        ]);

        return redirect()->route('juri.index')->with('success', 'Juri berhasil ditambahkan.');
    }

    public function destroyAksesJuri($id)
    {
        $akses = AksesJuri::findOrFail($id);
        $akses->delete();
    
        return redirect()->back()->with('success', 'Akses Juri berhasil dihapus.');
    }

    public function destroyJuri($id)
    {
        $juri = Juri::findOrFail($id);

        if ($juri->aksesJuri()->exists()) {
            return redirect()->back()->with('error', 'Juri sudah terakses, tidak dapat dihapus.');
        }

        $juri->delete();

        return redirect()->back()->with('success', 'Juri berhasil dihapus.');
    }



    public function update(Request $request, $id)
    {
        $adminId = auth('admin')->user()->id;
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:L,P',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('juri')->where(function ($query) use ($adminId) {
                    return $query->where('admin_id', $adminId);
                })->ignore((int) $id, 'id'),
            ],
            'password' => 'nullable|string|min:4',
        ], [
            'username.unique' => 'Username sudah digunakan.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('edit_modal_id', $id); // kirim id ke blade
        }

        $juri = Juri::findOrFail($id);
        $juri->nama = $request->nama;
        $juri->jk = $request->jk;
        $juri->username = $request->username;
    
        // Ubah password hanya jika diisi
        if ($request->filled('password')) {
            $juri->password = bcrypt($request->password);
        }
    
        $juri->save();
    
        return redirect()->back()->with('success', 'Data juri berhasil diperbarui.');
    }
    
}
