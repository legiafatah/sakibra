@extends('user.componen.app')
@section('content')
<div class="container my-4">

{{-- <a href="{{ route('rekap.peserta') }}" class="btn btn-success">Download Rekapitulasi</a> --}}

      
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>Bukti Hukuman Peserta</span>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="alter_pagination" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peserta</th>
                                <th>Nama Hukuman</th>
                                <th>Total Nilai</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hukuman as $index => $h)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $h['peserta_nama'] }}</td>
                                <td>{{ $h['nama'] }}</td>
                                <td>{{ $h['total_nilai'] }}</td>
                                <td>
                                    @if(count($h['bukti_list']) > 0)
                                        <button 
                                            class="btn btn-sm btn-primary review-btn"
                                            data-bukti='@json($h['bukti_list'])'
                                            data-title="Bukti untuk: {{ $h['nama'] }}"
                                        >
                                            Review
                                        </button>
                                    @else
                                        <span class="text-muted">Tidak ada bukti</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">Belum ada hukuman yang ditambahkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Tunggal -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body d-flex flex-wrap gap-3 justify-content-start" id="buktiModalBody">
                    <!-- Bukti gambar akan dimasukkan lewat JS -->
                </div>
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

