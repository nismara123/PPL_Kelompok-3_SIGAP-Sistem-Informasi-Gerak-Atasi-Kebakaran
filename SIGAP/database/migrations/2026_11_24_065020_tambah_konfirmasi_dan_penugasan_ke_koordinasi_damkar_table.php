
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('koordinasi_damkar', function (Blueprint $table) {
            $table->string('tim_ditugaskan')->nullable()->after('status');
            $table->dateTime('waktu_konfirmasi')->nullable()->after('tim_ditugaskan');
            $table->text('catatan_konfirmasi')->nullable()->after('waktu_konfirmasi');
        });
    }

    public function down(): void
    {
        Schema::table('koordinasi_damkar', function (Blueprint $table) {
            $table->dropColumn([
                'tim_ditugaskan',
                'waktu_konfirmasi',
                'catatan_konfirmasi',
            ]);
        });
    }
};
