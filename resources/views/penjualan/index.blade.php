{{-- @extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
         </div>
         <div class="card-body">
             @if (session('success'))
                 <div class="alert alert-success">{{ session('success')}}</div>
             @endif
             @if (session('error'))
                 <div class="alert alert-danger">{{ session('error')}}</div>
             @endif
             <div class="row">
                 <div class="col-md-12">
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">Filter:</label>
                         <div class="col-3">
                             <select class="form-control" id="user_id" name="user_id" required>
                                 <option value="">- Semua -</option>
                                 @foreach($user as $item)
                                     <option value="{{ $item->id }}">{{ $item->name }}</option>
                                 @endforeach
                             </select>
                             <small class="Form-text text-muted">Nama User</small>
                         </div>
                     </div>
                 </div>
             </div>
             <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                 <thead>
                     <tr>
                         <th>ID Penjualan</th>
                         <th>User id</th>
                         <th>Barang ID</th>
                         <th>Harga</th>
                         <th>Jumlah</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 @endsection
 
 @push('js')
     <script>
         $(document).ready(function() {
             var dataTable = $('#table_penjualan').DataTable({
                 serverSide: true,
                 ajax: {
                     "url": "{{ ('penjualan/list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data": function (d) {
                         d.user_id = $('#user_id').val();
                     }
                 },
                 columns: [
                     {
                         data: "penjualan_id", 
                         className: "text-center",
                         orderable: false,
                         searchable: false
                     },
                     {
                         data: "user_id",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "barang_id",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "harga",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "jumlah",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "aksi",
                         className: "",
                         orderable: false,
                         searchable: false
                     }
                 ]
             });
             $('#user_id').on('change', function() {
                 dataTable.ajax.reload();
             });
         });
     </script>
 @endpush --}}