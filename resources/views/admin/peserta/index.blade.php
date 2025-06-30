@extends('admin.componen.app')
@section('content')

    {{--Modal peserta--}}
    <div class="modal fade" id="modalTambahPeserta" tabindex="-1" aria-labelledby="modalTambahPesertaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('peserta.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-info text-white">
                    <span class="modal-title">Tambah Peserta</span>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="sd">SD</option>
                            <option value="smp">SMP</option>
                            <option value="smk">SMK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="no_peserta" class="form-label">No Peserta</label>
                        <input type="number" name="no_peserta" id="no_peserta" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>


    {{-- Modal Edit Peserta --}}
    <div class="modal fade" id="modalEditPeserta" tabindex="-1" aria-labelledby="modalEditPesertaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-edit-peserta" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info text-white">
                    <span class="modal-title">Edit Peserta</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="edit-kategori" class="form-control" required>
                            <option value="sd">SD</option>
                            <option value="smp">SMP</option>
                            <option value="smk">SMK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-no_peserta" class="form-label">No Peserta</label>
                        <input type="number" name="no_peserta" id="edit-no_peserta" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

                </div>
            </form>
        </div>
    </div>


    {{-- tabel --}}
    <div class="row layout-top-spacing" id="cancel-row">
       
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span>Manajemen Peserta</span>
                            <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalTambahPeserta">+ Tambah Peserta</button>
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
                                        <th class="text-center">Aksi</th>
                     
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
                                            <td class="text-center">
                                                <form id="form-hapus-{{ $item->id }}" action="{{ route('admin.peserta.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                   
                                                    <button type="button"
                                                    class="btn btn-sm btn-success btn-edit-peserta"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama }}"
                                                    data-kategori="{{ $item->kategori }}"
                                                    data-no_peserta="{{ $item->no_peserta }}">
                                                    ✏️
                                                    </button>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $item->id }})">🗑️</button>
                                             
                                                </form>
                                            </td>
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

   



@endsection
@push('scripts')
<script>

function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-hapus-' + id).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Konversi input ke huruf kapital (uppercase)
    const inputs = document.querySelectorAll('.uppercase');
    inputs.forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    });

    // Tampilkan notifikasi jika ada session sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')), // otomatis escape karakter
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif

    // Buka modal edit peserta saat tombol diklik
    document.querySelectorAll('.btn-edit-peserta').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const kategori = this.dataset.kategori;
            const no_peserta = this.dataset.no_peserta;

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-kategori').value = kategori;
            document.getElementById('edit-no_peserta').value = no_peserta;

            // Set action form dan tampilkan modal
            const form = document.getElementById('form-edit-peserta');
            form.action = `/admin/peserta/update/${id}`;

            // Bootstrap 4 style untuk show modal
            $('#modalEditPeserta').modal('show');
        });
    });
});



  
    


</script>
@endpush