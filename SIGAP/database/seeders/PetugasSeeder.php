<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = [
            [
                'name' => 'Petugas Pusdalops',
                'email' => 'pusdalops@sigap.id',
                'password' => 'Pusdalops123',
                'role' => 'pusdalops',
            ],
            [
                'name' => 'Petugas Damkar',
                'email' => 'damkar@sigap.id',
                'password' => 'Damkar123',
                'role' => 'damkar',
            ],
            [
                'name' => 'Petugas Divisi RR',
                'email' => 'rr@sigap.id',
                'password' => 'RR123456',
                'role' => 'rr',
            ],
        ];

        foreach ($petugas as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]
            );
        }
    }

}