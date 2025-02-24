<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'FOD', 'kategori_nama' => 'Makanan & Minuman'],
            ['kategori_id' => 3, 'kategori_kode' => 'FRN', 'kategori_nama' => 'Furniture'],
            ['kategori_id' => 4, 'kategori_kode' => 'CLT', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 5, 'kategori_kode' => 'SPT', 'kategori_nama' => 'Olahraga'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
