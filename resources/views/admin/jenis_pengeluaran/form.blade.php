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
                        <label for="nm_transaksi">Nama Pengeluaran</label>
                        <input type="text" id="nm_transaksi" name="nm_transaksi" class="form-control"  placeholder="Jenis Pengeluaran"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary font-weight-bold" id="tombolForm"></button>
            </div>
        </form>
        </div>
    </div>
</div>
   
   