<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WilayahKarhutlaSeeder extends Seeder
{
    public function run(): void
    {
        $url = 'https://geoportal.pertanian.go.id/arcgis/rest/services/Hosted/Batas_Administrasi_Desa/FeatureServer/0/query';

        $offset = 0;
        $limit = 50;
        $jumlahBerhasil = 0;
        $jumlahDilewati = 0;

        $this->command->info('Memulai pengambilan data wilayah Banyumas...');

        do {
            $this->command->info(
                "Mengambil data mulai baris {$offset}..."
            );

            try {
                $response = Http::connectTimeout(15)
                    ->timeout(120)
                    ->get($url, [
                        'where' => "wadmkk='Banyumas' AND wadmpr='Jawa Tengah'",
                        'outFields' => 'kdpkab,kdcpum,kdepum,wadmkk,wadmkc,wadmkd,wadmpr',
                        'returnGeometry' => 'true',
                        'outSR' => 4326,
                        'f' => 'geojson',
                        'resultOffset' => $offset,
                        'resultRecordCount' => $limit,
                    ]);

                if (!$response->successful()) {
                    throw new \RuntimeException(
                        'HTTP Error: ' . $response->status()
                    );
                }

                $geojson = $response->json();

                if (isset($geojson['error'])) {
                    throw new \RuntimeException(
                        json_encode($geojson['error'])
                    );
                }

            } catch (\Throwable $e) {
                $this->command->error(
                    'Gagal mengambil data: ' . $e->getMessage()
                );

                return;
            }

            $features = $geojson['features'] ?? [];

            if (empty($features)) {
                break;
            }

            DB::transaction(function () use (
                $features,
                &$jumlahBerhasil,
                &$jumlahDilewati
            ) {
                foreach ($features as $feature) {
                    $p = $feature['properties'] ?? [];
                    $geometry = $feature['geometry'] ?? null;

                    $kodeKabupaten = trim(
                        (string) ($p['kdpkab'] ?? '3302')
                    );

                    $kodeKecamatan = trim(
                        (string) ($p['kdcpum'] ?? '')
                    );

                    $kodeDesa = trim(
                        (string) ($p['kdepum'] ?? '')
                    );

                    $namaKabupaten = trim(
                        (string) ($p['wadmkk'] ?? 'Banyumas')
                    );

                    $namaKecamatan = trim(
                        (string) ($p['wadmkc'] ?? '')
                    );

                    $namaDesa = trim(
                        (string) ($p['wadmkd'] ?? '')
                    );

                    if (
                        $kodeKecamatan === '' ||
                        $kodeDesa === '' ||
                        $namaKecamatan === '' ||
                        $namaDesa === ''
                    ) {
                        $jumlahDilewati++;
                        continue;
                    }

                    $koordinat = $this->hitungCentroid($geometry);

                    DB::table('wilayah_karhutla')->updateOrInsert(
                        [
                            'kode_wilayah' => $kodeDesa,
                        ],
                        [
                            'kode_kabupaten' => $kodeKabupaten,
                            'kabupaten' => $namaKabupaten,

                            'kode_kecamatan' => $kodeKecamatan,
                            'kecamatan' => $namaKecamatan,

                            'kode_desa' => $kodeDesa,
                            'desa_kelurahan' => $namaDesa,

                            'latitude' => $koordinat['latitude'],
                            'longitude' => $koordinat['longitude'],

                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    $jumlahBerhasil++;
                }
            });

            $offset += count($features);

            $this->command->info(
                "Data tersimpan sementara: {$jumlahBerhasil}"
            );

        } while (count($features) === $limit);

        $this->command->newLine();

        $this->command->info('====================================');
        $this->command->info('SEEDER WILAYAH BANYUMAS SELESAI');
        $this->command->info("Berhasil diproses : {$jumlahBerhasil}");
        $this->command->info("Dilewati          : {$jumlahDilewati}");
        $this->command->info('====================================');
    }

    /**
     * Menghitung titik tengah polygon GeoJSON.
     */
    private function hitungCentroid(?array $geometry): array
    {
        if (
            !$geometry ||
            !isset($geometry['coordinates'])
        ) {
            return [
                'latitude' => null,
                'longitude' => null,
            ];
        }

        $type = $geometry['type'];
        $coordinates = $geometry['coordinates'];

        if ($type === 'Polygon') {
            $polygons = [$coordinates];
        } elseif ($type === 'MultiPolygon') {
            $polygons = $coordinates;
        } else {
            return [
                'latitude' => null,
                'longitude' => null,
            ];
        }

        $totalX = 0;
        $totalY = 0;
        $totalArea = 0;

        foreach ($polygons as $polygon) {
            foreach ($polygon as $ringIndex => $ring) {
                $n = count($ring);

                if ($n < 4) {
                    continue;
                }

                $crossSum = 0;
                $cx = 0;
                $cy = 0;

                for ($i = 0; $i < $n - 1; $i++) {
                    $x1 = $ring[$i][0];
                    $y1 = $ring[$i][1];

                    $x2 = $ring[$i + 1][0];
                    $y2 = $ring[$i + 1][1];

                    $cross = ($x1 * $y2) - ($x2 * $y1);

                    $crossSum += $cross;
                    $cx += ($x1 + $x2) * $cross;
                    $cy += ($y1 + $y2) * $cross;
                }

                if (abs($crossSum) < 0.0000000001) {
                    continue;
                }

                $area = abs($crossSum / 2);

                $ringCx = $cx / (3 * $crossSum);
                $ringCy = $cy / (3 * $crossSum);

                $weight = $ringIndex === 0
                    ? $area
                    : -$area;

                $totalX += $ringCx * $weight;
                $totalY += $ringCy * $weight;
                $totalArea += $weight;
            }
        }

        if (abs($totalArea) < 0.0000000001) {
            return [
                'latitude' => null,
                'longitude' => null,
            ];
        }

        return [
            'latitude' => round($totalY / $totalArea, 7),
            'longitude' => round($totalX / $totalArea, 7),
        ];
    }
}