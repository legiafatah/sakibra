<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 10px;
        }
        .kategori-box {
        width: 48%;
        box-sizing: border-box;
        }
        table {
            font-size: 10px;
            border-collapse: collapse;
        }
    
        th, td {
            padding: 4px;
            text-align: center;
        }
    
        th {
            background-color: #eee;
        }
    
        h3, p {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h3>Rekap Nilai Peserta</h3>
    <p>Nama: {{ $peserta->nama ?? 'Tidak ada nama peserta' }}</p>

    @php
    $kategoriGroup = $hasilPenilaian->groupBy('detailKategori.kategori.nama');
    @endphp
<div class="container">
@foreach($kategoriGroup as $kategoriNama => $penilaians)
<div class="kategori-box">
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
                @php
                    // Dapatkan semua juri unik yang menilai kategori ini
                    $juriList = $penilaians->pluck('juri')->unique('id')->values();
                @endphp
            <tr>
                <th colspan="{{ 2 + $juriList->count() + 1 }}">Kategori: {{ strtoupper($kategoriNama) }}</th>

            </tr>
            <tr>
                <th>No</th>
                <th>Detail Kategori</th>
                @foreach($juriList as $index => $juri)
                    <th>Juri {{ $index + 1 }}</th>
                @endforeach
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $detailGroup = $penilaians->groupBy('detailKategori.nama');
                $nomor = 1;
                $total = 0;
            @endphp

            @foreach($detailGroup as $namaDetail => $nilaiSet)
                <tr>
                    <td>{{ $nomor++ }}</td>
                    <td>{{ $namaDetail }}</td>

                    @php
                        $jumlahNilai = 0;
                        // Kelompokkan nilai berdasarkan ID juri
                        $nilaiPerJuri = $nilaiSet->keyBy('juri.id');
                    @endphp

                    @foreach($juriList as $juri)
                        @php
                            $nilai = $nilaiPerJuri->get($juri->id)?->nilai ?? null;
                        @endphp
                        <td>{{ $nilai !== null ? $nilai : '' }}</td>
                        @php
                            $jumlahNilai += $nilai ?? 0;
                        @endphp
                    @endforeach

                    <td>{{ $jumlahNilai }}</td>
                    @php $total += $jumlahNilai; @endphp
                </tr>
            @endforeach

            <tr>
                <td colspan="{{ 2 + $juriList->count() }}" align="right"><strong>TOTAL:</strong></td>
                <td><strong>{{ $total }}</strong></td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
@endforeach
</div>
<h4>Hukuman</h4>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>Nama Hukuman</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @forelse($hukuman as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nilai }}</td>
            </tr>
        @empty
            <tr><td colspan="2">Tidak ada hukuman</td></tr>
        @endforelse
    </tbody>
</table>



</body>
</html>
