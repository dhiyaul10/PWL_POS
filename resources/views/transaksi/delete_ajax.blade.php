@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $page->title }}</h1>
    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
    <p><strong>ID Transaksi:</strong> {{ $transaksi->penjualan_id }}</p>
    <!-- Tampilkan informasi transaksi lain jika perlu -->
    <form action="{{ url('/transaksi/'.$transaksi->penjualan_id.'/destroy') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Hapus</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </form>
</div>
@endsection