
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koordinasi_damkar', function (Blueprint $table) {
            $table->id();

            // Relasi dengan laporan kejadian
            $table->foreignId('laporan_karhutla_id')
                ->constrained('laporan_karhutla')
                ->restrictOnDelete();

            // Relasi dengan petugas Damkar
            $table->foreignId('petugas_damkar_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Relasi dengan petugas BPBD Pusdalops
            $table->foreignId('bpbd_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Informasi koordinasi
            $table->string('metode_komunikasi');
            $table->dateTime('waktu_koordinasi');

            // Prioritas dan status
            $table->string('prioritas')->default('Tinggi');
            $table->string('status')->default('Terkirim');

            // Catatan tambahan
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koordinasi_damkar');
    }
};
