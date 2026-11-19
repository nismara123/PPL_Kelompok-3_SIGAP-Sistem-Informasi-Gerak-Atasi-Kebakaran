<?php

namespace Tests\Feature;

use App\Models\LaporanKarhutla;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanPusdalopsTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
        ]);
    }

    private function buatLaporan(array $override = []): LaporanKarhutla
    {
        return LaporanKarhutla::create(array_merge([
            'kode_laporan' => 'KARHUTLA-' . strtoupper(fake()->lexify('????????')),
            'lokasi' => 'Hutan Pinus Limpakuwus, Sumbang',
            'waktu_kejadian' => '2026-11-19 10:00:00',
            'deskripsi' => 'Terjadi kepulan asap tebal dan kobaran api di lereng bukit dekat perkebunan.',
            'foto' => null,
            'status' => 'Menunggu',
        ], $override));
    }

    /**
     * Acceptance Criteria 1:
     * Sistem menampilkan daftar semua laporan yang masuk.
     */
    public function test_sistem_menampilkan_daftar_seluruh_laporan_masuk(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan1 = $this->buatLaporan(['lokasi' => 'Baturraden Lereng Selatan']);
        $laporan2 = $this->buatLaporan(['lokasi' => 'Sumbang Kawasan Hutan']);

        $response = $this->actingAs($pusdalops)->get('/laporan');

        $response->assertOk();
        $response->assertSee('Daftar Laporan Karhutla');
        $response->assertSee($laporan1->kode_laporan);
        $response->assertSee('Baturraden Lereng Selatan');
        $response->assertSee($laporan2->kode_laporan);
        $response->assertSee('Sumbang Kawasan Hutan');
    }

    /**
     * Instruksi 1:
     * Endpoint API di backend untuk mengambil daftar laporan.
     */
    public function test_endpoint_api_mengambil_daftar_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan();

        $response = $this->actingAs($pusdalops)->getJson('/api/laporan');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonFragment([
            'kode_laporan' => $laporan->kode_laporan,
        ]);
    }

    /**
     * Acceptance Criteria 2:
     * Setiap laporan dapat dibuka untuk melihat rincian lengkap.
     */
    public function test_laporan_dapat_dibuka_untuk_melihat_rincian_lengkap(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan([
            'lokasi' => 'Desa Ketenger Baturraden',
            'deskripsi' => 'Api membakar semak belukar seluas 2 hektar.',
        ]);

        $response = $this->actingAs($pusdalops)->get("/laporan/{$laporan->id}");

        $response->assertOk();
        $response->assertSee('Detail Laporan Kejadian Karhutla');
        $response->assertSee($laporan->kode_laporan);
        $response->assertSee('Desa Ketenger Baturraden');
        $response->assertSee('Api membakar semak belukar seluas 2 hektar.');
    }

    /**
     * Instruksi 1:
     * Endpoint API di backend untuk mengambil detail laporan berdasarkan ID.
     */
    public function test_endpoint_api_mengambil_detail_laporan_berdasarkan_id(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan();

        $response = $this->actingAs($pusdalops)->getJson("/api/laporan/{$laporan->id}");

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $laporan->id,
                'kode_laporan' => $laporan->kode_laporan,
                'lokasi' => $laporan->lokasi,
            ],
        ]);
    }

    /**
     * Acceptance Criteria 3 & 4 & Instruksi 4 & 5:
     * Tersedia tombol Setujui dan Tolak di halaman detail laporan,
     * serta tombol terlihat dan dapat diklik oleh Petugas BPBD Pusdalops.
     */
    public function test_tombol_setujui_dan_tolak_terlihat_oleh_petugas_pusdalops(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan();

        $response = $this->actingAs($pusdalops)->get("/laporan/{$laporan->id}");

        $response->assertOk();
        $response->assertSee('Setujui');
        $response->assertSee('Tolak');
        $response->assertSee(route('laporan.setujui', $laporan->id));
        $response->assertSee(route('laporan.tolak', $laporan->id));
    }

    /**
     * Acceptance Criteria 4 & Instruksi 5:
     * Jika bukan Petugas BPBD Pusdalops (misal Damkar atau BPBD Divisi RR),
     * maka tombol Setujui dan Tolak disembunyikan di frontend.
     */
    public function test_tombol_setujui_dan_tolak_disembunyikan_untuk_bukan_pusdalops(): void
    {
        $damkar = $this->buatUser('damkar');
        $rr = $this->buatUser('rr');
        $laporan = $this->buatLaporan();

        // Uji untuk Petugas Damkar
        $responseDamkar = $this->actingAs($damkar)->get("/laporan/{$laporan->id}");
        $responseDamkar->assertOk();
        $responseDamkar->assertDontSee(route('laporan.setujui', $laporan->id));
        $responseDamkar->assertDontSee(route('laporan.tolak', $laporan->id));

        // Uji untuk Petugas BPBD Divisi RR
        $responseRR = $this->actingAs($rr)->get("/laporan/{$laporan->id}");
        $responseRR->assertOk();
        $responseRR->assertDontSee(route('laporan.setujui', $laporan->id));
        $responseRR->assertDontSee(route('laporan.tolak', $laporan->id));
    }

    /**
     * Acceptance Criteria 4:
     * Petugas BPBD Pusdalops dapat menyetujui laporan.
     */
    public function test_petugas_pusdalops_dapat_menyetujui_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan(['status' => 'Menunggu']);

        $response = $this->actingAs($pusdalops)->post("/laporan/{$laporan->id}/setujui");

        $response->assertRedirect("/laporan/{$laporan->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_karhutla', [
            'id' => $laporan->id,
            'status' => 'Disetujui',
        ]);
    }

    /**
     * Endpoint API: Petugas BPBD Pusdalops dapat menyetujui laporan via API JSON.
     */
    public function test_endpoint_api_menyetujui_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan(['status' => 'Menunggu']);

        $response = $this->actingAs($pusdalops)->postJson("/api/laporan/{$laporan->id}/setujui");

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Laporan berhasil disetujui.',
            'data' => [
                'id' => $laporan->id,
                'status' => 'Disetujui',
            ],
        ]);
    }

    /**
     * Acceptance Criteria 4:
     * Petugas BPBD Pusdalops dapat menolak laporan.
     */
    public function test_petugas_pusdalops_dapat_menolak_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan(['status' => 'Menunggu']);

        $response = $this->actingAs($pusdalops)->post("/laporan/{$laporan->id}/tolak");

        $response->assertRedirect("/laporan/{$laporan->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_karhutla', [
            'id' => $laporan->id,
            'status' => 'Ditolak',
        ]);
    }

    /**
     * Endpoint API: Petugas BPBD Pusdalops dapat menolak laporan via API JSON.
     */
    public function test_endpoint_api_menolak_laporan(): void
    {
        $pusdalops = $this->buatUser('pusdalops');
        $laporan = $this->buatLaporan(['status' => 'Menunggu']);

        $response = $this->actingAs($pusdalops)->postJson("/api/laporan/{$laporan->id}/tolak");

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Laporan berhasil ditolak.',
            'data' => [
                'id' => $laporan->id,
                'status' => 'Ditolak',
            ],
        ]);
    }

    /**
     * Acceptance Criteria 4 & Instruksi 5:
     * Pengguna yang bukan Petugas BPBD Pusdalops dilarang (403 Forbidden)
     * untuk menyetujui atau menolak laporan melalui endpoint backend.
     */
    public function test_pengguna_non_pusdalops_dilarang_menyetujui_atau_menolak_laporan(): void
    {
        $damkar = $this->buatUser('damkar');
        $rr = $this->buatUser('rr');
        $laporan = $this->buatLaporan(['status' => 'Menunggu']);

        // Damkar mencoba menyetujui langsung
        $res1 = $this->actingAs($damkar)->post("/laporan/{$laporan->id}/setujui");
        $res1->assertForbidden();

        // Damkar mencoba menolak langsung
        $res2 = $this->actingAs($damkar)->post("/laporan/{$laporan->id}/tolak");
        $res2->assertForbidden();

        // RR mencoba menyetujui langsung
        $res3 = $this->actingAs($rr)->post("/laporan/{$laporan->id}/setujui");
        $res3->assertForbidden();

        // RR mencoba menolak langsung
        $res4 = $this->actingAs($rr)->post("/laporan/{$laporan->id}/tolak");
        $res4->assertForbidden();

        // Status di database harus tetap 'Menunggu'
        $this->assertDatabaseHas('laporan_karhutla', [
            'id' => $laporan->id,
            'status' => 'Menunggu',
        ]);
    }

    /**
     * Keamanan Akses: Tamu (unauthenticated) diarahkan ke halaman login.
     */
    public function test_tamu_diarahkan_ke_login_saat_mengakses_daftar_atau_detail(): void
    {
        $laporan = $this->buatLaporan();

        $this->get('/laporan')->assertRedirect('/login');
        $this->get("/laporan/{$laporan->id}")->assertRedirect('/login');
        $this->post("/laporan/{$laporan->id}/setujui")->assertRedirect('/login');
        $this->post("/laporan/{$laporan->id}/tolak")->assertRedirect('/login');
    }
}
