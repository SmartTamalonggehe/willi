@php
use Carbon\Carbon;
@endphp

@extends('admin.layouts.default')

@section('judul', 'Laporan Pemasukan')

@section('LapPemasukan', 'menu-item-active')

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
                    <div class="card-title">
                        <h3 class="card-label">Silahkan Pilih Item, Bulan dan Tahun
                    </div>
                </div>
                <div class="row ml-3">
                    <div class="col-12 col-md-2">
                        <select name="pemasukan" id="pemasukan" class="select2" style="width: 100%">
                            <option value="">Pilih Item</option>
                            @foreach ($pemasukan as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nm_transaksi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <select name="bulan" id="bulan" class="select2" style="width: 100%">
                            <option value="" selected>Pilih Bulan Awal</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <select name="bulan_akhir" id="bulan_akhir" class="select2" style="width: 100%">
                            <option value="" selected>Pilih Bulan Akhir</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <select name="tahun" id="tahun" class="select2" style="width: 100%">
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $item)
                                <option value="{{ Carbon::parse($item->tgl_kas)->format('Y') }}">
                                    {{ Carbon::parse($item->tgl_kas)->format('Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Tombol Export --}}
                    {{-- <div class="card-toolbar mr-2">
                        <!--begin::Button-->
                        <a href="#" id="exportExcel" class="btn btn-primary font-weight-bolder">
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
                            </span>Print Excel</a>
                        <!--end::Button-->
                    </div> --}}

                    {{-- <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="#" id="exportPDF" class="btn btn-primary font-weight-bolder">
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
                            </span>Print PDF</a>
                        <!--end::Button-->
                    </div> --}}
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

@endsection

@section('js')

    <script src="{{ asset('toolsAdmin/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.5') }}"></script>

    <script>
        $('.select2').select2();

    </script>


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

    {{-- Filter Bulan dan Tahun --}}
    <script>
        $(document).ready(function() {
            $('#bulan').on('change', function() {
                let pemasukan = $('#pemasukan').val();
                // jika pemasukan Kosong
                if (!pemasukan) {
                    alert('Silahkan Pilih Item')
                    return 0
                }

                let value = $(this).val();
                let tahun = $('#tahun').val();
                let bulan_akhir = $('#bulan_akhir').val();
                $.ajax({
                    type: 'get',
                    url: '',
                    data: {
                        'filter[transaksi.nm_transaksi]': 'derma,syukur',
                        'bulan': value,
                        'tahun': tahun,
                        'bulan_akhir': bulan_akhir,
                        'pemasukan': pemasukan,
                    },
                    success: function(data) {
                        $('#tampil').html(data);
                    }
                });
            })
            $('#tahun').on('change', function() {
                let pemasukan = $('#pemasukan').val();
                // jika pemasukan Kosong
                if (!pemasukan) {
                    alert('Silahkan Pilih Item')
                    return 0
                }
                let value = $(this).val();
                let bulan = $('#bulan').val()
                let bulan_akhir = $('#bulan_akhir').val()
                $.ajax({
                    type: 'get',
                    url: '',
                    data: {
                        'filter[transaksi.nm_transaksi]': 'derma,syukur',
                        'tahun': value,
                        'bulan': bulan,
                        'bulan_akhir': bulan_akhir,
                        'pemasukan': pemasukan,
                    },
                    success: function(data) {
                        $('#tampil').html(data);
                    }
                });
            })
            $('#bulan_akhir').on('change', function() {
                let pemasukan = $('#pemasukan').val();
                // jika pemasukan Kosong
                if (!pemasukan) {
                    alert('Silahkan Pilih Item')
                    return 0
                }
                let value = $(this).val();
                let bulan = $('#bulan').val()
                let tahun = $('#tahun').val();
                $.ajax({
                    type: 'get',
                    url: '',
                    data: {
                        'filter[transaksi.nm_transaksi]': 'derma,syukur',
                        'bulan_akhir': value,
                        'bulan': bulan,
                        'tahun': tahun,
                        'pemasukan': pemasukan,
                    },
                    success: function(data) {
                        $('#tampil').html(data);
                    }
                });
            })

            // Tombol Export Excel
            $('#exportExcel').on('click', function() {
                let tahun = $('#tahun').val();
                let bulan = $('#bulan').val();
                let bulan_akhir = $('#bulan_akhir').val();

                if (!tahun || !bulan || !bulan_akhir) {
                    alert("Silahkan Pilih Bulan dan Tahun")
                    return 0;
                }
                window.location.href = 'kasExportExcel?filter[transaksi.nm_transaksi]=derma,syukur&bulan=' +
                    bulan + '&bulan_akhir=' + bulan_akhir + '&tahun=' + tahun
            })

            // Tombol Export Excel
            //   $('#exportPDF').on('click',function(){
            //     let tahun=$('#tahun').val();
            //     let bulan=$('#bulan').val();
            //     let bulan_akhir=$('#bulan_akhir').val();

            //     if (!tahun || !bulan || !bulan_akhir) {
            //         alert("Silahkan Pilih Bulan dan Tahun")
            //         return 0;
            //     }
            //     window.location.href='kasExportPdf?filter[transaksi.nm_transaksi]=derma,syukur&bulan='+ bulan +'&bulan_akhir='+ bulan_akhir +'&tahun='+ tahun
            //   })
        });

    </script>

@endsection
