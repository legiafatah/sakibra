
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Rekapitulasi</h2>


    @php
    // Ambil nama-nama kategori
    $kategoriNames = $semuaKategori->values()->toArray();

    // Ambil semua nilai untuk masing-masing kategori
    $rankingPerKategori = [];
    foreach ($kategoriNames as $kategori) {
        $rankingPerKategori[$kategori] = collect($hasil)->pluck($kategori)->sortDesc()->values();
    }

    // Ambil nilai total dan urutkan
    $rankingTotal = collect($hasil)->pluck('total_nilai')->sortDesc()->values();
    @endphp

   @if ($hasil->isEmpty())
    <p style="text-align: center; margin-top: 40px; font-size: 16px;">
        <strong>Belum ada data rekap.</strong>
    </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sekolah</th>
                    @foreach($kategoriList as $kategori)
                        <th>{{ $kategori->nama }}</th>
                    @endforeach
                    <th>Pengurangan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_peserta }}</td>
                    @foreach ($semuaKategori as $kategoriId => $kategoriNama)
                        @php
                            $value = $item->$kategoriNama ?? 0;
                            $rank = $rankingPerKategori[$kategoriNama]->search($value);
                            $bgColor = '';
                            if ($rank === 0) $bgColor = 'background-color: #f87171'; // Merah
                            elseif ($rank === 1) $bgColor = 'background-color: #facc15'; // Kuning
                            elseif ($rank === 2) $bgColor = 'background-color: #4ade80'; // Hijau
                        @endphp
                        <td style="{{ $bgColor }}">{{ $value }}</td>
                    @endforeach
                    <td>{{ $item->pengurangan_nilai }}</td>
                    @php
                        $value = $item->total_nilai;
                        $rank = $rankingTotal->search($value);
                        $bgColor = '';
                        if ($rank === 0) $bgColor = 'background-color: #f87171'; // Merah
                        elseif ($rank === 1) $bgColor = 'background-color: #facc15'; // Kuning
                        elseif ($rank === 2) $bgColor = 'background-color: #4ade80'; // Hijau
                    @endphp
                    <td style="{{ $bgColor }}">{{ $value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (!$hasil->isEmpty())
        <table style="width: 40%; margin-top: 20px;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: left;">Keterangan Warna Peringkat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #f87171; width: 30px;"></td>
                    <td>Peringkat 1 </td>
                </tr>
                <tr>
                    <td style="background-color: #facc15;"></td>
                    <td>Peringkat 2</td>
                </tr>
                <tr>
                    <td style="background-color: #4ade80;"></td>
                    <td>Peringkat 3</td>
                </tr>
            </tbody>
        </table>
    @endif

</body>
</html>
