<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerusakan_lahan', function (Blueprint $table) {
            $table->id();
            // Relasi ke Data Wilayah Karhutla (FSI-01)
            $table->foreignId('wilayah_id')->constrained('wilayah_karhutla')->restrictOnDelete();
            $table->string('lokasi');
            $table->string('jenis_kerusakan');
            $table->decimal('luas_ha', 10, 2)->nullable();
            $table->date('tanggal_pencatatan');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerusakan_lahan');
    }
};
