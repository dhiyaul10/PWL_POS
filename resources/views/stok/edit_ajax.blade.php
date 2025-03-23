@empty($stok) 
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
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else 
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit"> 
        @csrf 
        @method('PUT') 
        <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Stok</h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div> 
                <div class="modal-body"> 
                    <div class="form-group"> 
                        <label>Barang ID</label> 
                        <input value="{{ $stok->barang_id }}" type="text" name="barang_id" id="barang_id" class="form-control" required> 
                        <small id="error-barang_id" class="error-text form-text text-danger"></small> 
                    </div> 
                    <div class="form-group"> 
                        <label>User ID</label> 
                        <input value="{{ $stok->user_id }}" type="text" name="user_id" id="user_id" class="form-control" required> 
                        <small id="error-user_id" class="error-text form-text text-danger"></small> 
                    </div> 
                    <div class="form-group"> 
                        <label>Jumlah Stok</label> 
                        <input value="{{ $stok->jumlah_stok }}" type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" required> 
                        <small id="error-jumlah_stok" class="error-text form-text text-danger"></small> 
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
                barang_id: { required: true, minlength: 3 }, 
                user_id: { required: true, minlength: 3 }, 
                jumlah_stok: { required: true, number: true, min: 1 } 
            }, 
            submitHandler: function(form) { 
                $.ajax({ 
                    url: form.action, 
                    type: form.method, 
                    data: $(form).serialize(), 
                    success: function(response) { 
                        if(response.status){ 
                            $('#myModal').modal('hide'); 
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil', 
                                text: response.message 
                            }); 
                            dataStok.ajax.reload(); 
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
            highlight: function (element) { 
                $(element).addClass('is-invalid'); 
            }, 
            unhighlight: function (element) { 
                $(element).removeClass('is-invalid'); 
            } 
        }); 
    }); 
    </script> 
@endempty 
