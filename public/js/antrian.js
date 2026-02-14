      $(document).ready(function() {
            $('#tableAntrian').DataTable({
                processing: true,
                ajax: {
                    url: '/api/master-antrian',
                    type: 'GET',
                    dataSrc: 'data'
                },
                columns: [
                    { data: null },
                    { data: 'kode_tiket' },
                    { data: 'nama' },
                    { data: 'email' },
                    { data: 'nama_stand' },
                    { data: 'tanggal_pesan' },
                    { data: 'nomor_antri' },
                    { data: 'created_at' },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-info btn-xs btn-detail" data-id="${data}">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </button>

                                <button class="btn btn-primary btn-xs btn-edit" data-id="${data}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>

                                <button class="btn btn-danger btn-xs btn-delete" 
                                        data-id="${data}">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            `;
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

            $(document).on('click', '.btn-detail', function () {
                const id = $(this).data('id');

                $.get(`/api/master-antrian/${id}`, function (res) {
                    console.log("Data diterima:", res);

                    if(res.success) {
                        let data = res.data;

                        $('#resKode').text(data.kode_tiket || '-'); 
                        $('#resNama').text(data.nama || '-');
                        $('#resTanggal').text(data.tanggal_pesan_formatted || data.tanggal_pesan); 
                        $('#resStand').text(data.nama_stand || '-');
                        $('#resNo').text(data.nomor_antri || '-');

                        let urlPdf = '/antrian/cetak/' + data.id;
                        $('#btnDownloadPdf').attr('href', urlPdf);

                        $('#detailModal').modal('show');
                    } else {
                        alert('Gagal mengambil data antrian');
                    }
                }).fail(function() {
                    alert('Terjadi kesalahan server');
                });
            });

            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                
                $('#formEdit')[0].reset();
                $('#btnUpdate').attr('disabled', true).text('Memuat...');

                $.get(`/api/master-antrian/${id}`, function (res) {
                    if(res.success) {
                        const data = res.data;

                        $('#edit_id').val(data.id);
                        $('#edit_nama').val(data.nama);
                        $('#edit_email').val(data.email);

                        $('#info_kode').text(data.kode_tiket || '-');
                        $('#info_stand').text(data.nama_stand || '-');

                        $('#editModal').modal('show');
                    } else {
                        Swal.fire('Error', 'Gagal mengambil data', 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                })
                .always(function() {
                    $('#btnUpdate').attr('disabled', false).html('<i class="glyphicon glyphicon-save"></i> Simpan Perubahan');
                });
            });

            $('#formEdit').on('submit', function (e) {
                e.preventDefault(); 

                const id = $('#edit_id').val();
                const btn = $('#btnUpdate');
                
                const originalText = btn.html();
                btn.text('Menyimpan...').attr('disabled', true);

                const formData = {
                    nama: $('#edit_nama').val(),
                    email: $('#edit_email').val(),
                    _token: $('meta[name="csrf-token"]').attr('content') 
                };

                $.ajax({
                    url: `/api/master-antrian/${id}`,
                    type: 'PUT', 
                    data: formData,
                    success: function (response) {
                        $('#editModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: 'Data pengunjung berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#tableAntrian').DataTable().ajax.reload(null, false); 
                    },
                    error: function (xhr) {
                        let errorMessage = 'Gagal menyimpan perubahan.';
                        
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors)[0][0]; 
                        }

                        Swal.fire('Gagal', errorMessage, 'error');
                    },
                    complete: function() {
                        btn.html(originalText).attr('disabled', false);
                    }
                });
            });

            // delete
           $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');

                if (confirm('Yakin mau hapus antrian ini?')) {
                    $.ajax({
                        url: `/api/master-antrian/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert('Data berhasil dihapus');
                            $('#tableAntrian').DataTable().ajax.reload();
                        },
                        error: function () {
                            alert('Terjadi kesalahan saat menghapus data');
                        }
                    });
                }
            }); 

        }); 