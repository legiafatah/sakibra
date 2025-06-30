@extends('admin.componen.app')
@section('content')


<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span>Data Peserta</span>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="alter_pagination" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Kategori</th>
                            <th>No Peserta</th>
                            <th>Kode</th>
                         
         
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peserta as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ strtoupper($item->kategori) }}</td>
                                <td>{{ $item->no_peserta }}</td>
                                <td>{{ $item->kode }}</td>

                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Belum ada peserta.</td></tr>
                        @endforelse
                    </tbody>
           
                </table>
            </div>
        </div>
    </div>
</div>


    <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span>Data Juri</span>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="alter_pagination2" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>Username</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($juri as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->jk }}</td>
                                        <td>{{ $data->username }}</td>
                                     
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center">Belum ada juri.</td></tr>
                                    @endforelse
                                </tbody>
                       
                            </table>
                        </div>
                    </div>
                </div>
    </div>


@endsection
@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush