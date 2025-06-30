@extends('admin.componen.app')

@section('content')

    <!-- Modal Tambah Penilaian -->
    <div class="modal fade" id="modalAksesPenilaian" tabindex="-1" aria-labelledby="modalAksesPenilaianLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('akses_juri.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title" >Tambah Penilaian Kategori Juri</span>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button> --}}
                    </div>
                    <div class="modal-body">
                        
                        <div class="mb-3">
                            <label for="juri_id" class="form-label">Pilih Juri</label>
                            <select name="juri_id" id="juri_id" class="form-control" required>
                                <option value="">-- Pilih Juri --</option>
                                @foreach ($juri as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Pilih Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


        {{--Tabel Akses Juri--}}
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <span>Data Akses Juri</span>
                        <div>
                        <a href="{{ route('juri.index') }}" class="btn btn-warning btn-sm">Data Juri</a>
                        <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalAksesPenilaian">+ Tambah Akses Juri</button>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="alter_pagination2" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Juri</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aksesJuri as $index => $akses)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $akses->juri->nama }}</td>
                                    <td>{{ $akses->kategori->nama }}</td>
                                    <td class="text-center">
                                        <form id="form-hapus-{{ $akses->id }}" action="{{ route('akses.juri.destroy', $akses->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $akses->id }})">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">Belum ada akses juri yang ditambahkan.</td></tr>
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

                @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
                @endif
 
                // Trigger tombol edit
            
                document.querySelectorAll('.btn-edit-juri').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const nama = this.dataset.nama;
                        const jk = this.dataset.jk;
                        const username = this.dataset.username;

                        // Isi field di modal
                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-jk').value = jk;
                        document.getElementById('edit-username').value = username;

                        // Kosongkan password (tidak ditampilkan)
                        document.getElementById('edit-password').value = '';

                        // Set form action
                        const form = document.getElementById('form-edit-juri');
                        form.action = '/admin/juri/edit/' + id; // ganti route sesuai kebutuhanmu

                        // Tampilkan modal
                        // const modal = new bootstrap.Modal(document.getElementById('modalEditJuri'));
                        // modal.show();
                        $('#modalAksesPenilaian').modal('show');
                    });
                });
            });
        
        </script>
@endpush