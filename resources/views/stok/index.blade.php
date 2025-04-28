@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Stok Barang</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('stok/import') }}')" class="btn btn-sm btn-info mt-1">Import Stok</button>
            <a href="{{ url('stok/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i> Export Excel</a>
            <a href="{{ url('stok/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export PDF</a>
            <button onclick="modalAction('{{ url('stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data (Ajax)</button>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-sm table-striped table-hover" id="table-stok">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Barang</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var tableStok;

    $(document).ready(function () {
        tableStok = $('#table-stok').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('stok/list') }}",
                type: "POST",
                dataType: "json"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang.barang_kode", // Tambahkan kolom Kode Barang
                    className: "text-center",
                    width: "15%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "barang.barang_nama",
                    className: "",
                    width: "30%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_tanggal",
                    className: "text-center",
                    width: "15%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "stok_jumlah",
                    className: "text-right",
                    width: "10%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "20%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#table-stok_filter input').unbind().bind().on('keyup', function (e) {
            if (e.keyCode == 13) {
                tableStok.search(this.value).draw();
            }
        });
    });
</script>
@endpush