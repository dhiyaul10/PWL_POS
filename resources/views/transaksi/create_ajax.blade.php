<div class="modal-header">
    <h5 class="modal-title">{{ $page->title }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-create-transaksi">
        @csrf
        <div class="form-group">
            <label for="penjualan_kode">Kode Transaksi</label>
            <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" placeholder="Masukkan kode transaksi" required>
        </div>
        <div class="form-group">
            <label for="pembeli">Nama Pembeli</label>
            <input type="text" name="pembeli" id="pembeli" class="form-control" placeholder="Masukkan nama pembeli" required>
        </div>
        <div class="form-group">
            <label for="penjualan_tanggal">Tanggal Transaksi</label>
            <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="barang">Barang</label>
            <select name="items[0][barang_id]" id="barang" class="form-control" required>
                <option value="">Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="items[0][jumlah]" id="jumlah" class="form-control" placeholder="Masukkan jumlah barang" required>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    <button type="button" class="btn btn-primary" id="btn-save-transaksi">Simpan</button>
</div>
@push('js')
<script>
    $(document).on('click', '#btn-save-transaksi', function () {
        let form = $('#form-create-transaksi');
        let url = "{{ route('transaksi.store_ajax') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    $('#myModal').modal('hide');
                    $('#datatable-transaksi').DataTable().ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
</script>
@endpush