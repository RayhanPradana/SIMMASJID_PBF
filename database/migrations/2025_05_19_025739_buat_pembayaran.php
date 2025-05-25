<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_fasilitas_id')
                  ->constrained('reservasi_fasilitas')
                  ->onDelete('cascade');

            $table->enum('jenis', ['dp', 'pelunasan', 'lunas']); // jenis pembayaran
            $table->enum('metode_pembayaran', ['transfer', 'tunai', 'lainnya']); // metode pembayaran
            $table->decimal('jumlah_pembayaran', 10, 2); // Menambahkan kolom jumlah pembayaran
            $table->string('bukti_transfer')->nullable(); // path ke gambar
            $table->enum('status', ['pending', 'belum lunas', 'paid', 'unpaid'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
