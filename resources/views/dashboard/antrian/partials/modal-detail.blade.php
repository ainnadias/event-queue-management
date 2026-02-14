    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">

                <div id="ticketResult" class="ticket-box" style="display: block !important;">
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
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>