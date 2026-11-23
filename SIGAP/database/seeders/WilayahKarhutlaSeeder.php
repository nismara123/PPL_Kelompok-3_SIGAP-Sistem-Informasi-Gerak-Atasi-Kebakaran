<?php

namespace Database\Seeders;

use App\Models\WilayahKarhutla;
use Illuminate\Database\Seeder;

class WilayahKarhutlaSeeder extends Seeder
{
    public function run(): void
    {
        $wilayahs = [
            [
                'kode_wilayah' => 'WIL-BMS-BTR01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330219',
                'kecamatan' => 'Kec. Baturraden',
                'kode_desa' => '3302192004',
                'desa_kelurahan' => 'Desa Limpakuwus',
                'latitude' => -7.3114000,
                'longitude' => 109.2421000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-SMP01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330206',
                'kecamatan' => 'Kec. Sumpiuh',
                'kode_desa' => '3302062007',
                'desa_kelurahan' => 'Desa Karanggedang',
                'latitude' => -7.5621000,
                'longitude' => 109.2980000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-KLW01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330214',
                'kecamatan' => 'Kec. Karanglewas',
                'kode_desa' => '3302142008',
                'desa_kelurahan' => 'Desa Karanglewas Kidul',
                'latitude' => -7.4198000,
                'longitude' => 109.1885000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-LMB01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330201',
                'kecamatan' => 'Kec. Lumbir',
                'kode_desa' => '3302012003',
                'desa_kelurahan' => 'Desa Dermaji',
                'latitude' => -7.4652000,
                'longitude' => 108.9520000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-PKC01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330211',
                'kecamatan' => 'Kec. Pekuncen',
                'kode_desa' => '3302112005',
                'desa_kelurahan' => 'Desa Cikembulan',
                'latitude' => -7.3820000,
                'longitude' => 109.0845000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-SMG01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330220',
                'kecamatan' => 'Kec. Sumbang',
                'kode_desa' => '3302202011',
                'desa_kelurahan' => 'Desa Kotayasa',
                'latitude' => -7.3325000,
                'longitude' => 109.2610000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-KDB01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330218',
                'kecamatan' => 'Kec. Kedungbanteng',
                'kode_desa' => '3302182009',
                'desa_kelurahan' => 'Desa Melung',
                'latitude' => -7.3240000,
                'longitude' => 109.2150000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-GML01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330210',
                'kecamatan' => 'Kec. Gumelar',
                'kode_desa' => '3302102002',
                'desa_kelurahan' => 'Desa Cihonje',
                'latitude' => -7.3685000,
                'longitude' => 108.9890000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-TBK01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330207',
                'kecamatan' => 'Kec. Tambak',
                'kode_desa' => '3302072004',
                'desa_kelurahan' => 'Desa Kuntili',
                'latitude' => -7.5850000,
                'longitude' => 109.3420000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-SMG02',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330208',
                'kecamatan' => 'Kec. Somagede',
                'kode_desa' => '3302082006',
                'desa_kelurahan' => 'Desa Klinting',
                'latitude' => -7.5210000,
                'longitude' => 109.3140000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-CLK01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330217',
                'kecamatan' => 'Kec. Cilongok',
                'kode_desa' => '3302172014',
                'desa_kelurahan' => 'Desa Sambirata',
                'latitude' => -7.3450000,
                'longitude' => 109.1620000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-AJB01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330212',
                'kecamatan' => 'Kec. Ajibarang',
                'kode_desa' => '3302122008',
                'desa_kelurahan' => 'Desa Sawangan',
                'latitude' => -7.4080000,
                'longitude' => 109.0720000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-WGN01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330202',
                'kecamatan' => 'Kec. Wangon',
                'kode_desa' => '3302022005',
                'desa_kelurahan' => 'Desa Windunegara',
                'latitude' => -7.5120000,
                'longitude' => 109.0530000,
            ],
            [
                'kode_wilayah' => 'WIL-BMS-PWJ01',
                'kode_kabupaten' => '3302',
                'kabupaten' => 'Banyumas',
                'kode_kecamatan' => '330213',
                'kecamatan' => 'Kec. Purwojati',
                'kode_desa' => '3302132002',
                'desa_kelurahan' => 'Desa Karangmangu',
                'latitude' => -7.4980000,
                'longitude' => 109.1120000,
            ],
        ];

        foreach ($wilayahs as $item) {
            WilayahKarhutla::updateOrCreate(
                ['kode_wilayah' => $item['kode_wilayah']],
                $item
            );
        }
    }
}
