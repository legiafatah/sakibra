@extends('admin.componen.app')

@section('content')



    {{-- Modal Tambah Kategori --}}
    <div class="modal fade" id="modalTambahKategori" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('penilaian.kategori.simpan') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title">Tambah Kategori</span>
                    
                    </div>
                    {{-- <div class="modal-body">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama" id="nama_kategori" class="form-control uppercase" required>
                    </div> --}}
                                           <div class="modal-body">
                                                <label for="nama" class="form-label">Nama Kategori</label>
                                                <input type="text" name="nama" class="form-control uppercase" id="nama" value="{{ old('nama') }}" required>
                                                @error('nama')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Kategori</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form id="form-edit-kategori" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <span class="modal-title">Edit Kategori</span>

            </div>
            <div class="modal-body">
                <div class="mb-3">
                <label for="edit-nama-kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control uppercase" id="edit-nama-kategori" name="nama" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </form>
        </div>
    </div>
  

    {{-- TABEL KATEGORI --}}
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Manajemen Kategori Penilaian</span>
                    <div>
                    <a href="{{ route('detail-kategori.index') }}" class="btn btn-warning btn-sm">Detail Kategori</a>
                    <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalTambahKategori">+ Tambah Kategori</button>
                    </div>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="alter_pagination" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th> {{-- Tambahkan kolom aksi --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <form id="form-hapus-{{ $item->id }}" action="{{ route('kategori.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        <button type="button"
                                            class="btn btn-sm btn-success btn-edit-kategori"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}">
                                            ✏️
                                        </button>
                                       
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $item->id }})">🗑️</button>
                                    </form>
                                </td>
                                
                            </tr>
                            @endforeach

                            @if($kategori->isEmpty())
                                <tr><td colspan="2" class="text-center">Belum ada kategori</td></tr>
                            @endif
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
        const inputs = document.querySelectorAll('.uppercase');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.toUpperCase();
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}'
        });
        @endif
 
        // Trigger tombol edit
    
        document.querySelectorAll('.btn-edit-kategori').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                document.getElementById('edit-nama-kategori').value = nama;

                // Set form action
                const form = document.getElementById('form-edit-kategori');
                form.action = '/admin/kategori/edit/' + id; // ganti sesuai route kamu kalau beda

                // Tampilkan modal
                // const modal = new bootstrap.Modal(document.getElementById('modalEditKategori'));
                // modal.show();
                $('#modalEditKategori').modal('show');
            });
        });
    });




</script>
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahKategori'));
            myModal.show();
        });
    </script>
@endif
@endpush
