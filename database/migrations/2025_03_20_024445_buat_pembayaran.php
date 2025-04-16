<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reservasi_id');
            $table->string('metode_pembayaran');
            $table->decimal('jumlah', 10, 2);
            $table->string('status')->default('pending'); // pending, sukses, gagal
            $table->string('bukti_transfer')->nullable(); // Menyimpan path bukti transfer
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reservasi_id')->references('id')->on('reservasi_fasilitas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
