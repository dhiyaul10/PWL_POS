<?php

namespace App\Http\Controllers\Api;

use App\Models\BarangModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Menampilkan semua barang
    public function index()
    {
        $barangs = BarangModel::all();

        // Menambahkan URL gambar untuk setiap barang
        $barangs->map(function ($barang) {
            $barang->image_url = $barang->image; // pakai accessor image()
            return $barang;
        });

        return response()->json([
            'success' => true,
            'message' => 'List of barang',
            'data' => $barangs,
        ]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('barang_images', 'public');
        }

        // Simpan barang
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang created successfully',
            'data' => [
                'barang' => $barang,
                'image_url' => $barang->image,
            ],
        ], 201);
    }

    // Menampilkan detail barang
    public function show($barang_id)
    {
        $barang = BarangModel::find($barang_id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang not found',
            ], 404);
        }

        $barang->image_url = $barang->image;

        return response()->json([
            'success' => true,
            'message' => 'Barang detail',
            'data' => $barang,
        ]);
    }

    // Memperbarui data barang
    public function update(Request $request, $barang_id)
    {
        $barang = BarangModel::find($barang_id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang not found',
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($barang->image) {
                Storage::disk('public')->delete($barang->getRawOriginal('image'));
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('barang_images', 'public');
            $barang->image = $imagePath;
        }

        // Update data barang
        $barang->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $barang->image, // ikut update gambar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang updated successfully',
            'data' => [
                'barang' => $barang,
                'image_url' => $barang->image,
            ],
        ]);
    }

    // Menghapus data barang
    public function destroy($barang_id)
    {
        $barang = BarangModel::find($barang_id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang not found',
            ], 404);
        }

        // Hapus gambar dari storage
        if ($barang->image) {
            Storage::disk('public')->delete($barang->getRawOriginal('image'));
        }

        // Hapus barang
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang deleted successfully',
        ]);
    }
}