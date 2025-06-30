@extends('user.componen.app')
@section('content')
<div class="container my-4">

    

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Rekap Nilai </span>
                    <a href="{{ route('rekap.peserta') }}" class="btn btn-success">Download Rekapitulasi</a>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('buktiModal'));
        const modalTitle = document.getElementById('buktiModalLabel');
        const modalBody = document.getElementById('buktiModalBody');

        document.querySelectorAll('.review-btn').forEach(button => {
            button.addEventListener('click', function () {
                const buktiList = JSON.parse(this.dataset.bukti);
                const title = this.dataset.title;

                // Kosongkan isi modal
                modalTitle.textContent = title;
                modalBody.innerHTML = '';

                // Tambahkan gambar
                buktiList.forEach(bukti => {
                    const img = document.createElement('img');
                    img.src = `/${bukti}`;
                    img.className = 'img-fluid border rounded';
                    img.style.maxHeight = '300px';
                    img.style.marginRight = '10px';
                    img.style.marginBottom = '10px';
                    modalBody.appendChild(img);
                });

                modal.show();
            });
        });
    });

 



</script>
@endpush

