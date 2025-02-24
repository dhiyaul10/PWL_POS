<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'stok_id' => $i,
                'supplier_id' => ceil($i / 5), // Setiap 5 barang dari 1 supplier
                'barang_id' => $i,
                'user_id' => 1, // Misal semua stok dimasukkan oleh user Admin (user_id = 1)
                'stok_tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'stok_jumlah' => rand(10, 100), // Menggunakan stok_jumlah sesuai migrasi
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
