<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Barang untuk Kategori Elektronik
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'ELK001', 'barang_nama' => 'TV LED', 'harga_beli' => 2500000, 'harga_jual' => 3000000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'ELK002', 'barang_nama' => 'Kulkas', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'ELK003', 'barang_nama' => 'Mesin Cuci', 'harga_beli' => 1800000, 'harga_jual' => 2000000],
            ['barang_id' => 4, 'kategori_id' => 1, 'barang_kode' => 'ELK004', 'barang_nama' => 'AC', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['barang_id' => 5, 'kategori_id' => 1, 'barang_kode' => 'ELK005', 'barang_nama' => 'Kipas Angin', 'harga_beli' => 200000, 'harga_jual' => 300000],
            
            // Barang untuk Kategori Makanan & Minuman
            ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'FOD001', 'barang_nama' => 'Snack', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 7, 'kategori_id' => 2, 'barang_kode' => 'FOD002', 'barang_nama' => 'Minuman Soda', 'harga_beli' => 6000, 'harga_jual' => 8000],
            ['barang_id' => 8, 'kategori_id' => 2, 'barang_kode' => 'FOD003', 'barang_nama' => 'Coklat', 'harga_beli' => 10000, 'harga_jual' => 12000],
            ['barang_id' => 9, 'kategori_id' => 2, 'barang_kode' => 'FOD004', 'barang_nama' => 'Biskuit', 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 10, 'kategori_id' => 2, 'barang_kode' => 'FOD005', 'barang_nama' => 'Jus Buah', 'harga_beli' => 10000, 'harga_jual' => 12000],

            // Barang untuk Kategori Furniture
            ['barang_id' => 11, 'kategori_id' => 3, 'barang_kode' => 'FRN001', 'barang_nama' => 'Meja Belajar', 'harga_beli' => 400000, 'harga_jual' => 450000],
            ['barang_id' => 12, 'kategori_id' => 3, 'barang_kode' => 'FRN002', 'barang_nama' => 'Kursi Kantor', 'harga_beli' => 450000, 'harga_jual' => 500000],
            ['barang_id' => 13, 'kategori_id' => 3, 'barang_kode' => 'FRN003', 'barang_nama' => 'Lemari Pakaian', 'harga_beli' => 1200000, 'harga_jual' => 1500000],
            ['barang_id' => 14, 'kategori_id' => 3, 'barang_kode' => 'FRN004', 'barang_nama' => 'Sofa', 'harga_beli' => 1800000, 'harga_jual' => 2000000],
            ['barang_id' => 15, 'kategori_id' => 3, 'barang_kode' => 'FRN005', 'barang_nama' => 'Rak Buku', 'harga_beli' => 200000, 'harga_jual' => 250000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
