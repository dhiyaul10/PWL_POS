@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>

        <div class="card-tools">
            <button onclick="modalAction('{{ url('supplier/import') }}')" class="btn btn-sm btn-info mt-1">Import Supplier</button>
            <a href="{{ url('supplier/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i> Export Excel</a>
            <a href="{{ url('supplier/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export PDF</a>
            <button onclick="modalAction('{{ url('supplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data (Ajax)</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Filter Data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_supplier" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_supplier" class="form-control form-control-sm filter_supplier">
                                <option value="">- Semua -</option>
                                @foreach($supplier as $s)
                                    <option value="{{ $s->supplier_id }}">{{ $s->supplier_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter berdasarkan Supplier</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
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

    var tableSupplier;
    $(document).ready(function () {
        tableSupplier = $('#table_supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('supplier/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.filter_supplier = $('.filter_supplier').val(); // Kirim filter ke server
                }
            },
            columns: [
                {
                    data: "supplier_id",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "supplier_kode",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "supplier_nama",
                    className: "",
                    width: "30%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "supplier_alamat",
                    className: "",
                    width: "30%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Filter Data
        $('.filter_supplier').change(function () {
            tableSupplier.draw();
        });
    });
</script>
@endpush