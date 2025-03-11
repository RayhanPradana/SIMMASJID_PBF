<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\PemasukanController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('beritaa', [BeritaController::class, 'index']);
Route::post('beritaa', [BeritaController::class, 'store']);
Route::get('beritaa/{berita}', [BeritaController::class, 'show']);
Route::put('beritaa/{berita}', [BeritaController::class, 'update']);
Route::delete('beritaa/{berita}', [BeritaController::class, 'destroy']);

Route::get('pemasukan', [PemasukanController::class, 'index']);
Route::post('pemasukan', [PemasukanController::class, 'store']);
Route::get('pemasukan/{pemasukan}', [PemasukanController::class, 'show']);
Route::put('pemasukan/{pemasukan}', [PemasukanController::class, 'update']);
Route::delete('pemasukan/{pemasukan}', [PemasukanController::class, 'destroy']);


