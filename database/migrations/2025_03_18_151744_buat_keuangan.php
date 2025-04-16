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
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->decimal('jumlah', 15, 2);
            $table->string('sumber')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
