<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\PemasukanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\ReservasiController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ================== Route JEMAAH ====================
    Route::middleware('role:jemaah')->group(function () {

        Route::get('berita', [BeritaController::class, 'index']);
        Route::get('berita/{id}', [BeritaController::class, 'show']);

        Route::get('jadwal', [JadwalController::class, 'index']);
        Route::get('jadwal/{id}', [JadwalController::class, 'show']);

        Route::get('fasilitas', [FasilitasController::class, 'index']);
        Route::get('fasilitas/{id}', [FasilitasController::class, 'show']);

        Route::get('pembayaran', [PembayaranController::class, 'index']);
        Route::get('pembayaran/{id}', [PembayaranController::class, 'show']);
        Route::post('pembayaran', [PembayaranController::class, 'store']);

        Route::get('reservasi', [ReservasiController::class, 'index']);
        Route::post('reservasi', [ReservasiController::class, 'store']);
        Route::get('reservasi/{id}', [ReservasiController::class, 'show']);
        Route::put('reservasi/{id}', [ReservasiController::class, 'update']);
        Route::delete('reservasi/{id}', [ReservasiController::class, 'destroy']);
    });

    // ================== Route ADMIN ====================
    Route::middleware('role:admin')->group(function () {

        // Berita
        Route::get('berita', [BeritaController::class, 'index']);
        Route::post('berita', [BeritaController::class, 'store']);
        Route::get('berita/{id}', [BeritaController::class, 'show']);
        Route::put('berita/{id}', [BeritaController::class, 'update']);
        Route::delete('berita/{id}', [BeritaController::class, 'destroy']);

        // Keuangan
        Route::get('keuangan', [KeuanganController::class, 'index']);
        Route::post('keuangans', [KeuanganController::class, 'store']);
        Route::get('keuangan/{id}', [KeuanganController::class, 'show']);
        Route::put('keuangan/{id}', [KeuanganController::class, 'update']);
        Route::delete('keuangan/{id}', [KeuanganController::class, 'destroy']);

        // User
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::put('users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);
        Route::post('users-update', [UserController::class, 'updatePassword']);
        Route::post('users-profile', [UserController::class, 'updateProfile']);
        Route::post('users-photo', [UserController::class, 'updatePhoto']);

        // Jadwal
        Route::get('jadwal', [JadwalController::class, 'index']);
        Route::post('jadwal', [JadwalController::class, 'store']);
        Route::get('jadwal/{id}', [JadwalController::class, 'show']);
        Route::put('jadwal/{id}', [JadwalController::class, 'update']);
        Route::delete('jadwal/{id}', [JadwalController::class, 'destroy']);

        // Fasilitas
        Route::get('fasilitas', [FasilitasController::class, 'index']);
        Route::post('fasilitas', [FasilitasController::class, 'store']);
        Route::get('fasilitas/{id}', [FasilitasController::class, 'show']);
        Route::put('fasilitas/{id}', [FasilitasController::class, 'update']);
        Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy']);
    });
});
