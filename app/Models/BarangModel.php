<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Nama tabel di database
    protected $primaryKey = 'barang_id'; // Primary Key
    public $timestamps = true; // Menggunakan timestamps

    protected $fillable = [
        'barang_kode',
        'barang_nama',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'image', // Kolom image
    ];

    // Accessor untuk mengubah path image jadi URL storage
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/barang/' . $value) : null
        );
    }

    // Relasi ke tabel kategori (m_kategori)
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    // Relasi ke detail penjualan
    public function detail_penjualan()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'barang_id', 'barang_id');
    }
}