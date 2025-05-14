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
            $table->date('tgl_reservasi');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->date('tgl_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['unpaid', 'paid'])->default('paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
