<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['infaq', 'sedekah', 'donasi', 'zakat', 'wakaf', 'dana kegiatan', 'reservasi']);
            $table->text('deskripsi')->nullable();
            $table->decimal('total_masuk', 15, 2)->default(0);
            $table->decimal('total_keluar', 15, 2)->default(0);
            $table->decimal('dompet');
            $table->timestamps();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
