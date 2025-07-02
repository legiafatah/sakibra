@extends('admin.componen.app')
@section('content')

    <!-- Modal Tambah Juri -->
    <div class="modal fade" id="modalTambahJuri" tabindex="-1" aria-labelledby="modalTambahJuriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('juri_store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title" >Tambah Juri</span>
                    </div>

                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select name="jk" class="form-control" id="jk" required>
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                       <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
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

    <!-- Modal Edit Juri -->
    <div class="modal fade" id="modalEditJuri" tabindex="-1" aria-labelledby="modalEditJuriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="form-edit-juri">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <span class="modal-title">Edit Data Juri</span>
            
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="edit-nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-jk" class="form-label">Jenis Kelamin</label>
                            <select name="jk" id="edit-jk" class="form-control">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="edit-username" class="form-label">Username</label>
                            <input type="text" name="username" id="edit-username" class="form-control" required>
                        </div> --}}
                          <div class="mb-3">
                            <label for="edit-username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="edit-username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit-password" class="form-label">Password (isi jika ingin mengganti)</label>
                            <input type="password" name="password" id="edit-password" class="form-control">
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


        

    {{--Tabel Juri--}}
    <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span>Manajemen Juri</span>
                            <div>
                                <a href="{{ route('akses-juri.index') }}" class="btn btn-warning btn-sm">Akses Juri</a>
                                <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalTambahJuri">+ Tambah Juri</button>
                            </div>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="alter_pagination" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>Username</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($juri as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->jk }}</td>
                                        <td>{{ $data->username }}</td>
                                        <td class="text-center">
                                            <form id="form-hapus-{{ $data->id }}" action="{{ route('juri.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                <button type="button"
                                                class="btn btn-sm btn-success btn-edit-juri"
                                                data-id="{{ $data->id }}"
                                                data-nama="{{ $data->nama }}"
                                                data-jk="{{ $data->jk }}"
                                                data-username="{{ $data->username }}">
                                                ✏️
                                                </button>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $data->id }})">🗑️</button>
                                            </form>
                                        </td>
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
            $('#modalEditJuri').modal('show');
        });
    });
});



      


</script>
@if(session('edit_modal_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const id = @json(session('edit_modal_id'));
            const row = document.querySelector(`button[data-id='${id}']`);
            if (row) {
                const nama = row.getAttribute('data-nama');
                const jk = row.getAttribute('data-jk');
                const username = row.getAttribute('data-username');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nama').value = nama;
                document.getElementById('edit-jk').value = jk;
                document.getElementById('edit-username').value = username;
                document.getElementById('edit-password').value = '';

                document.getElementById('form-edit-juri').action = '/admin/juri/edit/' + id;

                $('#modalEditJuri').modal('show');
            }
        });
    </script>
@endif

@endpush
