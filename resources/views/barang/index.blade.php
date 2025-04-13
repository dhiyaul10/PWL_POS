@extends('layouts.template')
 
    @section('content')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
                    <button onclick="modalAction('{{ url('barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <table class="table-bordered table-striped table-hover table-sm table" id="table_barang">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>ID Kategori</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data
backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    @endsection
    
    @push('css')
    @endpush
    
    @push('js')
        <script>
            function modalAction(url = ''){ 
    $('#myModal').load(url,function(){ 
        $('#myModal').modal('show'); 
    }); 
} 
            $(document).ready(function() {
                var dataUser = $('#table_barang').DataTable({
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('barang/list') }}",
                        "dataType": "json",
                        "type": "POST",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "kategori_id", 
                            className: "",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "barang_kode",
                            className: "",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "barang_nama",
                            className: "",
                            orderable: true,
                        },
                        {
                            data: "harga_beli", 
                            className: "",
                            orderable: true,
                        },
                        {
                            data: "harga_jual", 
                            className: "",
                            orderable: true,
                        },
                        {
                            data: "aksi",
                            className: "",
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    @endpush