<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'penjualan_id' => $i,
                'user_id' => rand(1, 3), // Random user dari 1 sampai 3 (pastikan m_user sudah terisi)
                'pembeli' => 'Pembeli ' . $i,
                'penjualan_kode' => 'PNJ-' . str_pad($i, 4, '0', STR_PAD_LEFT), // Contoh: PNJ-0001
                'penjualan_tanggal' => Carbon::now()->subDays(rand(1, 30)), // Tanggal transaksi acak dalam 30 hari terakhir
            ];
        }
        DB::table('t_penjualan')->insert($data);
    }
}
