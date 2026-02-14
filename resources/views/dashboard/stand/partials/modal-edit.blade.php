

    {{-- modal edit data --}}
    <div class="modal fade" id="modalEditStand" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Data Stand</h4>
                </div>
                <form id="formEditStand">
                    <input type="hidden" id="edit_id"> <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Stand</label>
                            <input type="text" id="edit_kd_stand" name="kd_stand" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Stand</label>
                            <input type="text" id="edit_nama_stand" name="nama_stand" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kuota Pengunjung</label>
                            <input type="number" id="edit_quota" name="quota" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdateStand">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>