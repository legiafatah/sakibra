@extends('admin.componen.app')

@section('content')



    {{-- Modal Tambah Detail Kategori --}}
    <div class="modal fade" id="modalTambahDetail" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('penilaian.detailkategori.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title">Import Detail Kategori</span>
                    </div>
                   
                    <div class="modal-body">
                        <label for="kategori_id" class="form-label">Pilih Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategori as $kategorii)
                                <option value="{{ $kategorii->id }}">{{ $kategorii->nama }}</option>
                            @endforeach
                        </select>

                        <label for="excel_file" class="form-label mt-3">Unggah File Excel (.xlsx)</label>
                        <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx" required>
                        <br>

                        <a href="{{ route('penilaian.detailkategori.template') }}" class="btn btn-sm btn-outline-secondary">📥 Unduh Template Excel</a>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Detail Kategori --}}
    <div class="modal fade" id="modalEditDetail" tabindex="-1">
        <div class="modal-dialog">
            <form id="form-edit-detail" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title">Edit Detail Kategori</span>
                    </div>
                    <div class="modal-body">
                        <label for="edit_kategori_id" class="form-label">Pilih Kategori</label>
                        <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            @foreach ($kategori as $kategorii)
                                <option value="{{ $kategorii->id }}">{{ $kategorii->nama }}</option>
                            @endforeach
                        </select>

                        <label for="edit_nama_detail" class="form-label mt-3">Nama Detail Kategori</label>
                        <input type="text" name="nama" id="edit_nama_detail" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus Detail per Kategori -->
    <div class="modal fade" id="modalHapusKategori" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('detail.kategori.hapusPerKategori') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title">Hapus Semua Detail pada Kategori</span>
                    </div>
                    <div class="modal-body">
                        <label for="kategori_id_hapus">Pilih Kategori</label>
                        <select name="kategori_id" id="kategori_id_hapus" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-danger"><small>Semua detail kategori di kategori ini akan dihapus permanen.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





       {{-- TABEL DETAIL KATEGORI --}}
       <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Detail Kategori Penilaian</span>
                    <div>
                    <a href="{{ route('admin.penilaian') }}" class="btn btn-warning btn-sm">Kategori Penilaian</a>
                    <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalTambahDetail">+ Tambah Detail </button>
                    </div>
                </div>
                
                <div class="table-responsive mb-4 mt-4">
                    <div>   
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusKategori">
                                        🗑️ Hapus Detail Kategori
                    </button>
                    </div>
                    <table id="alter_pagination2" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Detail</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailKategori as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->nama }}</td>
                                <td>{{ $detail->kategori->nama }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success btn-edit-detail"
                                        data-id="{{ $detail->id }}"
                                        data-nama="{{ $detail->nama }}"
                                        data-kategori="{{ $detail->kategori_id }}">
                                        ✏️
                                    </button>
                                    <form id="form-hapus-{{ $detail->id }}" action="{{ route('detail.kategori.destroy', $detail->id) }}" method="POST" style="display:inline;">
                                     
                                    @csrf
                                    @method('DELETE')
                                  

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($detailKategori->isEmpty())
                                <tr><td colspan="3" class="text-center">Belum ada detail kategori</td></tr>
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

    

    // document.addEventListener('DOMContentLoaded', function () {
    //     // Uppercase
    //     document.querySelectorAll('.uppercase').forEach(input => {
    //         input.addEventListener('input', function () {
    //             this.value = this.value.toUpperCase();
    //         });
    //     });

    //     // Tooltip (Bootstrap 5)
    //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    //     tooltipTriggerList.map(function (tooltipTriggerEl) {
    //         return new bootstrap.Tooltip(tooltipTriggerEl);
    //     });

    //     // SweetAlert session
    //     @if(session('success'))
    //         Swal.fire({
    //             icon: 'success',
    //             title: 'Berhasil!',
    //             text: @json(session('success'))
    //         });
    //     @endif

    //     @if(session('error'))
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Gagal!',
    //             text: @json(session('error'))
    //         });
    //     @endif

    //     // Modal Edit Detail
    //     document.querySelectorAll('.btn-edit-detail').forEach(function (btn) {
    //         btn.addEventListener('click', function () {
    //             const id = this.dataset.id;
    //             const nama = this.dataset.nama;
    //             const kategoriId = this.dataset.kategori;

    //             document.getElementById('edit_nama_detail').value = nama;
    //             document.getElementById('edit_kategori_id').value = kategoriId;
    //             document.getElementById('form-edit-detail').action = '/admin/detail-kategori/update/' + id;

    //             const modal = new bootstrap.Modal(document.getElementById('modalEditDetail'));
    //             modal.show();
    //         });
    //     });
    // });


    // function konfirmasiHapus(id) {
    //     Swal.fire({
    //         title: 'Yakin ingin menghapus?',
    //         text: "Data tidak bisa dikembalikan!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#3085d6',
    //         confirmButtonText: 'Ya, hapus!',
    //         cancelButtonText: 'Batal'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             document.getElementById('form-hapus-' + id).submit();
    //         }
    //     });
    // }
    
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
    
        document.querySelectorAll('.btn-edit-detail').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const kategoriId = this.dataset.kategori;

                document.getElementById('edit_nama_detail').value = nama;
                document.getElementById('edit_kategori_id').value = kategoriId;
                document.getElementById('form-edit-detail').action = '/admin/detail-kategori/update/' + id; // ganti sesuai route kamu kalau beda

                // Tampilkan modal
                // const modal = new bootstrap.Modal(document.getElementById('modalEditKategori'));
                // modal.show();
                $('#modalEditDetail').modal('show');
            });
        });
    });




</script>
@endpush