<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_karhutla', function (Blueprint $table) {
            $table->id();

            // Identitas laporan
            $table->string('kode_laporan')->unique();

            // Data kejadian
            $table->string('lokasi');
            $table->dateTime('waktu_kejadian');
            $table->text('deskripsi');

            // Dokumentasi foto
            $table->string('foto')->nullable();

            // Status laporan
            $table->string('status')->default('Menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_karhutla');
    }
};
