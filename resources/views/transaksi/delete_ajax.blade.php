@empty($transaksi)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form id="form-delete-transaksi" method="POST" action="{{ url('/transaksi/' . $transaksi->penjualan_id . '/delete_ajax') }}">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi</h5>
                    Apakah Anda yakin ingin menghapus transaksi berikut?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr><th class="text-right col-3">Kode Transaksi</th><td class="col-9">{{ $transaksi->penjualan_kode }}</td></tr>
                    <tr><th class="text-right col-3">Pembeli</th><td class="col-9">{{ $transaksi->pembeli }}</td></tr>
                    <tr><th class="text-right col-3">Tanggal</th><td class="col-9">{{ \Carbon\Carbon::parse($transaksi->penjualan_tanggal)->format('d-m-Y H:i') }}</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    $('#form-delete-transaksi').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    $('#datatable-transaksi').DataTable().ajax.reload(); // reload datatable
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
            }
        });
    });
});
</script>
@endempty