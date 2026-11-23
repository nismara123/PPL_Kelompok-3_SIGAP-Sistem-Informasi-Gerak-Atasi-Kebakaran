<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FSI-05: Penilaian Risiko dan Prioritas Kejadian (PBI-013, PBI-014, PBI-015)
     */
    public function up(): void
    {
        Schema::table('laporan_karhutla', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_karhutla', 'tingkat_risiko')) {
                $table->string('tingkat_risiko', 50)->nullable()->after('diubah_pada');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'prioritas_penanganan')) {
                $table->string('prioritas_penanganan', 50)->nullable()->after('tingkat_risiko');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'estimasi_luas_terdampak')) {
                $table->string('estimasi_luas_terdampak', 100)->nullable()->after('prioritas_penanganan');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'potensi_bahaya')) {
                $table->text('potensi_bahaya')->nullable()->after('estimasi_luas_terdampak');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'catatan_penilaian')) {
                $table->text('catatan_penilaian')->nullable()->after('potensi_bahaya');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'dinilai_oleh')) {
                $table->string('dinilai_oleh', 255)->nullable()->after('catatan_penilaian');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'dinilai_pada')) {
                $table->timestamp('dinilai_pada')->nullable()->after('dinilai_oleh');
            }
            if (!Schema::hasColumn('laporan_karhutla', 'riwayat_penilaian')) {
                $table->json('riwayat_penilaian')->nullable()->after('dinilai_pada');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_karhutla', function (Blueprint $table) {
            $table->dropColumn([
                'tingkat_risiko',
                'prioritas_penanganan',
                'estimasi_luas_terdampak',
                'potensi_bahaya',
                'catatan_penilaian',
                'dinilai_oleh',
                'dinilai_pada',
                'riwayat_penilaian',
            ]);
        });
    }
};

