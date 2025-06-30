@extends('superadmin.componen.app')

@section('content')
{{-- <div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Data Admin</span>
        <a href="{{ route('admin_create') }}" class="btn btn-primary">+ Tambah Admin</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin as $admin)
                    <tr>
                        <td>{{ $admin->username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Admin</h5>
        <a href="{{ route('admin_create') }}" class="btn btn-primary">+ Tambah Admin</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>No WA</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin as $index => $admin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->jk }}</td>
                    <td>{{ $admin->no_wa }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>
                    <button class="btn btn-sm toggle-status-btn {{ $admin->status ? 'btn-success' : 'btn-secondary' }}" 
                            data-id="{{ $admin->id }}" 
                            data-status="{{ $admin->status }}">
                        {{ $admin->status ? 'Aktif' : 'Nonaktif' }}
                    </button>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">
                            ✏️
                        </a>
                        <form id="form-hapus-{{ $admin->id }}" action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
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
