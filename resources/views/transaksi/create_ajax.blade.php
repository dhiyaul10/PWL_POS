<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $page->title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-create-transaksi">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="penjualan_kode">Kode Transaksi</label>
                        <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" placeholder="Masukkan kode transaksi" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pembeli">Nama Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" class="form-control" placeholder="Masukkan nama pembeli" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="penjualan_tanggal">Tanggal Transaksi</label>
                        <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="barang">Barang</label>
                        <select name="items[0][barang_id]" id="barang" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="items[0][jumlah]" id="jumlah" class="form-control" placeholder="Masukkan jumlah barang" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" name="items[0][harga]" id="harga" class="form-control" placeholder="Masukkan harga barang" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" id="btn-save-transaksi">Simpan</button>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        // Ketika dropdown barang berubah
        $('#barang').on('change', function () {
            // Ambil harga dari atribut data-harga
            let harga = $(this).find(':selected').data('harga');
            
            // Isi input harga dengan nilai harga
            $('#harga').val(harga || ''); // Jika tidak ada harga, kosongkan input
        });
    });
    $('#btn-save-transaksi').on('click', function (e) {
    e.preventDefault();

    let form = $('#form-create-transaksi');
    let formData = form.serialize();

    $.ajax({
        url: "{{ route('transaksi.store_ajax') }}",
        method: "POST",
        data: formData,
        success: function (response) {
            alert('Transaksi berhasil disimpan');
            $('#modal').modal('hide'); // Tutup modal jika pakai modal
            location.reload(); // Atau update tabel transaksi tanpa reload
        },
        error: function (xhr) {
            alert('Gagal menyimpan transaksi');
            console.log(xhr.responseText);
        }
    });
});

</script>
@endpush