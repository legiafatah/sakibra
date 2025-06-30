<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HasilPenilaian;
use App\Models\Peserta;
use App\Models\Kategori;
use App\Models\Hukuman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'kode' => 'required',
        ]);
    
        $peserta = Peserta::where('kode', $credentials['kode'])->first();
    
        if ($peserta) {
            Auth::guard('peserta')->login($peserta);
            $request->session()->regenerate(); // untuk keamanan session
            return redirect()->route('user.dashboard');
        }
    
        return back()->with('error', 'Kode tidak ditemukan');
    }

    // public function detail()
    // {
    //     $peserta = Auth::guard('peserta')->user();
    //     $hukuman = $peserta->hukuman;
    //     $peserta = Peserta::all();
    //     return view('user.rekap-detail', compact( 'peserta', 'hukuman'));
    // }

    public function detail()
    {
        $pesertaLogin = Auth::guard('peserta')->user();

        // Ambil semua peserta yang memiliki admin_id yang sama
        $pesertaList = Peserta::where('admin_id', $pesertaLogin->admin_id)->get();

        // Ambil kategori milik admin yang sama
        $kategoriList = Kategori::where('admin_id', $pesertaLogin->admin_id)->get();
        $semuaKategori = $kategoriList->pluck('nama', 'id');

        // Ambil semua hukuman untuk peserta-peserta tersebut
        $hukuman = Hukuman::whereIn('peserta_id', $pesertaList->pluck('id'))
            ->selectRaw('peserta_id, SUM(nilai) as total_hukuman')
            ->groupBy('peserta_id')
            ->get()
            ->keyBy('peserta_id');

        // Ambil semua hasil penilaian untuk peserta-peserta tersebut
        $hasilPenilaian = HasilPenilaian::with(['detailKategori.kategori'])
            ->whereIn('peserta_id', $pesertaList->pluck('id'))
            ->get();

        // Kelompokkan nilai per peserta dan kategori
        $grouped = $hasilPenilaian->groupBy(['peserta_id', function ($item) {
            return $item->detailKategori->kategori->id;
        }]);

        // Format data akhir
        $hasil = collect();

        foreach ($grouped as $pesertaId => $kategoriGroup) {
            $peserta = $pesertaList->firstWhere('id', $pesertaId);

            $row = [
                'nama_peserta' => $peserta->nama,
                'pengurangan_nilai' => $hukuman[$pesertaId]->total_hukuman ?? 0,
            ];

            $totalNilaiKategori = 0;

            foreach ($semuaKategori as $kategoriId => $kategoriNama) {
                $nilaiKategori = isset($kategoriGroup[$kategoriId])
                    ? $kategoriGroup[$kategoriId]->sum('nilai')
                    : 0;

                $row[$kategoriNama] = $nilaiKategori;
                $totalNilaiKategori += $nilaiKategori;
            }

            $row['total_nilai'] = $totalNilaiKategori - $row['pengurangan_nilai'];

            $hasil->push((object) $row);
        }

        return view('user.dashboard', [
            'pesertaLogin' => $pesertaLogin,
            'pesertaList' => $pesertaList,
            'kategoriList' => $kategoriList,
            'semuaKategori' => $semuaKategori,
            'hasil' => $hasil,
        ]);
    }

    public function hukuman()
    {
        $peserta = Auth::guard('peserta')->user();

        $hukuman = $peserta->hukuman
            ->groupBy('nama')
            ->map(function ($group) {
                return [
                    'nama' => $group->first()->nama,
                    'total_nilai' => $group->sum('nilai'),
                    'bukti_list' => $group->pluck('bukti')->filter()->all(), // hanya ambil yang tidak null
                    'peserta_nama' => $group->first()->peserta->nama ?? '-',
                ];
            })->values();

        return view('user.hukuman', compact('peserta', 'hukuman'));
    }


    public function rekapUser()
    {
        $semuaKategori = DB::table('kategori')->pluck('nama', 'id');
    
        // Subquery total hukuman per peserta
        $subqueryHukuman = DB::table('hukuman')
            ->select('peserta_id', DB::raw('SUM(nilai) as total_hukuman'))
            ->groupBy('peserta_id');
    
        $data = DB::table('hasil_penilaian')
            ->join('peserta', 'hasil_penilaian.peserta_id', '=', 'peserta.id')
            ->join('detail_kategori', 'hasil_penilaian.detail_kategori_id', '=', 'detail_kategori.id')
            ->join('kategori', 'detail_kategori.kategori_id', '=', 'kategori.id')
            ->leftJoinSub($subqueryHukuman, 'hukuman', function ($join) {
                $join->on('peserta.id', '=', 'hukuman.peserta_id');
            })
            ->select([
                'peserta.id as peserta_id',
                'peserta.nama as nama_peserta',
                'kategori.id as kategori_id',
                'kategori.nama as nama_kategori',
                DB::raw('SUM(hasil_penilaian.nilai) as total_nilai_kategori'),
                DB::raw('COALESCE(hukuman.total_hukuman, 0) as pengurangan_nilai'),
            ])
            ->groupBy('peserta.id', 'peserta.nama', 'kategori.id', 'kategori.nama', 'hukuman.total_hukuman')
            ->get();
    
        $hasil = $data->groupBy('peserta_id')->map(function ($group, $pesertaId) use ($semuaKategori) {
            $row = ['nama_peserta' => $group->first()->nama_peserta];
    
            $penguranganNilai = $group->first()->pengurangan_nilai ?? 0;
            $row['pengurangan_nilai'] = $penguranganNilai;
    
            $totalNilaiKategori = 0;
            foreach ($semuaKategori as $kategoriId => $kategoriNama) {
                $kategoriData = $group->where('kategori_id', $kategoriId)->first();
                $nilaiKategori = $kategoriData ? $kategoriData->total_nilai_kategori : 0;
                $row[$kategoriNama] = $nilaiKategori;
                $totalNilaiKategori += $nilaiKategori;
            }
    
            $row['total_nilai'] = $totalNilaiKategori - $penguranganNilai;
    
            return (object)$row;
        })->values();
    
        $kategoriList = Kategori::all();
    
        return view('user.dashboard', [
            'kategoriList' => $kategoriList,
            'hasil' => $hasil,
            'semuaKategori' => $semuaKategori,
        ]);
    }





    public function rekapPesertaPDF()
    {
        $peserta = Auth::guard('peserta')->user(); // pastikan guard-nya sesuai
    
        // Muat hasilPenilaian beserta relasi detailKategori dan kategori
        $hasilPenilaian = $peserta->hasilPenilaian()
            ->with(['detailKategori.kategori', 'juri']) // Eager load kategori lewat detailKategori
            ->get();
    
        // Ambil relasi hukuman
        $hukuman = $peserta->hukuman;
        // dd($hasilPenilaian);
        $pdf = PDF::loadView('user.rekappdf', compact('peserta', 'hasilPenilaian', 'hukuman'));
        return $pdf->download('rekap_nilai_' . $peserta->nama . '.pdf');
    }
    

    public function logout(Request $request)
    {
        Auth::guard('peserta')->logout();
    
        // Hapus session jika ada tambahan manual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->to('/')->with('success', 'Berhasil logout');
    }


 


}
