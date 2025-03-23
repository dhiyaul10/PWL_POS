<?php
 
 namespace App\Http\Controllers;
 
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
 use App\DataTables\KategoriDataTable;
 use App\Models\KategoriModel;
 use Illuminate\Http\RedirectResponse;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;

    class KategoriController extends Controller{
        public function index(){
            $breadcrumb = (object) [
                'title' => 'Daftar Kategori',
                'list' => ['Home', 'Kategori']
            ];
    
            $page = (object) [
                'title' => 'Daftar kategori yang terdaftar dalam sistem'
            ];
    
            $activeMenu = 'kategori';
            return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        }
    
        public function list(){
            $kategori = KategoriModel::all();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('aksi', function ($kategori) {
                    // $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    //     . csrf_field() . method_field('DELETE') .
                    //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                    // return $btn;
                    $btn = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                    $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    
        public function create(){
            $breadcrumb = (object) [
                'title' => 'Tambah Kategori',
                'list' => ['Home', 'Kategori', 'Tambah']
            ];
    
            $page = (object) [
                'title' => 'Tambah kategori baru'
            ];
    
            $activeMenu = 'kategori';
            return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        }
    
        public function store(Request $request){
            $request->validate([
                'kode' => 'required|string|min:3|max:10|unique:m_kategori,kategori_kode',
                'nama' => 'required|string|max:100',
            ]);
    
            KategoriModel::create([
                'kategori_kode' => $request->kode,
                'kategori_nama' => $request->nama,
            ]);
    
            return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
        }
    
        public function edit(string $id){
            $kategori = KategoriModel::find($id);
            $breadcrumb = (object) [
                'title' => 'Edit Kategori',
                'list' => ['Home', 'Kategori', 'Edit']
            ];
    
            $page = (object) [
                'title' => 'Edit kategori'
            ];

            $activeMenu = 'kategori';
            return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
        }
    
        public function update(Request $request, string $id){
            $request->validate([
                'kode' => 'required|string|min:3|max:10|unique:m_kategori,kategori_kode',
                'nama' => 'required|string|max:100',
            ]);

            KategoriModel::find($id)->update([
                'kategori_kode' => $request->kode,
                'kategori_nama' => $request->nama,
            ]);

            return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
        }

        public function destroy(string $id){
            $check = KategoriModel::find($id);
            if (!$check) {
                return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
            }
    
            try {
                KategoriModel::destroy($id);
    
                return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
            }
        }

        public function create_ajax()
     {
         return view('kategori.create_ajax'); // Pastikan file ini ada di folder views/kategori
     }
 
     // Menyimpan data kategori menggunakan AJAX
     public function store_ajax(Request $request) {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
                 'kategori_nama' => 'required|string|max:100',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             KategoriModel::create([
                 'kategori_kode' => $request->kategori_kode,
                 'kategori_nama' => $request->kategori_nama
             ]);
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data kategori berhasil disimpan',
             ]);
         }
 
         return redirect('/');
     }
 
     // Menampilkan halaman form edit kategori ajax
     public function edit_ajax(string $id)
     {
         $kategori = KategoriModel::find($id);
 
         if (!$kategori) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data kategori tidak ditemukan',
             ]);
         }
 
         return view('kategori.edit_ajax', ['kategori' => $kategori]); // Pastikan file ini ada di views/kategori
     }
 
     // Memperbarui data kategori via AJAX
     public function update_ajax(Request $request, $id) {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                 'kategori_nama' => 'required|string|max:100',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi gagal.',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             $check = KategoriModel::find($id);
             if ($check) {
                 $check->update([
                     'kategori_kode' => $request->kategori_kode,
                     'kategori_nama' => $request->kategori_nama
                 ]);
 
                 return response()->json([
                     'status' => true,
                     'message' => 'Data kategori berhasil diupdate'
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data tidak ditemukan'
                 ]);
             }
         }
 
         return redirect('/');
     }
 
     // Menampilkan halaman konfirmasi hapus kategori via AJAX
     public function confirm_ajax(string $id)
     {
         $kategori = KategoriModel::find($id);
 
         if (!$kategori) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data kategori tidak ditemukan.'
             ]);
         }
 
         return view('kategori.confirm_ajax', ['kategori' => $kategori]); // Pastikan file ini ada di views/kategori
     }
 
     // Menghapus data kategori menggunakan AJAX
 
     public function delete_ajax(Request $request, $id)
 {
     // Cek apakah request berasal dari AJAX
     if ($request->ajax() || $request->wantsJson()) {
         // Temukan kategori berdasarkan ID
         $kategori = KategoriModel::find($id);
 
         if ($kategori) {
             // Hapus kategori
             $kategori->delete();
             return response()->json([
                 'status' => true,
                 'message' => 'Data kategori berhasil dihapus',
             ]);
         } else {
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan',
             ]);
         }
     }
 
     return redirect('/'); // Jika bukan request AJAX, arahkan kembali ke halaman utama
 }
    }
