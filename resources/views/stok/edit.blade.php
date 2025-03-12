@extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools"></div>
         </div>
         <div class="card-body">
             @if (!$stok)
                 <div class="alert alert-danger alert-dismissible">
                     <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                     Data yang Anda cari tidak ditemukan.
                 </div>
                 <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
             @else
                 <form method="POST" action="{{ url('/stok/' . $stok->stok_id) }}" class="form-horizontal">
                     @csrf
                     {!! method_field('PUT') !!} 
 
 
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">barang id</label>
                         <div class="col-11">
                             <input type="text" class="form-control" id="barang_id" name="barang_id"
                                 value="{{ old('barang_id', $stok->barang_id) }}" required>
                             @error('barang_id')
                                 <small class="form-text text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-1 control-label col-form-label">user id</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="user_id" name="user_id"
                                value="{{ old('user_id', $stok->user_id) }}" required>
                            @error('user_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">jumlah stok</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="stok_jumlah" name="stok_jumlah"
                                value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required>
                            @error('stok_jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
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