<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Kategori;
use App\Models\Hukuman;
use App\Models\HasilPenilaian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapAdminController extends Controller
{




    // public function rekapAdmin()
    // {
    //     $semuaKategori = DB::table('kategori')->pluck('nama', 'id');
    
    //     $subqueryHukuman = DB::table('hukuman')
    //         ->select('peserta_id', DB::raw('SUM(nilai) as total_hukuman'))
    //         ->groupBy('peserta_id');
    
    //     $data = DB::table('hasil_penilaian')
    //         ->join('peserta', 'hasil_penilaian.peserta_id', '=', 'peserta.id')
    //         ->join('detail_kategori', 'hasil_penilaian.detail_kategori_id', '=', 'detail_kategori.id')
    //         ->join('kategori', 'detail_kategori.kategori_id', '=', 'kategori.id')
    //         ->leftJoinSub($subqueryHukuman, 'hukuman', function ($join) {
    //             $join->on('peserta.id', '=', 'hukuman.peserta_id');
    //         })
    //         ->select([
    //             'peserta.id as peserta_id',
    //             'peserta.nama as nama_peserta',
    //             'kategori.id as kategori_id',
    //             'kategori.nama as nama_kategori',
    //             DB::raw('SUM(hasil_penilaian.nilai) as total_nilai_kategori'),
    //             DB::raw('COALESCE(hukuman.total_hukuman, 0) as pengurangan_nilai'),
    //         ])
    //         ->groupBy('peserta.id', 'peserta.nama', 'kategori.id', 'kategori.nama', 'hukuman.total_hukuman')
    //         ->get();
    
    //     $hasil = $data->groupBy('peserta_id')->map(function ($group, $pesertaId) use ($semuaKategori) {
    //         $row = ['nama_peserta' => $group->first()->nama_peserta];
    
    //         $penguranganNilai = $group->first()->pengurangan_nilai ?? 0;
    //         $row['pengurangan_nilai'] = $penguranganNilai;
    
    //         $totalNilaiKategori = 0;
    //         foreach ($semuaKategori as $kategoriId => $kategoriNama) {
    //             $kategoriData = $group->where('kategori_id', $kategoriId)->first();
    //             $nilaiKategori = $kategoriData ? $kategoriData->total_nilai_kategori : 0;
    //             $row[$kategoriNama] = $nilaiKategori;
    //             $totalNilaiKategori += $nilaiKategori;
    //         }
    
    //         $row['total_nilai'] = $totalNilaiKategori - $penguranganNilai;
    
    //         return (object)$row;
    //     })->values();
    
    //     $kategoriList = Kategori::all();
    
    //     return view('admin.rekapitulasi.index', [
    //         'kategoriList' => $kategoriList,
    //         'hasil' => $hasil,
    //         'semuaKategori' => $semuaKategori,
    //     ]);
    // }
    
    public function rekapAdmin()
    {
        $adminId = auth('admin')->user()->id;

        // Ambil semua kategori milik admin
        $kategoriList = Kategori::where('admin_id', $adminId)->get();
        $semuaKategori = $kategoriList->pluck('nama', 'id');

        // Ambil peserta milik admin
        $pesertaList = Peserta::where('admin_id', $adminId)->get();

        // Ambil semua hukuman milik peserta admin, grup by peserta_id
        $hukuman = Hukuman::whereIn('peserta_id', $pesertaList->pluck('id'))
            ->selectRaw('peserta_id, SUM(nilai) as total_hukuman')
            ->groupBy('peserta_id')
            ->get()
            ->keyBy('peserta_id');

        // Ambil hasil penilaian, hanya untuk peserta dan kategori milik admin
        $hasilPenilaian = HasilPenilaian::with(['peserta', 'detailKategori.kategori'])
            ->whereHas('peserta', function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->whereHas('detailKategori.kategori', function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->get();

        // Kelompokkan nilai per peserta dan kategori
        $grouped = $hasilPenilaian->groupBy(['peserta_id', function ($item) {
            return $item->detailKategori->kategori->id;
        }]);

        // Format hasil akhir
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

        return view('admin.rekapitulasi.index', [
            'kategoriList' => $kategoriList,
            'hasil' => $hasil,
            'semuaKategori' => $semuaKategori,
        ]);
    }

    
    // public function exportPDF()
    // {
    //     $semuaKategori = DB::table('kategori')->pluck('nama', 'id');
    
    //     // Subquery: total hukuman per peserta
    //     $subqueryHukuman = DB::table('hukuman')
    //         ->select('peserta_id', DB::raw('SUM(nilai) as total_hukuman'))
    //         ->groupBy('peserta_id');
    
    //     $data = DB::table('hasil_penilaian')
    //         ->join('peserta', 'hasil_penilaian.peserta_id', '=', 'peserta.id')
    //         ->join('detail_kategori', 'hasil_penilaian.detail_kategori_id', '=', 'detail_kategori.id')
    //         ->join('kategori', 'detail_kategori.kategori_id', '=', 'kategori.id')
    //         ->leftJoinSub($subqueryHukuman, 'hukuman', function ($join) {
    //             $join->on('peserta.id', '=', 'hukuman.peserta_id');
    //         })
    //         ->select([
    //             'peserta.id as peserta_id',
    //             'peserta.nama as nama_peserta',
    //             'kategori.id as kategori_id',
    //             'kategori.nama as nama_kategori',
    //             DB::raw('SUM(hasil_penilaian.nilai) as total_nilai_kategori'),
    //             DB::raw('COALESCE(hukuman.total_hukuman, 0) as pengurangan_nilai'),
    //         ])
    //         ->groupBy('peserta.id', 'peserta.nama', 'kategori.id', 'kategori.nama', 'hukuman.total_hukuman')
    //         ->get();
    
    //     $hasil = $data->groupBy('peserta_id')->map(function ($group, $pesertaId) use ($semuaKategori) {
    //         $row = ['nama_peserta' => $group->first()->nama_peserta];
    
    //         $penguranganNilai = $group->first()->pengurangan_nilai ?? 0;
    //         $row['pengurangan_nilai'] = $penguranganNilai;
    
    //         $totalNilaiKategori = 0;
    //         foreach ($semuaKategori as $kategoriId => $kategoriNama) {
    //             $kategoriData = $group->where('kategori_id', $kategoriId)->first();
    //             $nilaiKategori = $kategoriData ? $kategoriData->total_nilai_kategori : 0;
    //             $row[$kategoriNama] = $nilaiKategori;
    //             $totalNilaiKategori += $nilaiKategori;
    //         }
    
    //         $row['total_nilai'] = $totalNilaiKategori - $penguranganNilai;
    
    //         return (object)$row;
    //     })->values();
    
    //     $kategoriList = Kategori::all();
    
    //     $pdf = Pdf::loadView('admin.rekapitulasi.pdf', [
    //         'hasil' => $hasil,
    //         'kategoriList' => $kategoriList,
    //         'semuaKategori' => $semuaKategori,
    //     ]);
    
    //     return $pdf->download('rekapitulasi.pdf');
    // }

    public function exportPDF()
    {
        $adminId = auth('admin')->user()->id;

        // Ambil semua kategori milik admin
        $kategoriList = Kategori::where('admin_id', $adminId)->get();
        $semuaKategori = $kategoriList->pluck('nama', 'id');

        // Ambil semua peserta milik admin
        $pesertaList = Peserta::where('admin_id', $adminId)->get();

        // Ambil total hukuman per peserta
        $hukuman = Hukuman::whereIn('peserta_id', $pesertaList->pluck('id'))
            ->selectRaw('peserta_id, SUM(nilai) as total_hukuman')
            ->groupBy('peserta_id')
            ->get()
            ->keyBy('peserta_id');

        // Ambil hasil penilaian dengan relasi kategori dan peserta
        $hasilPenilaian = HasilPenilaian::with(['peserta', 'detailKategori.kategori'])
            ->whereHas('peserta', fn($q) => $q->where('admin_id', $adminId))
            ->whereHas('detailKategori.kategori', fn($q) => $q->where('admin_id', $adminId))
            ->get();

        // Kelompokkan data per peserta dan kategori
        $grouped = $hasilPenilaian->groupBy(['peserta_id', fn($item) => $item->detailKategori->kategori->id]);

        // Susun hasil akhir
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

        // Buat PDF
        $pdf = Pdf::loadView('admin.rekapitulasi.pdf', [
            'hasil' => $hasil,
            'kategoriList' => $kategoriList,
            'semuaKategori' => $semuaKategori,
            'isEmpty' => $hasil->isEmpty(),
        ]);

        return $pdf->download('rekapitulasi.pdf');
    }
    


 
    
}
