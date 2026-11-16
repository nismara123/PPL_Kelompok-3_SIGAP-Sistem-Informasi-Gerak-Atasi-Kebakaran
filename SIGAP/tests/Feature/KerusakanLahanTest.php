<?php

namespace Tests\Feature;

use App\Models\KerusakanLahan;
use App\Models\User;
use App\Models\WilayahKarhutla;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KerusakanLahanTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function wilayah(): WilayahKarhutla
    {
        return WilayahKarhutla::create([
            'kode_wilayah' => 'WIL-T' . random_int(1000, 9999), 'kode_kabupaten' => '33', 'kabupaten' => 'Banyumas',
            'kode_kecamatan' => '01', 'kecamatan' => 'Baturraden', 'kode_desa' => '001', 'desa_kelurahan' => 'Karangsalam',
        ]);
    }

    private function data(array $o = []): array
    {
        return array_merge([
            'wilayah_id' => $this->wilayah()->id, 'lokasi' => 'Dusun Uji', 'jenis_kerusakan' => 'Hutan',
            'luas_ha' => 3.5, 'tanggal_pencatatan' => '2026-11-14', 'keterangan' => 'tes',
        ], $o);
    }

    public function test_rr_dapat_melihat_semua_halaman(): void
    {
        $rr = $this->user('rr');
        $item = KerusakanLahan::create($this->data());

        $this->actingAs($rr)->get('/kerusakan-lahan')->assertOk()->assertSee('fsi02.css')->assertSee('Dusun Uji')->assertSee('Total data tercatat');
        $this->actingAs($rr)->get('/kerusakan-lahan/create')->assertOk()->assertSee('Kondisi Kerusakan');
        $this->actingAs($rr)->get("/kerusakan-lahan/{$item->id}")->assertOk()->assertSee('Luas terdampak');
        $this->actingAs($rr)->get("/kerusakan-lahan/{$item->id}/edit")->assertOk();
        $this->actingAs($rr)->get('/kerusakan-lahan?q=zzz')->assertOk()->assertSee('Data kerusakan lahan belum tersedia.');
        $this->actingAs($rr)->get('/kerusakan-lahan?kecamatan=Baturraden')->assertOk()->assertSee('Dusun Uji');
    }

    public function test_tambah_validasi_dan_simpan(): void
    {
        $rr = $this->user('rr');
        $this->actingAs($rr)->post('/kerusakan-lahan', ['luas_ha' => 0])
            ->assertSessionHasErrors(['wilayah_id', 'lokasi', 'jenis_kerusakan', 'luas_ha', 'tanggal_pencatatan']);

        $this->actingAs($rr)->post('/kerusakan-lahan', $this->data())->assertRedirect('/kerusakan-lahan');
        $this->assertDatabaseHas('kerusakan_lahan', ['lokasi' => 'Dusun Uji', 'user_id' => $rr->id]);
    }

    public function test_ubah_dan_hapus(): void
    {
        $rr = $this->user('rr');
        $item = KerusakanLahan::create($this->data());

        $this->actingAs($rr)->put("/kerusakan-lahan/{$item->id}", $this->data(['lokasi' => 'Diubah', 'wilayah_id' => $item->wilayah_id]))
            ->assertRedirect('/kerusakan-lahan');
        $this->assertDatabaseHas('kerusakan_lahan', ['id' => $item->id, 'lokasi' => 'Diubah']);

        $this->actingAs($rr)->delete("/kerusakan-lahan/{$item->id}")->assertRedirect('/kerusakan-lahan');
        $this->assertDatabaseMissing('kerusakan_lahan', ['id' => $item->id]);
    }

    public function test_hak_akses_role(): void
    {
        $item = KerusakanLahan::create($this->data());

        $pd = $this->user('pusdalops');
        $this->actingAs($pd)->get('/kerusakan-lahan')->assertOk();
        $this->actingAs($pd)->get("/kerusakan-lahan/{$item->id}")->assertOk();
        $this->actingAs($pd)->get('/kerusakan-lahan/create')->assertForbidden();
        $this->actingAs($pd)->delete("/kerusakan-lahan/{$item->id}")->assertForbidden();

        $dk = $this->user('damkar');
        $this->actingAs($dk)->get('/kerusakan-lahan')->assertForbidden();
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/kerusakan-lahan')->assertRedirect('/login');
    }
}
