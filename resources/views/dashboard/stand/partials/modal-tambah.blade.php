    {{-- modal tambah data --}}
    <div class="modal fade" id="modalTambahStand" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Data Stand</h4>
                </div>
                <form id="formTambahStand">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Stand</label>
                            <input type="text" name="kd_stand" class="form-control" required placeholder="Contoh: KR">
                        </div>
                        <div class="form-group">
                            <label>Nama Stand</label>
                            <input type="text" name="nama_stand" class="form-control" required placeholder="Nama Stand">
                        </div>
                        <div class="form-group">
                            <label>Kuota</label>
                            <input type="number" name="quota" class="form-control" required placeholder="Jumlah Kuota Pengunjung">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanStand">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>