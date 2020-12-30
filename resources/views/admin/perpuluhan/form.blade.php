<!-- Modal-->
<div class="modal fade tampilModal" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="nm_jemaat">Nama Jemaat</label>
                            <input type="text" id="nm_jemaat" name="nm_jemaat" class="form-control"
                                placeholder="Nama Jemaat" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="jumlah">Jumlah Perpuluhan</label>
                            <input type="text" id="rupiah1" name="jumlah" class="form-control" placeholder="Jumlah" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="tgl_perpuluhan">Tgl. Perpuluhan</label>
                            <input type="date" id="tgl_perpuluhan" name="tgl_perpuluhan" class="form-control"
                                placeholder="Tgl. Perpuluhan" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Tutup</button>
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
            split = number_string.split(","),
            sisa = split[0].length % 3,
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
        if (key != 188 // Comma
            &&
            key != 8 // Backspace
            &&
            key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
            &&
            (key < 48 || key > 57) // Non digit
        ) {
            evt.preventDefault();
            return;
        }
    }

</script>
