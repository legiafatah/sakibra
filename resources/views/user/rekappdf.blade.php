<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        h3, h5, p {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .two-column-table {
            width: 100%;
        }

        .column {
            width: 49%;
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .text-right {
            text-align: right;
        }

    </style>
</head>
<body>

    <h3>Rekap Nilai Peserta</h3>
    <p>Nama: {{ $peserta->nama ?? 'Tidak ada nama peserta' }}</p>
    <br>

    @php
        $kategoriGroup = $hasilPenilaian->groupBy('detailKategori.kategori.nama')->values();
        $chunks = $kategoriGroup->chunk(ceil($kategoriGroup->count() / 2));
        $totalKategori = $hasilPenilaian->sum('nilai');
        $totalHukuman = $hukuman->sum('nilai');
        $totalAkhir = $totalKategori - $totalHukuman;
    @endphp

    <table class="two-column-table">
        <tr>
            @foreach($chunks as $i => $chunk)
                <td class="column">
                    @foreach($chunk as $kategoriNama => $penilaians)
                        @php
                            $juriList = $penilaians->pluck('juri')->unique('id')->values();
                            $detailGroup = $penilaians->groupBy('detailKategori.nama');
                            $nomor = 1;
                            $total = 0;
                        @endphp

                        <table>
                            <thead>
                                <tr>
                                    <th colspan="{{ 2 + $juriList->count() + 1 }}">Kategori: {{ strtoupper($penilaians->first()->detailKategori->kategori->nama) }}</th>
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
                                @foreach($detailGroup as $namaDetail => $nilaiSet)
                                    @php
                                        $jumlahNilai = 0;
                                        $nilaiPerJuri = $nilaiSet->keyBy('juri.id');
                                    @endphp
                                    <tr>
                                        <td>{{ $nomor++ }}</td>
                                        <td>{{ $namaDetail }}</td>
                                        @foreach($juriList as $juri)
                                            @php
                                                $nilai = $nilaiPerJuri->get($juri->id)?->nilai ?? null;
                                            @endphp
                                            <td>{{ $nilai !== null ? $nilai : '' }}</td>
                                            @php $jumlahNilai += $nilai ?? 0; @endphp
                                        @endforeach
                                        <td>{{ $jumlahNilai }}</td>
                                        @php $total += $jumlahNilai; @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="{{ 2 + $juriList->count() }}" class="text-right"><strong>TOTAL:</strong></td>
                                    <td><strong>{{ $total }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach

                    {{-- Tampilkan HUKUMAN dan TOTAL NILAI hanya di kolom terakhir --}}
                    @if($i == 1)
                        <h5>Hukuman</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Hukuman</th>
                                    <th>Nilai (-)</th>
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
                                <tr>
                                    <td class="text-right"><strong>Total Hukuman:</strong></td>
                                    <td><strong>{{ $totalHukuman }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <table>
                            <tr>
                                <td class="no-border text-right"><strong>Total Nilai: {{ $totalAkhir }}</strong></td>
                            </tr>
                        </table>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>

</body>
</html>
