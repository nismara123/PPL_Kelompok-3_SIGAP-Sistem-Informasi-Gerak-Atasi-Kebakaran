<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahKarhutlaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode_wilayah' => 'WIL-001',
                'kode_kecamatan' => '1',
                'kecamatan' => 'Kalibagor, Patikraja',
                'kode_desa' => '1',
                'desa_kelurahan' => 'Kaliori, Sidabowa',
                'latitude' => -7.5023869,
                'longitude' => 109.2971420,
            ],
            [
                'kode_wilayah' => 'WIL-002',
                'kode_kecamatan' => '2',
                'kecamatan' => 'Jatilawang, Kebasen',
                'kode_desa' => '2',
                'desa_kelurahan' => 'Kalisalak',
                'latitude' => -7.5367643,
                'longitude' => 109.2181778,
            ],
            [
                'kode_wilayah' => 'WIL-003',
                'kode_kecamatan' => '3',
                'kecamatan' => 'Purwokerto Selatan',
                'kode_desa' => '3',
                'desa_kelurahan' => 'Berkoh',
                'latitude' => -7.4376667,
                'longitude' => 109.2606211,
            ],
            [
                'kode_wilayah' => 'WIL-004',
                'kode_kecamatan' => '4',
                'kecamatan' => 'Wangon, Patikraja',
                'kode_desa' => '4',
                'desa_kelurahan' => 'Windunegara, Notog',
                'latitude' => -7.4613688,
                'longitude' => 109.0705490,
            ],
            [
                'kode_wilayah' => 'WIL-005',
                'kode_kecamatan' => '5',
                'kecamatan' => 'Patikraja, Ajibarang, Wangon',
                'kode_desa' => '5',
                'desa_kelurahan' => 'Kedungrandu, Tipar Kidul, Windunegara',
                'latitude' => -7.4743895,
                'longitude' => 109.2332840,
            ],
            [
                'kode_wilayah' => 'WIL-006',
                'kode_kecamatan' => '1',
                'kecamatan' => 'Kalibagor, Patikraja',
                'kode_desa' => '6',
                'desa_kelurahan' => 'Kalibagor, Karanganyar',
                'latitude' => -7.4736236,
                'longitude' => 109.2980862,
            ],
            [
                'kode_wilayah' => 'WIL-007',
                'kode_kecamatan' => '6',
                'kecamatan' => 'Purwojati',
                'kode_desa' => '7',
                'desa_kelurahan' => 'Kaliwangi',
                'latitude' => -7.4690280,
                'longitude' => 109.0961266,
            ],
            [
                'kode_wilayah' => 'WIL-008',
                'kode_kecamatan' => '7',
                'kecamatan' => 'Ajibarang',
                'kode_desa' => '8',
                'desa_kelurahan' => 'Sawangan',
                'latitude' => -7.4315814,
                'longitude' => 109.0971565,
            ],
            [
                'kode_wilayah' => 'WIL-009',
                'kode_kecamatan' => '8',
                'kecamatan' => 'Patikraja',
                'kode_desa' => '9',
                'desa_kelurahan' => 'Karanganyar',
                'latitude' => -7.4870694,
                'longitude' => 109.2102814,
            ],
            [
                'kode_wilayah' => 'WIL-010',
                'kode_kecamatan' => '6',
                'kecamatan' => 'Purwojati',
                'kode_desa' => '7',
                'desa_kelurahan' => 'Kaliwangi',
                'latitude' => -7.4697089,
                'longitude' => 109.1011047,
            ],
        ];

        foreach ($data as $item) {
            DB::table('wilayah_karhutla')->updateOrInsert(
                ['kode_wilayah' => $item['kode_wilayah']],
                array_merge($item, [
                    'kode_kabupaten' => '3302',
                    'kabupaten' => 'Banyumas',
                    'updated_at' => now(),
                ]) + ['created_at' => now()]
            );
        }
    }
}
