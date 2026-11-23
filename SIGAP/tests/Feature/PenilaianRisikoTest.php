<?php

namespace Tests\Feature;

use App\Models\LaporanKarhutla;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenilaianRisikoTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(string $role = 'pusdalops'): User
    {
        return User::factory()->create([
            'role' => $role,
            'name' => 'Petugas Pusdalops Banyumas',
        ]);
    }

    private function buatLaporan(array $override = []): LaporanKarhutla
    {
        return LaporanKarhutla::create(array_merge([
            'kode_laporan' => 'KARHUTLA-' . strtoupper(fake()->lexify('????????')),
            'lokasi' => 'Lereng Hutan Pinus Limpakuwus, Sumbang',
            'waktu_kejadian' => '2026-11-20 14:30:00',
            'deskripsi' => 'Terlihat kepulan asap tebal dan api menjalar ke semak kering di lereng.',
            'foto' => null,
            'status' => 'Terverifikasi',
        ], $override));
    }

    /**
     * PBI-013 Acceptance Criteria 1:
     * Sistem menyediakan form untuk memasukkan hasil penilaian risiko kejadian.
     */
    public function test_pusdalops_dapat_mengakses_form_penilaian_risiko(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan();

        $response = $this->actingAs($pusdalops)->get(route('penilaian-risiko.create', $laporan->id));

        $response->assertOk();
        $response->assertSee('Form Penilaian Risiko');
        $response->assertSee($laporan->kode_laporan);
        $response->assertSee('Tingkat Risiko');
        $response->assertSee('Prioritas Penanganan');
    }

    /**
     * PBI-013 Acceptance Criteria 2:
     * Petugas dapat menyimpan hasil penilaian risiko pada data kejadian.
     */
    public function test_pusdalops_dapat_menyimpan_hasil_penilaian_risiko(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan();

        $payload = [
            'tingkat_risiko' => 'Tinggi',
            'prioritas_penanganan' => 'Tinggi',
            'estimasi_luas_terdampak' => '± 2.5 Hektar',
            'potensi_bahaya' => ['Dekat Pemukiman Penduduk', 'Kecepatan Angin Tinggi'],
            'catatan_penilaian' => 'Api aktif merambat ke arah kebun warga dengan tiupan angin kencang. Butuh armada tangki pemadam segera.',
        ];

        $response = $this->actingAs($pusdalops)
            ->post(route('penilaian-risiko.store', $laporan->id), $payload);

        $response->assertRedirect(route('laporan.show', $laporan->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_karhutla', [
            'id' => $laporan->id,
            'tingkat_risiko' => 'Tinggi',
            'prioritas_penanganan' => 'Tinggi',
            'estimasi_luas_terdampak' => '± 2.5 Hektar',
            'dinilai_oleh' => $pusdalops->name,
        ]);

        $laporanSegar = $laporan->fresh();
        $this->assertNotNull($laporanSegar->riwayat_penilaian);
        $this->assertEquals('Penilaian Awal', $laporanSegar->riwayat_penilaian[0]['aksi']);
    }

    /**
     * PBI-013 Acceptance Criteria 3:
     * Sistem menampilkan hasil penilaian risiko yang telah disimpan pada detail kejadian.
     */
    public function test_sistem_menampilkan_hasil_penilaian_risiko_pada_detail_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan([
            'tingkat_risiko' => 'Kritis',
            'prioritas_penanganan' => 'Darurat',
            'estimasi_luas_terdampak' => '± 4.0 Hektar',
            'potensi_bahaya' => 'Dekat Pemukiman Penduduk, Lahan Gambut Kering',
            'catatan_penilaian' => 'Api sangat dekat dengan rumah warga. Evakuasi darurat diperlukan.',
            'dinilai_oleh' => 'Komandan Pusdalops',
            'dinilai_pada' => now(),
        ]);

        $response = $this->actingAs($pusdalops)->get(route('laporan.show', $laporan->id));

        $response->assertOk();
        $response->assertSee('Hasil Penilaian Risiko');
        $response->assertSee('Prioritas Penanganan');
        $response->assertSee('Kritis');
        $response->assertSee('Darurat');
        $response->assertSee('± 4.0 Hektar');
        $response->assertSee('Komandan Pusdalops');
        $response->assertSee('Api sangat dekat dengan rumah warga');
    }

    /**
     * PBI-014 Acceptance Criteria 1 & 2:
     * Petugas dapat memilih data kejadian yang akan diperbarui dan sistem menyediakan form ubah penilaian risiko.
     */
    public function test_pusdalops_dapat_mengakses_form_ubah_penilaian_risiko(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan([
            'tingkat_risiko' => 'Sedang',
            'prioritas_penanganan' => 'Sedang',
            'catatan_penilaian' => 'Asesmen awal vegetasi terbakar.',
        ]);

        $response = $this->actingAs($pusdalops)->get(route('penilaian-risiko.edit', $laporan->id));

        $response->assertOk();
        $response->assertSee('Edit Penilaian Risiko');
        $response->assertSee($laporan->kode_laporan);
        $response->assertSee('Asesmen awal vegetasi terbakar.');
    }

    /**
     * PBI-014 Acceptance Criteria 3:
     * Sistem menyimpan dan menampilkan hasil perubahan penilaian risiko beserta audit log.
     */
    public function test_pusdalops_dapat_memperbarui_penilaian_risiko(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan([
            'tingkat_risiko' => 'Sedang',
            'prioritas_penanganan' => 'Sedang',
            'catatan_penilaian' => 'Penilaian pertama.',
            'dinilai_oleh' => 'Petugas Shift Pagi',
            'riwayat_penilaian' => [
                [
                    'aksi' => 'Penilaian Awal',
                    'tingkat_risiko' => 'Sedang',
                    'prioritas_penanganan' => 'Sedang',
                    'catatan_penilaian' => 'Penilaian pertama.',
                    'dinilai_oleh' => 'Petugas Shift Pagi',
                    'waktu' => '20-11-2026 09:00 WIB',
                ]
            ],
        ]);

        $payload = [
            'tingkat_risiko' => 'Kritis',
            'prioritas_penanganan' => 'Darurat',
            'estimasi_luas_terdampak' => '± 6.0 Hektar',
            'potensi_bahaya' => ['Dekat Pemukiman Penduduk', 'Kecepatan Angin Tinggi'],
            'catatan_penilaian' => 'Api eskalasi membesar dipicu angin kencang ke arah pemukiman. Eskalasi darurat!',
            'alasan_pembaruan' => 'Peningkatan kecepatan angin dan arah rambatan api mendekati pemukiman.',
        ];

        $response = $this->actingAs($pusdalops)
            ->put(route('penilaian-risiko.update', $laporan->id), $payload);

        $response->assertRedirect(route('laporan.show', $laporan->id));

        $this->assertDatabaseHas('laporan_karhutla', [
            'id' => $laporan->id,
            'tingkat_risiko' => 'Kritis',
            'prioritas_penanganan' => 'Darurat',
            'estimasi_luas_terdampak' => '± 6.0 Hektar',
            'dinilai_oleh' => $pusdalops->name,
        ]);

        $laporanSegar = $laporan->fresh();
        $this->assertCount(2, $laporanSegar->riwayat_penilaian);
        $this->assertEquals('Pembaruan Penilaian', $laporanSegar->riwayat_penilaian[1]['aksi']);
    }

    /**
     * PBI-015 Acceptance Criteria 1, 2, & 3:
     * Sistem menampilkan tingkat risiko dan prioritas setiap kejadian pada daftar kejadian.
     */
    public function test_sistem_menampilkan_tingkat_risiko_dan_prioritas_pada_daftar_kejadian(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporanKritis = $this->buatLaporan([
            'lokasi' => 'Desa Limpakuwus RT 02',
            'tingkat_risiko' => 'Kritis',
            'prioritas_penanganan' => 'Darurat',
        ]);
        $laporanRendah = $this->buatLaporan([
            'lokasi' => 'Desa Karangsalam Blok C',
            'tingkat_risiko' => 'Rendah',
            'prioritas_penanganan' => 'Rendah',
        ]);

        $response = $this->actingAs($pusdalops)->get(route('penilaian-risiko.index'));

        $response->assertOk();
        $response->assertSee('Penilaian Risiko');
        $response->assertSee($laporanKritis->kode_laporan);
        $response->assertSee('Desa Limpakuwus RT 02');
        $response->assertSee('Kritis');
        $response->assertSee('Darurat');
        $response->assertSee($laporanRendah->kode_laporan);
        $response->assertSee('Desa Karangsalam Blok C');
        $response->assertSee('Rendah');
    }

    /**
     * Filter tab triase berfungsi dengan baik (PBI-015).
     */
    public function test_filter_tab_triase_berfungsi_dengan_benar(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $belumDinilai = $this->buatLaporan(['lokasi' => 'Area Belum Dinilai', 'tingkat_risiko' => null]);
        $sudahDinilai = $this->buatLaporan(['lokasi' => 'Area Sudah Dinilai', 'tingkat_risiko' => 'Sedang', 'prioritas_penanganan' => 'Sedang']);

        // Tab belum dinilai
        $response = $this->actingAs($pusdalops)->get(route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']));
        $response->assertOk();
        $response->assertSee('Area Belum Dinilai');
        $response->assertDontSee('Area Sudah Dinilai');

        // Tab sudah dinilai
        $response2 = $this->actingAs($pusdalops)->get(route('penilaian-risiko.index', ['tab' => 'sudah_dinilai']));
        $response2->assertOk();
        $response2->assertSee('Area Sudah Dinilai');
        $response2->assertDontSee('Area Belum Dinilai');
    }

    /**
     * Hak akses: Non-pusdalops (misal damkar) dilarang mengakses form dan aksi penilaian risiko.
     */
    public function test_petugas_selain_pusdalops_dilarang_mengakses_form_penilaian(): void
    {
        $damkar = $this->buatUser('damkar');
        $laporan = $this->buatLaporan();

        $this->actingAs($damkar)->get(route('penilaian-risiko.create', $laporan->id))->assertForbidden();
        $this->actingAs($damkar)->post(route('penilaian-risiko.store', $laporan->id), [
            'tingkat_risiko' => 'Tinggi',
            'prioritas_penanganan' => 'Tinggi',
            'catatan_penilaian' => 'Uji coba akses ilegal.',
        ])->assertForbidden();
    }

    /**
     * Dashboard Pusdalops dapat diakses dan merender informasi statistik serta laporan terbaru.
     */
    public function test_pusdalops_dapat_mengakses_dashboard_dengan_lengkap(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan(['tingkat_risiko' => 'Tinggi']);

        $response = $this->actingAs($pusdalops)->get(route('pusdalops.dashboard'));

        $response->assertOk();
        $response->assertSee('Selamat Datang');
        $response->assertSee('STATUS KESIAPSIAGAAN');
        $response->assertSee('SIAGA KARHUTLA');
        $response->assertSee('TOTAL LAPORAN');
        $response->assertSee('MENUNGGU VERIFIKASI');
        $response->assertSee('BUTUH NILAI RISIKO');
        $response->assertSee('WILAYAH PANTAUAN');
        $response->assertSee('Kejadian Karhutla Terbaru');
        $response->assertSee($laporan->kode_laporan);
        $response->assertSee('Aksi Cepat Pusdalops');
    }
}
