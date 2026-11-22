<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_karhutla', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_karhutla', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'riwayat_status')) {
                $table->json('riwayat_status')->nullable()->after('alasan_penolakan');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'diubah_oleh')) {
                $table->string('diubah_oleh')->nullable()->after('riwayat_status');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'diubah_pada')) {
                $table->timestamp('diubah_pada')->nullable()->after('diubah_oleh');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_karhutla', function (Blueprint $table) {
            $table->dropColumn([
                'alasan_penolakan',
                'riwayat_status',
                'diubah_oleh',
                'diubah_pada',
            ]);
        });
    }
};