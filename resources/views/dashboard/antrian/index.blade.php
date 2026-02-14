@extends('layouts.app')

@section('title', 'Dashboard | Antrian Pameran')

@section('content')
<div class="container-fluid" style="margin-top:30px; margin-right:20px; margin-left:20px;">
    <h2 class="text-center">Data Pengunjung</h2>
    <hr>

    <table id="tableAntrian" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tiket</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Stand</th>
                <th>Tanggal</th>
                <th>Nomor Antrian</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

    @include('dashboard.antrian.partials.modal-detail')
    @include('dashboard.antrian.partials.modal-edit')
@endsection

@section('scripts')
    <script src="{{ asset('js/antrian.js') }}"></script>
@endsection
