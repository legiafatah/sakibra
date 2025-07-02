@extends('juri.componen.app')
@section('content')

<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span>Penilaian Juri</span>
            </div>
            <div class="container my-3">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach($kategori as $item)
                    <div class="col">
                        <div class="card kategori-card shadow-sm bg-white rounded text-center p-3">
                            <h5 class="mb-2">Kategori Penilaian</h5>
                            <h3>{{ $item->kategori->nama }}</h3>
                            <a href="{{ route('penilaian.mulai', ['kategori' => $item->kategori->id]) }}" class="btn btn-sm btn-primary mt-2">
                                <i class="bi bi-play-circle"></i> Mulai
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>


    
@endsection
@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush