@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Level</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-info">Import Level</button>
                <a href="{{ url('/level/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Level</a>
                <a href="{{ url('/level/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Level</a>
                <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_level" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_level" class="form-control form-control-sm filter_level">
                                    <option value="">- Semua -</option>
                                    @foreach($level as $l)
                                        <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter berdasarkan Level</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tampilkan Pesan Sukses atau Error -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Tabel Data -->
            <table class="table table-bordered table-sm table-striped table-hover" id="table-level">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
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

    var tableLevel;
    $(document).ready(function () {
        tableLevel = $('#table-level').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('level/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.filter_level = $('.filter_level').val(); // Kirim filter ke server
                }
            },
            columns: [
                {
                    data: "level_id",
                    className: "text-center",
                    width: "5%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level_kode",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level_nama",
                    className: "",
                    width: "55%",
                    orderable: true,
                    searchable: true
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

        // Filter Data
        $('.filter_level').change(function () {
            tableLevel.draw();
        });
    });
</script>
@endpush