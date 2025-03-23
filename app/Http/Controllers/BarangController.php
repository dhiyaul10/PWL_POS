<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\BarangModel;
 use App\Models\KategoriModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\DataTables;
 use Illuminate\Support\Facades\Validator;
 
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
    
        public function list()
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'harga_beli', 'harga_jual');
        
        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                return '
                    <button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> 
                    <button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>
                ';
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

        public function create_ajax()
     {
         // Ambil data kategori untuk ditampilkan di dropdown
         $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();
 
         return view('barang.create_ajax')->with('kategori', $kategori);
     }
 
     // Menyimpan data barang menggunakan AJAX
     public function store_ajax(Request $request)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_kode' => 'required|string',
                 'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                 'barang_nama' => 'required|string|max:100',
                 'harga_beli' => 'required|numeric|min:0',
                 'harga_jual' => 'required|numeric|min:0',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             BarangModel::create($request->all());
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data barang berhasil disimpan',
             ]);
         }
 
         return redirect('/');
     }
 
     // Menampilkan halaman form edit barang ajax
     public function edit_ajax($id)
     {
         $barang = BarangModel::find($id);
         $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();
 
         if (!$barang) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan.'
             ]);
         }
 
         return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
     }
 
 
     public function update_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_kode' => 'required|string',
                 'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
                 'barang_nama' => 'required|string|max:100',
                 'harga_beli' => 'required|numeric|min:0',
                 'harga_jual' => 'required|numeric|min:0',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi gagal.',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             $barang = BarangModel::find($id);
             if ($barang) {
                 $barang->update($request->all());
                 return response()->json([
                     'status' => true,
                     'message' => 'Data barang berhasil diupdate'
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data barang tidak ditemukan'
                 ]);
             }
         }
 
         return redirect('/');
     }
 
     // Menampilkan halaman konfirmasi hapus barang ajax
         public function confirm_ajax($id)
     {
         $barang = BarangModel::with('kategori')->find($id);
         if (!$barang) {
             return response()->json([
                 'status' => false,
                 'message' => 'Barang tidak ditemukan.'
             ]);
         }
 
         return view('barang.confirm_ajax', ['barang' => $barang]);
     }
 
     // Menghapus data barang menggunakan AJAX
     public function delete_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $barang = BarangModel::find($id);
 
             if ($barang) {
                 $barang->delete();
                 return response()->json([
                     'status' => true,
                     'message' => 'Data barang berhasil dihapus',
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data barang tidak ditemukan',
                 ]);
             }
         }
 
         return redirect('/');
     }
    }