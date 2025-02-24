<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_id' => 1, 'supplier_kode' => 'ELJ', 'supplier_nama' => 'PT. Elektronik Jaya', 'supplier_alamat' => 'Jakarta'],
            ['supplier_id' => 2, 'supplier_kode' => 'MST', 'supplier_nama' => 'CV. Makanan Sehat', 'supplier_alamat' => 'Bandung'],
            ['supplier_id' => 3, 'supplier_kode' => 'FUI', 'supplier_nama' => 'UD. Furniture Indah', 'supplier_alamat' => 'Surabaya'],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
