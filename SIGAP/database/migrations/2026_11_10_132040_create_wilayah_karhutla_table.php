
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah_karhutla', function (Blueprint $table) {
            $table->id();
            $table->string('kode_wilayah')->unique();

            $table->string('kode_kabupaten');
            $table->string('kabupaten');

            $table->string('kode_kecamatan');
            $table->string('kecamatan');

            $table->string('kode_desa');
            $table->string('desa_kelurahan');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah_karhutlas');
    }
};
