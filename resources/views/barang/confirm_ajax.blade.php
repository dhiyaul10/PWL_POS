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
                    Data yang Anda cari tidak ditemukan
                </div> 
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else 
    <form action="{{ url('/barang/' . $barang->barang_id . '/delete_ajax') }}" method="POST" id="form-delete"> 
    @csrf 
    @method('DELETE') 
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data Barang</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div> 
            <div class="modal-body"> 
                <div class="alert alert-warning"> 
                    <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5> 
                    Apakah Anda yakin ingin menghapus data berikut? 
                </div> 
                <table class="table table-sm table-bordered table-striped"> 
                    <tr><th class="text-right col-3">ID Kategori :</th><td class="col-9">{{ $barang->kategori_id }}</td></tr> 
                    <tr><th class="text-right col-3">Kode Barang :</th><td class="col-9">{{ $barang->barang_kode }}</td></tr> 
                    <tr><th class="text-right col-3">Nama Barang :</th><td class="col-9">{{ $barang->barang_nama }}</td></tr> 
                    <tr><th class="text-right col-3">Harga Beli :</th><td class="col-9">{{ $barang->harga_beli }}</td></tr> 
                    <tr><th class="text-right col-3">Harga Jual :</th><td class="col-9">{{ $barang->harga_jual }}</td></tr> 
                </table> 
            </div> 
            <div class="modal-footer"> 
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button> 
                <button type="submit" class="btn btn-danger">Ya, Hapus</button> 
            </div> 
        </div> 
    </div> 
    </form> 
    <script> 
        $(document).ready(function() { 
            $("#form-delete").submit(function(event) { 
                event.preventDefault(); 
                Swal.fire({ 
                    title: "Apakah Anda yakin?", 
                    text: "Data ini akan dihapus secara permanen!", 
                    icon: "warning", 
                    showCancelButton: true, 
                    confirmButtonColor: "#d33", 
                    cancelButtonColor: "#3085d6", 
                    confirmButtonText: "Ya, Hapus!" 
                }).then((result) => { 
                    if (result.isConfirmed) { 
                        $.ajax({ 
                            url: $(this).attr("action"), 
                            type: "DELETE", 
                            data: $(this).serialize(), 
                            success: function(response) { 
                                if(response.status){ 
                                    $('#modal-master').modal('hide'); 
                                    Swal.fire({ 
                                        icon: 'success', 
                                        title: 'Berhasil', 
                                        text: response.message 
                                    }); 
                                    dataBarang.ajax.reload(); 
                                } else { 
                                    Swal.fire({ 
                                        icon: 'error', 
                                        title: 'Terjadi Kesalahan', 
                                        text: response.message 
                                    }); 
                                } 
                            }, 
                            error: function() { 
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'Terjadi Kesalahan', 
                                    text: 'Gagal menghapus data. Silakan coba lagi.' 
                                }); 
                            }
                        }); 
                    } 
                }); 
            }); 
        }); 
    </script> 
@endempty
