@extends('layouts.template')
 
 @section('content')
 <div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form action="{{ url('level') }}" method="post" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">level id</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="level_id" name="level_id"
                    value="{{ old('level_id') }}" required>
                         @error('level_id')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_nama">Nama level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="level_nama" name="level_nama"
                            value="{{ old('level_nama') }}" required>
                         @error('level_nama')
                             <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                    </div>
                    <div class="form-group">
                        <label for="level_kode">Kode level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="level_kode" name="level_kode"
                            value="{{ old('level_kode') }}" required>
                         @error('level_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
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