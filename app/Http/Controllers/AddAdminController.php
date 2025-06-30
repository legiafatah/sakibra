<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Juri;
use Illuminate\Support\Facades\Hash;

class AddAdminController extends Controller
{
    public function indexAdmin()
    {
        $admin = Admin::all();
        return view('superadmin.admin.index', compact('admin'));
    }

    public function createAdmin()
    {
        return view('superadmin.admin.create');
    }
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required|in:L,P',
            'no_wa' => 'required',
            'username' => 'required|unique:admin,username',
            'password' => 'required|min:6',
        ]);

        // dd($superadmin);
        Admin::create([
            'superadmin_id' => auth('superadmin')->user()->id,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'no_wa' => $request->no_wa,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => '1', // default
        ]);
        // dd('berhasil');
        return redirect()->route('admin_index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function toggleStatus(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Toggle status admin: kalau 1 jadi 0, kalau 0 jadi 1
        $admin->status = !$admin->status;
        $admin->save();

        // Update status peserta dan juri yang terkait admin ini
        $affectedPeserta = Peserta::where('admin_id', $admin->id)->update(['status' => $admin->status]);
        $affectedJuri = Juri::where('admin_id', $admin->id)->update(['status' => $admin->status]);

        return response()->json([
            'success' => true,
            'admin_status' => $admin->status,
            'peserta_updated' => $affectedPeserta,
            'juri_updated' => $affectedJuri
        ]);
    }



    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->back()->with('success', 'Akses juri berhasil dihapus.');
    }
}
