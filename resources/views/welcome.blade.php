@extends('layouts.template')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo, apakabar!!!</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        Selamat datang semua, ini adalah halaman utama dari aplikasi ini.
    </div>
    <div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Transaksi Terbaru</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Pembeli</th>
                    <th>Jumlah Item</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatTransaksi as $trx)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($trx->penjualan_tanggal)->format('d-m-Y H:i') }}</td>
                        <td>{{ $trx->penjualan_kode }}</td>
                        <td>{{ $trx->pembeli }}</td>
                        <td>{{ $trx->details->sum('jumlah') }}</td>
                        <td>
                            Rp{{ number_format($trx->details->sum(fn($d) => $d->jumlah * $d->harga), 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection