@extends('layouts.template')
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools"></div>
         </div>
         <div class="card-body">
             @if (!$penjualan)
                 <div class="alert alert-danger alert-dismissible">
                     <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                     Data yang Anda cari tidak ditemukan.
                 </div>
                 <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
             @else
                 <form method="POST" action="{{ url('/penjualan/' . $penjualan->penjualan_id) }}" class="form-horizontal">
                     @csrf
                     {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang membutuhkan method PUT -->
 
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">ID Penjualan</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="penjualan_id" name="penjualan_id"
                                 value="{{ old('penjualan_id', $penjualan->penjualan_id) }}" required>
                             @error('penjualan_id')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">user id</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="user_id" name="user_id"
                                 value="{{ old('user_id', $penjualan->user_id) }}" required>
                             @error('user_id')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">ID Barang</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="barang_id" name="barang_id"
                                 value="{{ old('barang_id', $penjualan->barang_id) }}" required>
                             @error('barang_id')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">Harga</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="harga" name="harga"
                                 value="{{ old('harga', $penjualan->harga) }}" required>
                             @error('harga')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">Jumlah</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="jumlah" name="jumlah"
                                 value="{{ old('jumlah', $penjualan->jumlah) }}" required>
                             @error('jumlah')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label"></label>
                         <div class="col-11">
                             <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                             <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                         </div>
                     </div>
                 </form>
             @endif
         </div>
     </div>
 @endsection
 @push('css')
 @endpush
 @push('js')
 @endpush