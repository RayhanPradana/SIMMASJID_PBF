<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KeuanganController;
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
Route::get('jadwal/{jadwal}', [JadwalController::class, 'show']);
Route::put('jadwal/{jadwal}', [JadwalController::class, 'update']);
Route::delete('jadwal/{jadwal}', [JadwalController::class, 'destroy']);


