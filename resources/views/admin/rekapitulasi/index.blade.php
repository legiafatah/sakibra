@extends('admin.componen.app')
@section('content')

    <div class="row layout-top-spacing" id="cancel-row">
        

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Rekapitulasi Nilai Peserta</span>
                    <a href="{{ route('rekapitulasi.pdf') }}" class="btn btn-success">Download PDF</a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="alter_pagination" class="table table-hover" style="width:100%">
                        <thead >
                            <tr>
                                <th data-orderable="false">No</th>
                                <th>Nama Sekolah</th>
                                @foreach ($kategoriList as $kategori)
                                    <th>{{ $kategori->nama }}</th>
                                @endforeach
                                <th>PENGURANGAN</th>
                                <th>TOTAL</th>
                                {{-- <th >PERINGKAT</th> --}}
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($hasil as $key => $item)
                                <tr >
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        <div class="d-flex">
                                            <p class="align-self-center mb-0">{{ $item->nama_peserta }}</p>
                                        </div>
                                    </td>
                                    @foreach ($semuaKategori as $kategoriId => $kategoriNama)
                                        <td>{{ $item->$kategoriNama ?? 0 }}</td>
                                    @endforeach
                                    <td>{{ $item->pengurangan_nilai }}</td>
                                    <td>{{ $item->total_nilai }}</td>
                                    {{-- <td>-</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
