<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAKIBRA</title>

    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('demo5/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo5/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- <link href="{{ asset('demo5/assets/css/custom.css') }}" rel="stylesheet" type="text/css" /> --}}
    @stack('css')

    <style>
        .navbar .navbar-item.navbar-dropdown {
            margin-left: auto;
        }

        .layout-px-spacing {
            min-height: calc(100vh - 96px) !important;
        }
    </style>
</head>

<body class="sidebar-noneoverflow">
    <div class="modal fade" id="modalEditPassword" tabindex="-1" aria-labelledby="editPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditPassword" action="{{ route('superadmin.update_password') }}" method="POST">
                @csrf
                <div class="modal-content">
                <div class="modal-header bg-info text-white">
                                <span class="modal-title">Ubah Password</span>
                    
                            </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Password Lama</label>
                            <input type="password" name="old_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('superadmin.componen.navbar')

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        @include('superadmin.componen.sidebar')

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @yield('content')
            </div>
              <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2025 SAKIBRA</a>, Selangkah Lebih Maju dalam Penilaian Paskibra.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">MasL_29<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg></p>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

     <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    {{-- <script src="{{ asset('demo5/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('demo5/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('demo5/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('demo5/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    {{-- <script src="{{ asset('demo5/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('demo5/assets/js/dashboard/dash_1.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('demo5/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    {{-- <script src="{{ asset('demo5/assets/js/libs/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('demo5/assets/js/libs/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('demo5/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('demo5/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('demo5/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- <script src="{{ asset('demo5/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}



    <script>
        $(document).ready(function () {
            App.init();
        });
    </script>
    <script src="{{ asset('demo5/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script>
        $(document).ready(function() {
            var table = $('#alter_pagination').DataTable({
                "pagingType": "full_numbers",
                "oLanguage": {
                    "oPaginate": { 
                        "sFirst": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>',
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                        "sLast": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [3, 5, 10, 20],
                "pageLength": 3,
                "columnDefs": [{
                    "targets": 0, 
                    "orderable": false
                }],
                "order": [] 
            });
    
            // Update nomor urut setiap kali tabel di-draw ulang
            table.on('order.dt search.dt draw.dt', function () {
                let i = 1;
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, index) {
                    cell.innerHTML = i++;
                });
            }).draw();
        });
        </script>
        <script>
          $(document).ready(function() {
            var table = $('#alter_pagination2').DataTable({
                "pagingType": "full_numbers",
                "oLanguage": {
                    "oPaginate": { 
                        "sFirst": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>',
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                        "sLast": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [3, 5, 10, 20],
                "pageLength": 3,
                "columnDefs": [{
                    "targets": 0, 
                    "orderable": false
                }],
                "order": [] 
            });
    
            // Update nomor urut setiap kali tabel di-draw ulang
            table.on('order.dt search.dt draw.dt', function () {
                let i = 1;
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, index) {
                    cell.innerHTML = i++;
                });
            }).draw();
        });
        </script>
         @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session("error") }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
</body>

</html>
