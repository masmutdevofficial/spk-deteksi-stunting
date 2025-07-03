<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataBayi;
use Carbon\Carbon;

class DataBayiSeeder extends Seeder
{
    public function run(): void
    {
        $tanggal_lahir_list = [
            '09/03/2021',
            '29/08/2020',
            '03/09/2022',
            '03/06/2022',
            '20/06/2020',
            '09/01/2023',
            '01/10/2022',
            '24/04/2021',
            '23/10/2022',
            '04/01/2023',
        ];

        $bayi_base_data = [
            ['nama' => 'Bayi A', 'jenis_kelamin' => 2, 'berat' => 11.7, 'tinggi' => 93.5, 'lila' => 14, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi B', 'jenis_kelamin' => 2, 'berat' => 11.2, 'tinggi' => 92, 'lila' => 13, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi C', 'jenis_kelamin' => 1, 'berat' => 9.7, 'tinggi' => 81, 'lila' => 12, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi D', 'jenis_kelamin' => 2, 'berat' => 10.5, 'tinggi' => 80.4, 'lila' => 15, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi E', 'jenis_kelamin' => 1, 'berat' => 8.2, 'tinggi' => 76, 'lila' => 13, 'bb_tb' => 'Gizi Kurang'],
            ['nama' => 'Bayi F', 'jenis_kelamin' => 2, 'berat' => 7.7, 'tinggi' => 76, 'lila' => 14, 'bb_tb' => 'Gizi Kurang'],
            ['nama' => 'Bayi G', 'jenis_kelamin' => 2, 'berat' => 10.4, 'tinggi' => 88, 'lila' => 13.4, 'bb_tb' => 'Gizi Baik'],
            ['nama' => 'Bayi H', 'jenis_kelamin' => 1, 'berat' => 13.1, 'tinggi' => 86.5, 'lila' => 14, 'bb_tb' => 'Gizi Lebih'],
            ['nama' => 'Bayi I', 'jenis_kelamin' => 1, 'berat' => 12.5, 'tinggi' => 80.2, 'lila' => 16, 'bb_tb' => 'Gizi Lebih'],
            ['nama' => 'Bayi J', 'jenis_kelamin' => 2, 'berat' => 10.4, 'tinggi' => 79, 'lila' => 15, 'bb_tb' => 'Gizi Baik'],
        ];

        foreach ($bayi_base_data as $i => $bayi) {
            $tgl_lahir = Carbon::createFromFormat('d/m/Y', $tanggal_lahir_list[$i]);
            $umur_obj = $tgl_lahir->diff(Carbon::now());

            $umur = "{$umur_obj->y} Tahun - {$umur_obj->m} Bulan - {$umur_obj->d} Hari";

            DataBayi::create([
                'id_user' => 2,
                'nama' => $bayi['nama'],
                'umur' => $umur,
                'tgl_lahir' => $tgl_lahir->toDateString(),
                'jenis_kelamin' => $bayi['jenis_kelamin'],
                'berat' => $bayi['berat'],
                'tinggi' => $bayi['tinggi'],
                'lila' => $bayi['lila'],
                'bb_tb' => $bayi['bb_tb'],
                'tgl_penimbangan' => Carbon::now()->toDateString(),
            ]);
        }
    }
}
