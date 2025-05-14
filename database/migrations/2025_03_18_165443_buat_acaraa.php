<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acara', function (Blueprint $table) {
            $table->id();
            $table->string('nama_acara'); // Contoh: Akad Nikah, Resepsi Pernikahan
            $table->text('deskripsi')->nullable(); // Deskripsi tambahan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('acara');
    }

};
