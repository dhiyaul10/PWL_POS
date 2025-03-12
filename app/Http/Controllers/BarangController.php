<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\BarangModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\DataTables;
 
    class barangController extends Controller{
        public function index(){
            $breadcrumb = (object) [
                'title' => 'Daftar barang',
                'list' => ['Home', 'barang']
            ];
    
            $page = (object) [
                'title' => 'Daftar barang yang terdaftar dalam sistem'
            ];
    
            $activeMenu = 'barang';
            return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        }
    
        public function list(){
            $barang = BarangModel::all();
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('aksi', function ($barang) {
                    $btn = '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    
        public function create(){
            $breadcrumb = (object) [
                'title' => 'Tambah barang',
                'list' => ['Home', 'barang', 'Tambah']
            ];
    
            $page = (object) [
                'title' => 'Tambah barang baru'
            ];
    
            $activeMenu = 'barang';
            return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        }
    
        public function store(Request $request){
            $request->validate([
                'barang_kode' => 'required|string',
                'barang_nama' => 'required|string|max:100', 
                'kategori_id' => 'required|string', 
                'harga_beli' => 'required|integer',
                'harga_jual' =>'required|integer',
            ]);
    
            BarangModel::create([
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'kategori_id' => $request->kategori_id, 
                'harga_beli' => $request->harga_beli,
                'harga_jual' =>$request->harga_jual,
            ]);
            return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
        }
    
        public function edit(string $id){
            $barang = BarangModel::find($id);
            $breadcrumb = (object) [
                'title' => 'Edit barang',
                'list' => ['Home', 'barang', 'Edit']
            ];
    
            $page = (object) [
                'title' => 'Edit barang'
            ];
    
            $activeMenu = 'barang';
            return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
        }
    
        public function update(Request $request, string $id){
            $request->validate([
                'barang_kode' => 'required|string',
                'barang_nama' => 'required|string|max:100', 
                'kategori_id' => 'required|string', 
                'harga_beli' => 'required|integer',
                'harga_jual' =>'required|integer',
            ]);
    
            BarangModel::find($id)->update([
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'kategori_id' => $request->kategori_id, 
                'harga_beli' => $request->harga_beli,
                'harga_jual' =>$request->harga_jual,
            ]);
            return redirect('/barang')->with('success', 'Data barang berhasil diubah');
        }
    
        public function destroy(string $id){
            $check = BarangModel::find($id);
            if (!$check) {
                return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
            }
    
            try {
                BarangModel::destroy($id);
    
                return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
            }
        }
    }