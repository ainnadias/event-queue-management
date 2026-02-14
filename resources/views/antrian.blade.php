<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrian Pameran</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <div class="navbar-header" style="float: none; text-align: center;">
                <div class="navbar-brand" style="float: none; display: inline-block;" >
                    PENDAFTARAN <b>PAMERAN</b>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                
                <div class="text-center mb-4">
                    <h2>Daftar</h2>
                    <p class="text-muted">Silakan isi formulir di bawah untuk mendapatkan tiket pameran.</p>
                </div>

                {{-- Form --}}
                <div class="panel panel-default panel-custom" id="panelForm">
                    <div class="panel-heading panel-heading-custom">
                        <h3 class="panel-title text-center"><i class="glyphicon glyphicon-edit"></i> Form Pendaftaran</h3>
                    </div>
                    <div class="panel-body">
                        <form id="formAntrian">
                            <p>*Pilih tanggal kunjungan terlebih dulu sebelum mengisi yang lain!</p>
                            <div class="form-group">
                                <label>Tanggal Kunjungan</label>
                                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" min="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Pilih Stand Tujuan</label>
                                <select class="form-control" id="kd_stand" name="kd_stand" required>
                                    <option value="">-- Sedang Memuat Data... --</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Budi Santoso" required>
                            </div>

                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" class="form-control" name="email" placeholder="email@contoh.com" required>
                            </div>

                            <button type="submit" class="btn btn-submit w-100 mt-4" id="btnSubmit">
                                DAFTAR
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tampilan Tiket --}}
                <div id="ticketResult" class="ticket-box">
                    <div class="ticket-header">TIKET ANTRIAN ANDA</div>
                    
                    <div class="ticket-code" id="resKode">-</div>
                    
                    <hr>
                    <div class="ticket-info">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <small>Nama:</small><br>
                                <b id="resNama">-</b> 
                            </div>
                            <div class="col-xs-6 text-right">
                                <small>Tanggal:</small><br>
                                <b id="resTanggal">-</b>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xs-12 text-center">
                                <h4 style="margin: 10px 0 5px 0;" id="resStand">-</h4>
                                <span class="label label-primary" style="font-size: 12px;">
                                    Nomor Daftar: <span id="resNo">-</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <a id="btnDownloadPdf" href="#" class="btn btn-success" target="_blank">
                            <i class="glyphicon glyphicon-download-alt"></i> Download PDF
                        </a>

                        <button class="btn btn-default" onclick="location.reload()">
                            <i class="glyphicon glyphicon-refresh"></i> Daftar Lagi
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p>&copy; 2026 Sistem Antrian Pameran. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#tanggal_pesan').on('change', function() {

                let tanggal = $(this).val();
                if (!tanggal) return;

                $.ajax({
                    url: '/api/stand?tanggal=' + tanggal,
                    type: 'GET',
                    success: function(response) {

                        let options = '<option value="">-- Pilih Stand --</option>';

                        response.data.forEach(function(item) {

                            let disabled = item.sisa <= 0 ? 'disabled' : '';

                            options += `
                                <option value="${item.kd_stand}" ${disabled}>
                                    ${item.nama_stand} (Sisa: ${item.sisa})
                                </option>
                            `;
                        });

                        $('#kd_stand').html(options);
                    }
                });
            });

            $('#formAntrian').on('submit', function(e) {

                e.preventDefault();

                let btn = $('#btnSubmit');
                let originalText = btn.text();
                btn.text('Sedang Memproses...').attr('disabled', true);

                let formData = {
                    kd_stand: $('#kd_stand').val(),
                    nama: $('input[name="nama"]').val(),
                    email: $('input[name="email"]').val(),
                    tanggal_pesan: $('#tanggal_pesan').val()
                };

                $.ajax({
                    url: '/api/antrian',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Nomor antrian berhasil dibuat.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#resKode').text(response.data.kode_tiket);
                        $('#resNama').text(formData.nama);
                        $('#resTanggal').text(response.data.tanggal);
                        $('#resStand').text(response.data.stand);
                        $('#resNo').text(response.data.nomor_antri);

                        let urlPdf = '/antrian/cetak/' + response.data.id;
                        $('#btnDownloadPdf').attr('href', urlPdf);

                        $('#panelForm').slideUp();
                        $('#ticketResult').slideDown();
                    },
                    error: function(xhr) {

                        btn.text(originalText).attr('disabled', false);

                        let errorMessage = 'Terjadi kesalahan sistem.';

                        if(xhr.responseJSON) {
                            if(xhr.status === 422) {
                                errorMessage = 'Mohon lengkapi data dengan benar.';
                            } else if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMessage
                        });
                    }
                });

            });

        });
    </script>
</body>
</html>