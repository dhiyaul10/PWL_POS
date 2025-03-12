@extends('layouts.template')
 
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
         
             <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                 <thead>
                     <tr>
                         <th>ID stok</th>
                         <th>Nama barang</th>
                         <th>ID user</th>
                         <th>jumlah stok</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 @endsection
 
 @push('css')
 @endpush
 
 @push('js')
     <script>
         $(document).ready(function() {
             var dataUser = $('#table_stok').DataTable({
                 serverSide: true,   
                 ajax: {
                     "url": "{{('stok/list') }}",
                     "dataType": "json",
                     "type": "POST"
                 },
                 columns: [
                     {
                         data: "stok_id",     
                         className: "text-center",
                         orderable: false,
                         searchable: false
                     }, {
                         data: "barang.barang_nama",
                         className: "",
                         orderable: true,        
                         searchable: true       
                     }, {
                         data: "user_id",
                         className: "",
                         orderable: true,        
                         searchable: true       
                     }, {
                         data: "stok_jumlah",
                         className: "",
                         orderable: true,        
                         searchable: true       
                     }, {
                         data: "aksi",
                         className: "",
                         orderable: false,       
                         searchable: false       
                     }
                 ]
             }); 
         });
     </script>
 @endpush