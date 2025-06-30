<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tenaga Medis',
                'username' => 'tenagamedis',
                'password' => Hash::make('tenagamedis'),
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
