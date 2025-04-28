<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_kode }} - {{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" value="{{ old('stok_jumlah') }}" required>
                    <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" value="{{ old('stok_tanggal') }}" required>
                    <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplier as $item)
                            <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                barang_id: { required: true },
                stok_jumlah: { required: true, number: true, min: 1 },
                stok_tanggal: { required: true, date: true },
                supplier_id: { required: true }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide'); // Tutup modal setelah berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            $('#table_stok').DataTable().ajax.reload(); // Reload DataTables
                        } else {
                            $('.error-text').text(''); // Kosongkan error sebelumnya
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]); // Tampilkan error
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
                        });
                    }
                });
                return false; // Mencegah form submit normal
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>