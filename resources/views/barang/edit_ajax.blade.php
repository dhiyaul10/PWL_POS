@empty($barang)
 <div id="modal-master" class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">
             <div class="alert alert-danger">
                 <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                 Data yang anda cari tidak ditemukan
             </div>
         </div>
     </div>
 </div>
 @else
 <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit">
     @csrf
     @method('PUT')
     <div id="modal-master" class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Edit Data Barang</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="form-group">
                     <label>Kategori</label>
                     <select name="kategori_kode" id="kategori_kode" class="form-control" required>
                         <option value="">- Pilih Kategori -</option>
                         @foreach($kategori as $k)
                             <option value="{{ $k->kategori_kode }}" {{ ($k->kategori_kode == $barang->kategori_kode) ? 'selected' : '' }}>
                                 {{ $k->kategori_nama }}
                             </option>
                         @endforeach
                     </select>
                     <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                 </div>
                 <div class="form-group">
                     <label>Kode Barang</label>
                     <input value="{{ $barang->barang_kode }}" type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                     <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                 </div>
                 <div class="form-group">
                     <label>Nama Barang</label>
                     <input value="{{ $barang->barang_nama }}" type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                     <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                 </div>
                 <div class="form-group">
                     <label>Harga Beli</label>
                     <input value="{{ $barang->harga_beli }}" type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                     <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                 </div>
                 <div class="form-group">
                     <label>Harga Jual</label>
                     <input value="{{ $barang->harga_jual }}" type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                     <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                 <button type="submit" class="btn btn-primary">Simpan</button>
             </div>
         </div>
     </div>
 </form>
 
 <script>
     $(document).ready(function() {
         $("#form-edit").validate({
             rules: {
                 kategori_kode: { required: true },
                 barang_kode: { required: true, minlength: 3, maxlength: 20 },
                 barang_nama: { required: true, minlength: 3, maxlength: 100 },
                 harga_beli: { required: true, number: true },
                 harga_jual: { required: true, number: true }
             },
             submitHandler: function(form) {
                 $.ajax({
                     url: form.action,
                     type: form.method,
                     data: $(form).serialize(),
                     success: function(response) {
                         if(response.status) {
                             $('#myModal').modal('hide');
                             Swal.fire({
                                 icon: 'success',
                                 title: 'Berhasil',
                                 text: response.message
                             });
                             dataBarang.ajax.reload();
                         } else {
                             $('.error-text').text('');
                             $.each(response.msgField, function(prefix, val) {
                                 $('#error-' + prefix).text(val[0]);
                             });
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Terjadi Kesalahan',
                                 text: response.message
                             });
                         }
                     }
                 });
                 return false;
             },
             errorElement: 'span',
             errorPlacement: function (error, element) {
                 error.addClass('invalid-feedback');
                 element.closest('.form-group').append(error);
             },
             highlight: function (element, errorClass, validClass) {
                 $(element).addClass('is-invalid');
             },
             unhighlight: function (element, errorClass, validClass) {
                 $(element).removeClass('is-invalid');
             }
         });
     });
 </script>
 @endempty