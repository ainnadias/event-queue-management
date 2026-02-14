<!DOCTYPE html>
<html>
<head>
    <title>Tiket Antrian</title>
    <style>
        <?php echo file_get_contents(public_path('css/custom.css')); ?>
    </style>
</head>
<body class="pdf-layout"> <div class="pdf-border">
        <h1 class="pdf-title">TIKET PAMERAN</h1>
        <p>Silakan tunjukkan tiket ini kepada petugas di lokasi.</p>
        
        <div class="pdf-kode">{{ $kode_tiket }}</div>
        
        <div class="pdf-info">
            <table class="pdf-table">
                <tr>
                    <td class="pdf-label">Nama Pengunjung:</td>
                    <td class="pdf-value">{{ $nama }}</td>
                </tr>
                <tr>
                    <td class="pdf-label">Stand Tujuan:</td>
                    <td class="pdf-value">{{ $stand }}</td>
                </tr>
                <tr>
                    <td class="pdf-label">Tanggal Kunjungan:</td>
                    <td class="pdf-value">{{ $tanggal }}</td>
                </tr>
                <tr>
                    <td class="pdf-label">Nomor Daftar:</td>
                    <td class="pdf-value">#{{ $nomor_antri }}</td>
                </tr>
            </table>
        </div>
        
        <p class="pdf-footer">
            Dicetak otomatis oleh Sistem Antrian Pameran.<br>
            {{ date('d-m-Y H:i:s') }}
        </p>
    </div>

</body>
</html>