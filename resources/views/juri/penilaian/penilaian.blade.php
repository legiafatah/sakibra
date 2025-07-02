
@extends('juri.componen.app')

@section('content')
<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span>Penilaian Juri</span>
            </div>
            <div class="container my-3">
                <div class="form-group">
                    <label for="pesertaSelect">Pilih Peserta:</label>
                    <select class="form-control" id="pesertaSelect">
                        <option value="">-- Pilih --</option>
                        @foreach($peserta as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary mt-3" onclick="mulaiPenilaian()">Mulai</button>
                </div>

                {{-- <div class="background-wrapper">
                <img src="/assets/img/image.png" alt="Background">
                </div> --}}

                <div id="form-penilaian" style="display: none;" class="fade-slide">
                    
                        <h5 id="nama-peserta">Nama Peserta</h5>
                        <br>
                        <h6 class="text-center font-weight-bold" style="color: black;">Kategori {{ $kategori }}</h6>
                        <h3 id="judul-detail-kategori" class="text-center font-weight-bold" style="color: black;"></h3>

                        
                        <div class="d-flex justify-content-center flex-wrap mb-4">
                            <div class="nilai-circle" onclick="beriNilai(0, this)">0</div>
                            <div class="nilai-circle" onclick="beriNilai(10, this)">10</div>
                            <div class="nilai-circle" onclick="beriNilai(15, this)">15</div>
                            <div class="nilai-circle" onclick="beriNilai(20, this)">20</div>
                        </div>

                        <div class="tombol-bawah mt-3">

                            <button class="btn btn-secondary" onclick="kembaliDetail()">Kembali</button>
                            <button class="btn btn-success" onclick="nextDetail()">Lanjut</button>
                            {{-- <button class="btn btn-info" onclick="reviewNilai()">Review</button> --}}
                            <button class="btn btn-dark" onclick="kirimNilai()">Submit</button>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<style>
        .background-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: -1;
    }

    .background-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #nama-peserta {
        font-weight: bold;
        color: black;
        text-align: left;
        margin-bottom: 10px;
    }
    .penilaian-box h4, 
    .penilaian-box h5 {
        margin: 10px 0;
    }

    .nilai-circle {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        margin: 10px;
        font-size: 22px;
        font-weight: bold;
        color: black;
        background-color: lightgray;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .nilai-circle:hover {
        transform: scale(1.1);
    }

    .nilai-circle.active {
        background-color: black;
        color: white;
    }

    .tombol-bawah {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .tombol-bawah button {
        background-color: blue !important;
        color: white !important;
        border: none;
        padding: 8px 16px;
        font-weight: bold;
        min-width: 90px;
        transition: background-color 0.2s;
    }

    /* .tombol-bawah button:hover {
        background-color: #333 !important;
    } */

    @media (max-width: 576px) {
        .nilai-circle {
            width: 60px;
            height: 60px;
            font-size: 18px;
        }

        .tombol-bawah {
            flex-direction: column;
        }

        .tombol-bawah button {
            width: 100%;
        }

        .penilaian-box {
            padding: 20px 10px;
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let detailKategori = @json($detailKategori);
        let nilaiTerkumpul = [];
        let index = 0;
        let pesertaId = null;
        let kategori = {{ $kategori_id }};
    
        window.mulaiPenilaian = function () {
            pesertaId = document.getElementById('pesertaSelect').value;
            if (!pesertaId) {
                Swal.fire('Oops!', 'Silakan pilih peserta dulu.', 'warning');
                return;
            }
    
            let selectedOption = document.getElementById('pesertaSelect').selectedOptions[0].text;
            document.getElementById('nama-peserta').innerText = selectedOption;
    
            document.querySelector('.form-group').style.display = 'none';
            document.getElementById('form-penilaian').style.display = 'block';
    
            tampilkanDetail();
        }
    
        function tampilkanDetail() {
            if (index < detailKategori.length && index >= 0) {
                let detail = detailKategori[index];
                document.getElementById('judul-detail-kategori').innerText = detail.nama;

                document.querySelectorAll('.nilai-circle').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Tampilkan kembali nilai yang sudah dipilih (jika ada)
                const existing = nilaiTerkumpul.find(n => n.detail_kategori_id === detail.id);
                if (existing) {
                    document.querySelectorAll('.nilai-circle').forEach(btn => {
                        if (parseInt(btn.innerText) === existing.nilai) {
                            btn.classList.add('active');
                        }
                    });
                }
            }
        }

        window.beriNilai = function (nilai, el) {
            document.querySelectorAll('.nilai-circle').forEach(btn => {
                btn.classList.remove('active');
            });

            el.classList.add('active');

            const currentDetail = detailKategori[index];
            const existing = nilaiTerkumpul.find(n => n.detail_kategori_id === currentDetail.id);

            if (existing) {
                existing.nilai = nilai;
            } else {
                nilaiTerkumpul.push({
                    peserta_id: pesertaId,
                    detail_kategori_id: currentDetail.id,
                    nilai: nilai
                });
            }

            // Swal.fire({
            //     position: 'top',
            //     icon: 'success',
            //     title: `✅ Nilai ${nilai} diberikan!`, // diperbaiki
            //     showConfirmButton: false,
            //     timer: 800
            // });
        }

        window.nextDetail = function () {
            const currentDetail = detailKategori[index];

            // Cek apakah nilai untuk detail saat ini sudah dipilih
            const existing = nilaiTerkumpul.find(n => n.detail_kategori_id === currentDetail.id);
            if (!existing) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Silakan berikan nilai terlebih dahulu!',
                    timer: 1000,
                    showConfirmButton: false
                });
                return;
            }

            // Kalau nilai sudah ada, baru lanjut ke next
            if (index < detailKategori.length - 1) {
                index++;
                tampilkanDetail();
            }
        }

    
        window.kembaliDetail = function () {
            if (index > 0) {
                index--;
                tampilkanDetail();
            }
        }
    
        window.reviewNilai = function () {
            let isi = nilaiTerkumpul.map(n => 
                `<li>${detailKategori.find(d => d.id === n.detail_kategori_id)?.nama || '???'}: <b>${n.nilai}</b></li>`
            ).join("");

            Swal.fire({
                title: 'Review Nilai',
                html: `<ul style="text-align: left;">${isi}</ul>`,
                icon: 'info'
            });
        }
    
        window.kirimNilai = function () {
            if (nilaiTerkumpul.length !== detailKategori.length) {
                Swal.fire('Oops!', 'Semua kategori harus dinilai dulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Yakin Submit?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('penilaian.submit') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ nilai: nilaiTerkumpul, kategori: kategori })
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Sukses!', 'Nilai berhasil disimpan!', 'success')
                        .then(() => {
                            window.location.href = "{{ route('juri_penilaian') }}";
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan.', 'error');
                        console.error(error);
                    });
                }
            });
        }
    });
</script>

    

@endsection
