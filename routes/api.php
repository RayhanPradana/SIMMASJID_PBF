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
use App\Http\Controllers\Api\AcaraController;
use App\Http\Controllers\Api\SesiController;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('jadwals', [JadwalController::class, 'index']);
Route::get('beritas', [BeritaController::class, 'index']);

Route::get('jadwals', [JadwalController::class, 'index']);
Route::get('beritas', [BeritaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ================== Route JEMAAH ====================
    Route::middleware('role:jemaah')->group(function () {

        // Berita
        Route::get('berita', [BeritaController::class, 'index']);
        Route::post('berita', [BeritaController::class, 'store']);
        Route::get('berita/{id}', [BeritaController::class, 'show']);
        Route::put('berita/{id}', [BeritaController::class, 'update']);
        Route::delete('berita/{id}', [BeritaController::class, 'destroy']);

        // Keuangan
        Route::get('keuangan', [KeuanganController::class, 'index']);
        Route::post('keuangan', [KeuanganController::class, 'store']);
        Route::get('keuangan/{id}', [KeuanganController::class, 'show']);
        Route::put('keuangan/{id}', [KeuanganController::class, 'update']);
        Route::delete('keuangan/{id}', [KeuanganController::class, 'destroy']);
        //user
        Route::post('users1-update', [UserController::class, 'updatePassword']);
        Route::post('users1-profile', [UserController::class, 'updateProfile']);
        Route::post('users1-photo', [UserController::class, 'updatePhoto']);

        Route::get('berita1', [BeritaController::class, 'index']);
        Route::get('berita1/{id}', [BeritaController::class, 'show']);

        Route::get('jadwal1', [JadwalController::class, 'index']);
        Route::get('jadwal1/{id}', [JadwalController::class, 'show']);

        // User
        Route::get('usersuser', [UserController::class, 'index']);
        Route::post('usersuser', [UserController::class, 'store']);
        Route::get('usersuser/{id}', [UserController::class, 'show']);
        Route::put('usersuser/{id}', [UserController::class, 'update']);
        Route::delete('usersuser/{id}', [UserController::class, 'destroy']);
        Route::post('users-update', [UserController::class, 'updatePassword']);
        Route::post('users-profile', [UserController::class, 'updateProfile']);
        Route::post('users-photo', [UserController::class, 'updatePhoto']);

        // // Jadwal
        // Route::get('jadwals', [JadwalController::class, 'index']);
        // Route::post('jadwals', [JadwalController::class, 'store']);
        // Route::get('jadwals/{id}', [JadwalController::class, 'show']);
        // Route::put('jadwals/{id}', [JadwalController::class, 'update']);
        // Route::delete('jadwals/{id}', [JadwalController::class, 'destroy']);

        Route::get('acarauser', [AcaraController::class, 'index']);
        Route::post('acarauser', [AcaraController::class, 'store']);
        Route::get('acarauser/{id}', [AcaraController::class, 'show']);
        Route::put('acarauser/{id}', [AcaraController::class, 'update']);
        Route::delete('acarauser/{id}', [AcaraController::class, 'destroy']);

        // Fasilitas
        Route::get('fasilitasuser', [FasilitasController::class, 'index']);
        Route::post('fasilitasuser', [FasilitasController::class, 'store']);
        Route::get('fasilitasuser/{id}', [FasilitasController::class, 'show']);
        Route::put('fasilitasuser/{id}', [FasilitasController::class, 'update']);
        Route::delete('fasilitasuser/{id}', [FasilitasController::class, 'destroy']);

        Route::get('pembayaranuser', [PembayaranController::class, 'index']);
        Route::post('pembayaranuser', [PembayaranController::class, 'store']);
        Route::get('pembayaranuser/{id}', [PembayaranController::class, 'show']);
        Route::put('pembayaranuser/{id}', [PembayaranController::class, 'update']);
        Route::delete('pembayaranuser/{id}', [PembayaranController::class, 'destroy']);

        Route::get('reservasiuser', [ReservasiController::class, 'index']);
        Route::post('reservasiuser', [ReservasiController::class, 'store']);
        Route::get('reservasiuser/{id}', [ReservasiController::class, 'show']);
        Route::put('reservasiuser/{id}', [ReservasiController::class, 'update']);
        Route::delete('reservasiuser/{id}', [ReservasiController::class, 'destroy']);
        Route::post('/reservasiuser/confirm/{id}', [ReservasiController::class, 'confirm']);

        Route::get('sesiuser', [SesiController::class, 'index']);
        Route::post('sesiuser', [SesiController::class, 'store']);
        Route::get('sesiuser/{id}', [SesiController::class, 'show']);
        Route::put('sesiuser/{id}', [SesiController::class, 'update']);
        Route::delete('sesiuser/{id}', [SesiController::class, 'destroy']);
    });

    // ================== Route ADMIN ====================
    Route::middleware('role:admin')->group(function () {

        // Dashboard
        Route::get('dashboard', [AuthController::class, 'dashboard']);
        
        // Berita
        Route::get('berita', [BeritaController::class, 'index']);
        Route::post('berita', [BeritaController::class, 'store']);
        Route::get('berita/{id}', [BeritaController::class, 'show']);
        Route::put('berita/{id}', [BeritaController::class, 'update']);
        Route::delete('berita/{id}', [BeritaController::class, 'destroy']);

        // Keuangan
        Route::get('keuangan', [KeuanganController::class, 'index']);
        Route::post('keuangan', [KeuanganController::class, 'store']);
        Route::get('keuangan/{id}', [KeuanganController::class, 'show']);
        Route::put('keuangan/{id}', [KeuanganController::class, 'update']);
        Route::delete('keuangan/{id}', [KeuanganController::class, 'destroy']);
        Route::get('keuangan-laporan', [KeuanganController::class, 'laporan']);
        Route::get('keuangan-cetak', [KeuanganController::class, 'cetak']);

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

        //acara
        Route::get('acara', [AcaraController::class, 'index']);
        Route::post('acara', [AcaraController::class, 'store']);
        Route::get('acara/{id}', [AcaraController::class, 'show']);
        Route::put('acara/{id}', [AcaraController::class, 'update']);
        Route::delete('acara/{id}', [AcaraController::class, 'destroy']);

        // Fasilitas
        Route::get('fasilitas', [FasilitasController::class, 'index']);
        Route::post('fasilitas', [FasilitasController::class, 'store']);
        Route::get('fasilitas/{id}', [FasilitasController::class, 'show']);
        Route::put('fasilitas/{id}', [FasilitasController::class, 'update']);
        Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy']);

        Route::get('pembayaran', [PembayaranController::class, 'index']);
        Route::post('pembayaran', [PembayaranController::class, 'store']);
        Route::get('pembayaran/{id}', [PembayaranController::class, 'show']);
        Route::put('pembayaran/{id}', [PembayaranController::class, 'update']);
        Route::delete('pembayaran/{id}', [PembayaranController::class, 'destroy']);

        Route::get('reservasi', [ReservasiController::class, 'index']);
        Route::post('reservasi', [ReservasiController::class, 'store']);
        Route::get('reservasi/{id}', [ReservasiController::class, 'show']);
        Route::put('reservasi/{id}', [ReservasiController::class, 'update']);
        Route::delete('reservasi/{id}', [ReservasiController::class, 'destroy']);
        Route::post('/reservasi/confirm/{id}', [ReservasiController::class, 'confirm']);
        Route::post('reservasi/update-status-otomatis', [ReservasiController::class, 'updateAllStatusOtomatis']);

        Route::get('sesi', [SesiController::class, 'index']);
        Route::post('sesi', [SesiController::class, 'store']);
        Route::get('sesi/{id}', [SesiController::class, 'show']);
        Route::put('sesi/{id}', [SesiController::class, 'update']);
        Route::delete('sesi/{id}', [SesiController::class, 'destroy']);




    });
});
