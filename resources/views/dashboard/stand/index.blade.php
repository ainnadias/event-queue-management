@extends('layouts.app')

@section('title', 'Dashboard | Stand')

@section('content')
    
    <div class="container" style="margin-top:150px; margin-bottom:200px;">
        <div class="row" style="margin-bottom:15px;">
            
            <div class="col-sm-6 text-left">
                <h2 style="margin:0;">Data Stand</h2>
            </div>

            <div class="col-sm-6 text-right" style="padding-top:5px;">
                <button type="button" 
                        class="btn btn-create-post" 
                        data-toggle="modal" 
                        data-target="#modalTambahStand">
                    Tambah Stand Pameran
                </button>
            </div>
        </div>
        <hr>


        <table id="tableStand" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Stand</th>
                    <th>Nama Stand</th>
                    <th>Kuota</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    @include('dashboard.stand.partials.modal-tambah')
    @include('dashboard.stand.partials.modal-edit')
@endsection

@section('scripts')
    <script src="{{ asset('js/stand-crud.js') }}"></script>
@endsection