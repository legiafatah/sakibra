@extends('superadmin.componen.app')

@section('content')

    {{--Modal admin--}}
    <div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin_store') }}" method="POST" class="modal-content">
                
                @csrf
                <div class="modal-header bg-info text-white">
                    <span class="modal-title">Tambah Peserta</span>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jk" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>No. WA</label>
                        <input type="text" name="no_wa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline" type="button" id="togglePassword">
                                        <i data-feather="eye" id="iconPassword"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>


                    <div class="widget-content widget-content-area br-6">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span>Manajemen Admin</span>
                            <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#modalTambahAdmin">+ Tambah Admin</button>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="alter_pagination" class="table table-hover" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>No WA</th>
                                        <th>Username</th>
                                        
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adminList as $index => $admin)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $admin->nama }}</td>
                                        <td>{{ $admin->jk }}</td>
                                        <td>{{ $admin->no_wa }}</td>
                                        <td>{{ $admin->username }}</td>
                                     
                                        <td class="text-center">
                                                <form id="form-hapus-{{ $admin->id }}" action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                                   
                                                    {{-- <button type="button"
                                                    class="btn btn-sm btn-success btn-edit-peserta"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama }}"
                                                    data-kategori="{{ $item->kategori }}"
                                                    data-no_peserta="{{ $item->no_peserta }}">
                                                    ✏️
                                                    </button> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $admin->id }})">🗑️</button>
                                             
                                                </form>
                                            </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

   

    
       
             
 


@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace(); // Penting untuk render ikon

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('iconPassword');

            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Ganti ikon feather
            icon.setAttribute('data-feather', isPassword ? 'eye-off' : 'eye');
            feather.replace(); // render ulang icon feather
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


    $(document).ready(function() {
        $('.toggle-status-btn').click(function() {
            var button = $(this);
            var adminId = button.data('id');
            var currentStatus = button.data('status');
            var newStatus = currentStatus ? 0 : 1;

            $.ajax({
                url: '/superadmin/admin/' + adminId + '/toggle-status',
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function(response) {
                    // Update tampilan tombol
                    button.data('status', newStatus);
                    if (newStatus === 1) {
                        button.removeClass('btn-secondary').addClass('btn-success').text('Aktif');
                    } else {
                        button.removeClass('btn-success').addClass('btn-secondary').text('Nonaktif');
                    }
                },
                error: function(xhr) {
                    console.log('Gagal memperbarui status');
                }
            });
        });
    });


</script>
@endpush