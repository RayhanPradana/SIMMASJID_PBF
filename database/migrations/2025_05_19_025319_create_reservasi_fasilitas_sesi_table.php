<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi_fasilitas_sesi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_fasilitas_id')->constrained('reservasi_fasilitas')->onDelete('cascade');
            $table->foreignId('sesi_id')->constrained('sesi')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['reservasi_fasilitas_id', 'sesi_id']); // untuk mencegah duplikat
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_fasilitas_sesi');
    }
};
