<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\PemasukanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JadwalController;

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

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('jadwal', [JadwalController::class, 'index']);
Route::post('jadwal', [JadwalController::class, 'store']);
Route::get('jadwal/{jadwal}', [JadwalController::class, 'show']);
Route::put('jadwal/{jadwal}', [JadwalController::class, 'update']);
Route::delete('jadwal/{jadwal}', [JadwalController::class, 'destroy']);

Route::get('fasilitas', [FasilitasController::class, 'index']);
Route::post('fasilitas', [FasilitasController::class, 'store']);
Route::get('fasilitas/{fasilitas}', [FasilitasController::class, 'show']);
Route::put('fasilitas/{fasilitas}', [FasilitasController::class, 'update']);
Route::delete('fasilitas/{fasilitas}', [FasilitasController::class, 'destroy']);

