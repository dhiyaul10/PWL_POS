@extends('layouts.template')
 
    @section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ID Level:</label>
                        <p>{{ $level->level_id }}</p>
                    </div>
                    <div class="form-group">
                        <label>Nama Level:</label>
                        <p>{{ $level->level_nama }}</p>
                    </div>
                    <div class="form-group">
                        <label>Kode Level:</label>
                        <p>{{ $level->level_kode }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection