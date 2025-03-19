<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\PemasukanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\ReservasiController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('beritaa', [BeritaController::class, 'index']);
Route::post('beritaa', [BeritaController::class, 'store']);
Route::get('beritaa/{id}', [BeritaController::class, 'show']);
Route::put('beritaa/{id}', [BeritaController::class, 'update']);
Route::delete('beritaa/{id}', [BeritaController::class, 'destroy']);

Route::get('keuangan', [KeuanganController::class, 'index']);
Route::post('keuangan', [KeuanganController::class, 'store']);
Route::get('keuangan/{id}', [KeuanganController::class, 'show']);
Route::put('keuangan/{id}', [KeuanganController::class, 'update']);
Route::delete('keuangan/{id}', [KeuanganController::class, 'destroy']);

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('jadwal', [JadwalController::class, 'index']);
Route::post('jadwal', [JadwalController::class, 'store']);
Route::get('jadwal/{id}', [JadwalController::class, 'show']);
Route::put('jadwal/{id}', [JadwalController::class, 'update']);
Route::delete('jadwal/{id}', [JadwalController::class, 'destroy']);

Route::get('fasilitas', [FasilitasController::class, 'index']);
Route::post('fasilitas', [FasilitasController::class, 'store']);
Route::get('fasilitas/{id}', [FasilitasController::class, 'show']);
Route::put('fasilitas/{id}', [FasilitasController::class, 'update']);
Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy']);

Route::get('reservasi', [ReservasiController::class, 'index']);
Route::post('reservasi', [ReservasiController::class, 'store']);
Route::get('reservasi/{id}', [ReservasiController::class, 'show']);
Route::put('reservasi/{id}', [ReservasiController::class, 'update']);
Route::delete('reservasi/{id}', [ReservasiController::class, 'destroy']);

