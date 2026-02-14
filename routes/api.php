<?php

use App\Http\Controllers\Api\AntrianController;
use App\Http\Controllers\Api\PublicAntrianController;
use App\Http\Controllers\Api\StandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/stand', [PublicAntrianController::class, 'getStand']);
Route::post('/antrian', [PublicAntrianController::class , 'store']);
Route::get('antrian/{id}', [PublicAntrianController::class, 'show']);


Route::apiResource('master-stand', StandController::class);
Route::apiResource('master-antrian', AntrianController::class);



