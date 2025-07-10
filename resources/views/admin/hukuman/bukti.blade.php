@extends('admin.componen.app')
@section('content')

<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span>Bukti Pelanggaran Garis</span>
                <div>
                    <a href="http://localhost:5000/" class="btn btn-sm btn-danger">
                        <i class="bi bi-camera"></i> Kamera
                    </a>
                    @if(count($pelanggaran) > 0)
                    <form id="form-hapus-semua" action="{{ route('bukti.destroy.all') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-dark" onclick="hapusSemuaBukti()">🗑️ Hapus Semua</button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="table-responsive mb-4 mt-4">
                <table id="alter_pagination" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggaran as $bukti)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($bukti->image)
                                    <img src="{{ asset('bukti/' . $bukti->image) }}"
                                         width="80"
                                         style="cursor:pointer"
                                         onclick="showImagePreview('{{ asset('bukti/' . $bukti->image) }}')">
                                @else
                                    Tidak ada pelanggaran
                                @endif
                            </td>
                            <td>
                                <form id="form-hapus-{{ $bukti->id }}" action="{{ route('bukti.destroy', $bukti->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus({{ $bukti->id }})">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada bukti pelanggaran garis.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Gambar Pelanggaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="previewImage" src="" class="img-fluid rounded" alt="Gambar Pelanggaran">
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

    function hapusSemuaBukti() {
        Swal.fire({
            title: 'Hapus semua bukti?',
            text: "Tindakan ini akan menghapus seluruh data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-semua').submit();
            }
        });
    }

    function showImagePreview(imageUrl) {
        $('#previewImage').attr('src', imageUrl);
        $('#previewModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success'))
            });
        @endif
    });
</script>
@endpush
