$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#tableStand').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/api/master-stand',
            type: 'GET',
            dataSrc: 'data',
            error: function (xhr, error, thrown) {
                console.log("Error detail:", xhr.responseText);
                Swal.fire('Error', 'Gagal mengambil data dari server', 'error');
            }
        },
        columns: [
            { data: null },
            { data: 'kd_stand' },
            { data: 'nama_stand' },
            { data: 'quota' },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <button class="btn btn-primary btn-xs btn-edit" data-id="${data}">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button class="btn btn-danger btn-xs btn-delete" data-id="${data}">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>`;
                }
            }
        ],
        columnDefs: [{
            targets: 0,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        }]
    });

    // Tambah Data
    $('#formTambahStand').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let btn = $('#btnSimpanStand');

        btn.html('Menyimpan...').attr('disabled', true);

        $.ajax({
            url: '/api/master-stand',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#modalTambahStand').modal('hide');
                $('#formTambahStand')[0].reset();
                table.ajax.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = '';
                $.each(errors, function(key, value) {
                    errorMsg += value[0] + '<br>';
                });
                Swal.fire({ icon: 'error', title: 'Gagal Simpan', html: errorMsg });
            },
            complete: function() {
                btn.html('Simpan Data').attr('disabled', false);
            }
        });
    });

    // Edit Data (Ambil data ke modal)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.get(`/api/master-stand/${id}`, function(res) {
            $('#edit_id').val(res.data.id);
            $('#edit_kd_stand').val(res.data.kd_stand);
            $('#edit_nama_stand').val(res.data.nama_stand);
            $('#edit_quota').val(res.data.quota);
            $('#modalEditStand').modal('show');
        });
    });

    // Update Data (Proses simpan perubahan)
    $('#formEditStand').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = $(this).serialize();

        $.ajax({
            url: `/api/master-stand/${id}`,
            type: 'PUT', 
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success');
                $('#modalEditStand').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = errors ? Object.values(errors).flat().join('<br>') : 'Terjadi kesalahan sistem.';
                Swal.fire({ icon: 'error', title: 'Update Gagal', html: errorMsg });
            }
        });
    });

    // Delete Data
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data stand ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/master-stand/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire('Terhapus!', response.message, 'success');
                        table.ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    });
});