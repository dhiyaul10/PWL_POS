@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data transaksi tidak ditemukan.
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Kode Transaksi</th>
                        <td>{{ $transaksi->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Pembeli</th>
                        <td>{{ $transaksi->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($transaksi->penjualan_tanggal)->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>

                <h6 class="mt-4">Detail Barang:</h6>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                            <td>{{ number_format($detail->harga) }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>{{ number_format($detail->harga * $detail->jumlah) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty