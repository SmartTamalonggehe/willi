<!-- Modal-->
<div class="modal fade tampilModal" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="formKu">
                <input type="hidden" id="id" name="id">
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="transaksi_id">Jenis Pengeluaran</label>
                            <select class="form-control select2" style="width: 100%" id="transaksi_id" name="transaksi_id">
                                <option value="">Pilih Jenis</option>
                                @foreach ($jenisPengeluaran as $item)
                                <option value="{{ $item->id }}">{{ $item->nm_transaksi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group input-group date">
                            <label for="kt_datepicker_4_4">Tgl. Pengeluaran</label>
                            <input type="text" id="kt_datepicker_4_4" name="tgl_kas" class="form-control"  style="width: 100%">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="rupiah1">Jumlah Pengeluaran</label>
                            <input type="text" id="rupiah1" name="pengeluaran" class="form-control">
                        </div>
                    </div>


                </div>
                {{-- End Row --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary font-weight-bold" id="tombolForm"></button>
            </div>
        </form>
        </div>
    </div>
</div>
   
   
<script>
    var rupiah1 = document.getElementById("rupiah1");
    rupiah1.addEventListener("keyup", function(e) {
      rupiah1.value = convertRupiah(this.value);
    });
    rupiah1.addEventListener('keydown', function(event) {
        return isNumberKey(event);
    });
     
    function convertRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split  = number_string.split(","),
        sisa   = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
     
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
     
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
    }
     
    function isNumberKey(evt) {
        key = evt.which || evt.keyCode;
        if ( 	key != 188 // Comma
             && key != 8 // Backspace
             && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
             && (key < 48 || key > 57) // Non digit
            ) 
        {
            evt.preventDefault();
            return;
        }
    }
</script>
    