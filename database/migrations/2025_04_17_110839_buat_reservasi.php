<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acara_id')->constrained('acara')->onDelete('cascade');
            $table->foreignId('fasilitas_id')->constrained('fasilitas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // HAPUS sesi_id karena akan dipindah ke tabel pivot
            $table->date('tgl_reservasi');
            $table->enum('status_reservasi', [
                'pending',
                'ditolak',
                'disetujui',
                'menunggu lunas',
                'siap digunakan',
                'sedang berlangsung',
                'dibatalkan',
                'selesai'
            ])->default('pending');
            $table->decimal('harga', 12, 2)->nullable(); // Tambahan kolom harga
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_fasilitas');
    }
};
