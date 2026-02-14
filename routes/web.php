<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Api\PublicAntrianController;
use App\Http\Controllers\StandController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('antrian');
});

Route::get('/antrian/cetak/{id}', [PublicAntrianController::class, 'cetakTiket']);


Route::get('/dashboard/antrian', [AntrianController::class, 'index'])->name('dashboard.antrian');


Route::get('/dashboard/stand', [StandController::class, 'index'])->name('dashboard.stand');

