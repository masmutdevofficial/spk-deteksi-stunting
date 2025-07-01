<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataBayi;

class DataBayiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Bayi A', 'umur' => '3 Tahun - 11 Bulan - 8 Hari', 'jenis_kelamin' => 2, 'berat' => 11.7, 'tinggi' => 93.5, 'lila' => 14, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi B', 'umur' => '4 Tahun - 5 Bulan - 15 Hari', 'jenis_kelamin' => 2, 'berat' => 11.2, 'tinggi' => 92, 'lila' => 13, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi C', 'umur' => '2 Tahun - 5 Bulan - 6 Hari', 'jenis_kelamin' => 1, 'berat' => 9.7, 'tinggi' => 81, 'lila' => 12, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi D', 'umur' => '2 Tahun - 8 Bulan - 7 Hari', 'jenis_kelamin' => 2, 'berat' => 10.5, 'tinggi' => 80.4, 'lila' => 15, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi E', 'umur' => '2 Tahun - 0 Bulan - 29 Hari', 'jenis_kelamin' => 1, 'berat' => 8.2, 'tinggi' => 76, 'lila' => 13, 'bb_tb' => 'Gizi Kurang'],
            ['nama' => 'Bayi F', 'umur' => '2 Tahun - 4 Bulan - 15 Hari', 'jenis_kelamin' => 2, 'berat' => 7.7, 'tinggi' => 76, 'lila' => 14, 'bb_tb' => 'Gizi Kurang'],
            ['nama' => 'Bayi G', 'umur' => '3 Tahun - 9 Bulan - 21 Hari', 'jenis_kelamin' => 2, 'berat' => 10.4, 'tinggi' => 88, 'lila' => 13.4, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi H', 'umur' => '2 Tahun - 11 Bulan - 9 Hari', 'jenis_kelamin' => 1, 'berat' => 13.1, 'tinggi' => 86.5, 'lila' => 14, 'bb_tb' => 'Gizi Lebih'],
            ['nama' => 'Bayi I', 'umur' => '1 Tahun - 11 Bulan - 22 Hari', 'jenis_kelamin' => 1, 'berat' => 12.5, 'tinggi' => 80.2, 'lila' => 16, 'bb_tb' => 'Gizi Lebih'],
            ['nama' => 'Bayi J', 'umur' => '2 Tahun - 1 Bulan - 5 Hari', 'jenis_kelamin' => 2, 'berat' => 10.4, 'tinggi' => 79, 'lila' => 15, 'bb_tb' => 'Gizi Baik'],
        ];

        foreach ($data as $item) {
            DataBayi::create([
                'id_user' => 2,
                'nama' => $item['nama'],
                'umur' => $item['umur'],
                'jenis_kelamin' => $item['jenis_kelamin'],
                'berat' => $item['berat'],
                'tinggi' => $item['tinggi'],
                'lila' => $item['lila'],
                'bb_tb' => $item['bb_tb'],
            ]);
        }
    }
}
