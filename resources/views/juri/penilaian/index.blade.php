@extends('juri.componen.app')
@section('content')


<div class="container my-3">
    <h1>Penilaian</h1>

    <div class="row">
        @foreach($kategori as $item)
        <div class="col-md-4">
            <div class="card shadow p-3 mb-4 bg-white rounded">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Kategori Penilaian</h5>
                    <h1>{{ $item->kategori->nama }}</h1>
                    <a href="{{ route('penilaian.mulai', ['kategori' => $item->kategori->id]) }}" class="btn btn-primary">
                        <i class="bi bi-play-circle"></i> Mulai Penilaian
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


    </div>
@endsection
@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush