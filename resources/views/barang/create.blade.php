@extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools"></div>
         </div>
         <div class="card-body">
             <form method="POST" action="{{ url('kategori') }}" class="form-horizontal">
                 @csrf
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label">ID barang</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="barang_ID" name="barang_ID"
                             value="{{ old('barang_ID')}}" required>
                         @error('barang_ID')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label">ID kategori</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="Kategoir_ID" name="Kategori_ID"
                             value="{{ old('Kategori_ID') }}" required>
                         @error('kategori_ID')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label">Kode</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="kode" name="kode"
                             value="{{ old('kode') }}" required>
                         @error('kode')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label">Nama</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="nama" name="nama"
                             value="{{ old('nama') }}" required>
                         @error('nama')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label">Harga Beli</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="Harga_beli" name="Harga_beli"
                             value="{{ old('Harga_Beli') }}" required>
                         @error('Harga_beli')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div><div class="form-group row">
                     <label class="col-1 control-label col-form-label">Harga Jual</label>
                     <div class="col-11">
                         <input type="text" class="form-control" id="Harga_jual" name="Harga_jual"
                             value="{{ old('Harga_jual') }}" required>
                         @error('Harga_jual')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                     <label class="col-1 control-label col-form-label"></label>
                     <div class="col-11">
                         <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                         <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 @endsection
 @push('css')
 @endpush
 
 @push('js')
 @endpush