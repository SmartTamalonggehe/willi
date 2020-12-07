@php
use Illuminate\Support\Carbon;
@endphp
<table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Pengeluaran</th>
            <th>Tgl. Pengeluaran</th>
            <th>Jumlah Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengeluaran as $item)
            <tr class="clickable-row" data-id="{{ $item->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->transaksi->nm_transaksi }}</td>
                <td>{{ Carbon::parse($item->tgl_kas)->format('d-m-Y') }}</td>
                <td>@currency($item->pengeluaran)</td>
            </tr>
        @endforeach
    </tbody>
</table>




<script>
    var href;
    $(document).ready(function($) {
        $(".clickable-row").dblclick(function() {
            href = $(this).data('id');
            $('#alertPertanyaan').modal('show')
        });
    });

</script>

<script>
    $('#btnUbah').off('click').on('click', function(e) {
        e.preventDefault()
        $('#alertPertanyaan').modal('hide')
        save_method = "Ubah"
        $.ajax({
            url: "pengeluaran/" + href + "/edit",
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function() {
                // lakukan sesuatu sebelum data dikirim
                console.log(href);
            },
            success: function(data) {
                // lakukan sesuatu jika data sudah terkirim
                $('#id').val(data.id);
                $('#kt_datepicker_4_4').val(data.tgl_kas);
                $('#transaksi_id').val(data.transaksi_id).trigger('change');
                $('#rupiah1').val(data.pengeluaran);
                $('.tampilModal').modal('show')
                $('#judul').html('Silahkan Merubah Data')
                $('#tombolForm').html('Ubah Data')
            }
        });

    });
    $('#btnHapus').on('click', function() {
        $('#alertPertanyaan').modal('hide')
        var csrf_token = $('meta[name="csrf_token"]').attr('content');
        Swal.fire({
            title: 'Yakin?',
            text: "Data akan dihapus secara permanen!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: "pengeluaran/" + href,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            confirmButtonClass: 'btn btn-success',
                        })
                        loadMoreData();
                    }
                })
            }
        });
    });

</script>

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('toolsAdmin/plugins/custom/datatables/datatables.bundle.js?v=7.0.5') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('toolsAdmin/js/pages/crud/datatables/data-sources/html.js?v=7.0.5') }}"></script>
<!--end::Page Scripts-->
