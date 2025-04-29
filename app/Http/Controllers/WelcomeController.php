<?php
namespace App\Http\Controllers;

use App\Models\PenjualanModel;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        // Ambil 10 transaksi terbaru
        $riwayatTransaksi = PenjualanModel::with('details')
            ->latest('penjualan_tanggal')
            ->take(10)
            ->get();

        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'riwayatTransaksi' => $riwayatTransaksi
        ]);
    }
}