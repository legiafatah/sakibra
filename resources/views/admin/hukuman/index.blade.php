@extends('admin.componen.app')
@section('content')

<div class="container mt-4">
    

    {{-- Modal Hukuman--}}
    <div class="modal fade" id="addHukumanModal" tabindex="-1" aria-labelledby="addHukumanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('hukuman_store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="modal-content">
                    <!-- Header hijau dan putih seperti contoh -->
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title" >Tambah Hukuman</span>
                        {{-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button> --}}
                    </div>

                    <!-- Body putih bersih -->
                   <div class="modal-body">
                        {{-- Pilih Peserta --}}
                        <div class="mb-3">
                            <label>Peserta</label>
                            <select name="peserta_id" class="form-control" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($peserta as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        {{-- Nama Hukuman --}}
                        <div class="mb-3">
                            <label>Nama Hukuman</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
    
                        {{-- Nilai --}}
                        <div class="mb-3">
                            <label>Nilai</label>
                            <input type="number" name="nilai" class="form-control">
                        </div>
    
                        {{-- Pilih Salah Satu: Upload Manual atau Otomatis dari Bukti --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Bukti (upload manual)</label>
                                    <input type="file" name="bukti" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Atau ambil dari waktu pelanggaran</label>
                                <div class="mb-2">
                                    <input type="datetime-local" name="waktu_awal" class="form-control" placeholder="Waktu awal">
                                </div>
                                <div>
                                    <input type="datetime-local" name="waktu_akhir" class="form-control" placeholder="Waktu akhir">
                                </div>
                            </div>
                        </div>
    
                        <small class="text-muted">
                            * Kamu bisa isi salah satu: unggah bukti manual <strong>atau</strong> ambil dari waktu pelanggaran.
                        </small>
                    </div>

                    <!-- Footer dengan tombol hijau -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editHukumanModal" tabindex="-1" aria-labelledby="editHukumanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-edit-hukuman" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title" >Edit Hukuman</span>
            
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Peserta</label>
                            <input type="text" id="edit-peserta" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Nama Hukuman</label>
                            <input type="text" name="nama" id="edit-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nilai</label>
                            <input type="number" name="nilai" id="edit-nilai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Upload Bukti Baru (opsional)</label>
                            <input type="file" name="bukti" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Bukti Sebelumnya:</label><br>
                            <img id="preview-bukti" src="" width="100" alt="Tidak ada bukti">
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



    <!-- Modal Edit Hukuman -->
    {{-- <div class="modal fade" id="editHukumanModal" tabindex="-1" aria-labelledby="editHukumanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-edit-hukuman" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Edit Hukuman</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Peserta</label>
                            <input type="text" id="edit-peserta" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Nama Hukuman</label>
                            <input type="text" name="nama" id="edit-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nilai</label>
                            <input type="number" name="nilai" id="edit-nilai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Upload Bukti Baru (opsional)</label>
                            <input type="file" name="bukti" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Bukti Sebelumnya:</label><br>
                            <img id="preview-bukti" src="" width="100" alt="Tidak ada bukti">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}



    {{--Tabel Hukuman--}}
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Manajemen Hukuman</span>
                    <div>
                    <a href="{{ route('bukti.index') }}" class="btn btn-warning btn-sm">Bukti</a>
                    <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#addHukumanModal">+ Tambah Hukuman</button>
                    </div>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="alter_pagination" class="table table-hover" style="width:100%">
                        <thead >
                            <tr>
                                <th  data-orderable="false">No</th>
                                <th>Peserta</th>
                                <th>Nama Hukuman</th>
                                <th>Nilai</th>
                                <th>Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hukuman as $h)
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $h->peserta->nama ?? '-' }}</td>
                                <td>{{ $h->nama }}</td>
                                <td>{{ $h->nilai }}</td>
                                <td>
                                    @if($h->bukti)
                                        {{-- <img src="{{ asset('public/' . $h->bukti) }}" width="80"> --}}
                                        <img src="{{ asset($h->bukti) }}" width="80">
                                    @else
                                        Tidak ada bukti
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form id="form-hapus-{{ $h->id }}" action="{{ route('hukuman.destroy', $h->id) }}" method="POST" style="display:inline;">
                                        <button type="button"
                                        class="btn btn-sm btn-success btn-edit-hukuman"
                                        data-id="{{ $h->id }}"
                                        data-nama="{{ $h->nama }}"
                                        data-nilai="{{ $h->nilai }}"
                                        data-bukti="{{ asset($h->bukti) }}"
                                        data-peserta="{{ $h->peserta->nama ?? '-' }}">
                                        ✏️
                                        </button>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $h->id }})">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">Belum ada hukuman yang ditambahkan.</td></tr>
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
    
            // Trigger tombol edit
        
            document.querySelectorAll('.btn-edit-hukuman').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const nilai = this.dataset.nilai;
                const bukti = this.dataset.bukti;
                const peserta = this.dataset.peserta;

                document.getElementById('edit-nama').value = nama;
                document.getElementById('edit-nilai').value = nilai;
                document.getElementById('preview-bukti').src = bukti;
                document.getElementById('edit-peserta').value = peserta;

                // Set form action
                const form = document.getElementById('form-edit-hukuman');
                form.action = '/admin/hukuman/edit/' + id; // ganti sesuai route kamu kalau beda

                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('editHukumanModal'));
                modal.show();
            });
    });
    });
        

   </script>

@endpush