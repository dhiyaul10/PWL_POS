{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $page->title }}</h1>
    <form action="{{ url('/transaksi/'.$transaksi->penjualan_id.'/update') }}" method="POST">
        @csrf
        <!-- Contoh field: Tanggal Transaksi -->
        <div class="form-group">
            <label for="penjualan_tanggal">Tanggal Transaksi</label>
            <input type="date" nama="penjualan_tanggal" id="penjualan_tanggal" class="form-control" value="{{ $transaksi->penjualan_tanggal }}">
        </div>
        <!-- Tambahkan field lain sesuai kebutuhan, misalnya nama pelanggan, jumlah, dll -->
        <button type="submit" class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection --}}