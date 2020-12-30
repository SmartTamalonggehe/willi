@extends('admin.layouts.default')

@section('judul', 'Perpuluhan')

@section('perpuluhan', 'menu-item-active')

@section('css')
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('toolsAdmin/plugins/custom/datatables/datatables.bundle.css?v=7.0.5') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

@section('content')

    <!--begin::Row-->
    <div class="row">
        <div class="col-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title" perpuluhan">@yield('judul')
                        <span class="d-block text-muted pt-2 font-size-sm">Klik 2x untuk mengubah atau menghapus
                            data.</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="#" id="tambah" class="btn btn-primary font-weight-bolder">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Tambah Data</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div id="tampil"></div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Row-->


    @include('admin.perpuluhan.form')

    <div class="modal fade text-left" id="alertPertanyaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Pilih Tindakan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Silahkan Pilih tindakan selanjutnya.</p>

                </div>
                <div class="text-center mb-2">
                    <button type="button" class="btn btn-warning" id="btnUbah"><i class="feather icon-edit"></i>
                        Ubah</button>
                    <button type="button" class="btn btn-danger" id="btnHapus"><i class="feather icon-trash-2"></i>
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script>
        // Load Data
        function loadMoreData() {
            $.ajax({
                    url: '',
                    type: "get",
                    datatype: "html",
                    success: function(data) {
                        $('#tampil').html(data);
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Server tidak merespon...');
                });
        }
        loadMoreData();

    </script>

    {{-- Tambah dan Ubah Data --}}
    <script>
        $('#tambah').click(function() {
            save_method = "add"
            $('#judul').html('From Tambah Data')
            $('#tombolForm').html('Simpan Data')
            $('#formKu').trigger("reset");
            $('.tampilModal').modal('show')
        });

        $(document).ready(function() {
            $("#formKu").on('submit', function(e) {
                console.log('test');
                e.preventDefault();
                let id = $('#id').val();
                let dataKu = $('#formKu').serialize();
                if (save_method == "add") {
                    url = "{{ route('perpuluhan.store') }}"
                    method = "POST"
                } else {
                    url = "perpuluhan/" + id
                    method = "PUT"
                }
                $.ajax({
                        url: url,
                        type: method,
                        data: dataKu,
                        success: function(response) {
                            if (save_method == "add") {
                                toastr.info('Data Disimpan ', 'Berhasil', {
                                    "progressBar": true
                                });
                            } else {
                                toastr.info('Data Diubah ', 'Berhasil', {
                                    "progressBar": true
                                });
                                aksi = $('.tampilModal').modal('hide')
                            }

                            $('#nm_transaksi').val('');
                            loadMoreData();
                            //   pesan
                        }
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('Error. Kemungkinan Kode Sudah Ada.');
                    });
                console.log(save_method)
            });
        });

    </script>

@endsection
