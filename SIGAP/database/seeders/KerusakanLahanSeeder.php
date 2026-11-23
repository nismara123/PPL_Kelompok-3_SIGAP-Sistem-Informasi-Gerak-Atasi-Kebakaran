<?php

namespace Database\Seeders;

use App\Models\KerusakanLahan;
use App\Models\User;
use App\Models\WilayahKarhutla;
use Illuminate\Database\Seeder;

// Data contoh untuk demo sprint. Jalankan: php artisan db:seed --class=KerusakanLahanSeeder
class KerusakanLahanSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = WilayahKarhutla::orderBy('id')->take(4)->get();

        if ($wilayah->isEmpty()) {
            $this->command->warn('Tabel wilayah_karhutla masih kosong. Tambahkan data wilayah (FSI-01) dulu.');
            return;
        }

        $userId = User::where('role', 'rr')->value('id');

        $contoh = [
            ['Dusun Karangsalam, blok utara', 'Hutan', 12.50, '2026-09-14', 'Vegetasi pinus di lereng terbakar.'],
            ['Area ladang dekat sungai', 'Semak belukar', 4.20, '2026-09-20', 'Semak kering terbakar merambat dari ladang.'],
            ['Kebun pinus rakyat', 'Perkebunan', 7.80, '2026-10-02', null],
            ['Petak sawah tadah hujan', 'Lahan pertanian', 2.10, '2026-10-11', null],
        ];

        foreach ($contoh as $i => [$lokasi, $jenis, $luas, $tgl, $ket]) {
            KerusakanLahan::create([
                'wilayah_id' => $wilayah[$i % $wilayah->count()]->id,
                'lokasi' => $lokasi,
                'jenis_kerusakan' => $jenis,
                'luas_ha' => $luas,
                'tanggal_pencatatan' => $tgl,
                'keterangan' => $ket,
                'user_id' => $userId,
            ]);
        }
    }
}
