<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\StokModel;
 use App\Models\BarangModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;
 
    class StokController extends Controller
    {
        public function index(){
            $breadcrumb = (object) [
                'title' => 'Stok',
                'list' => ['Home', 'Stok']
            ];
    
            $page = (object) [
                'title' => 'Stok barang yang tersisa'
            ];
    
            $activeMenu = 'stok';
            return view('stok.index', compact('breadcrumb', 'page', 'activeMenu'));
        }
    
        public function list(Request $request) {
            $stok = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with(['barang', 'user']);

            if ($request->user_id) {
                $stok->where('user_id', $request->user_id);
            }
            return DataTables::of($stok)
                ->addIndexColumn()
                ->addColumn('aksi', function ($stok) {
                    // $btn = '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
                    //     . csrf_field() . method_field('DELETE') .
                    //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                    $btn = '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    
        public function store(Request $request){
            $request->validate([
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_jumlah' => 'required|integer',
            ]);
    
            StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => $request->user_id,
                'stok_jumlah' => $request->stok_jumlah,
            ]);
            return redirect('/stok')->with('success', 'Data barang berhasil disimpan');
        }
    
        public function edit(string $id){
            $stok = stokModel::find($id);
            $breadcrumb = (object) [
                'title' => 'Edit stok',
                'list' => ['Home', 'stok', 'Edit']
            ];
    
            $page = (object) [
                'title' => 'Edit stok'
            ];
    
            $activeMenu = 'stok';
            return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
        }
    
        public function destroy($id){
            $stok = StokModel::findOrFail($id);
    
            try {
                $stok->delete();
                return redirect('/stok')->with('success', 'Data barang berhasil dihapus');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/stok')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
            }
        }

            // Menampilkan form tambah stok (AJAX)
        public function create_ajax()
        {
            return view('stok.create_ajax');
        }

        // Menyimpan stok baru (AJAX)
        public function store_ajax(Request $request)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'barang_id' => 'required|integer|exists:barang,barang_id',
                    'jumlah_stok' => 'required|integer|min:1'
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi gagal.',
                        'errors' => $validator->errors()
                    ]);
                }

                StokModel::create($request->only(['barang_id', 'jumlah_stok']));

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil disimpan'
                ]);
            }

            return redirect('/');
        }

        // Menampilkan form edit stok (AJAX)
        public function edit_ajax($id)
        {
            $stok = StokModel::find($id);
            if (!$stok) {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }
            return response()->json(['status' => true, 'data' => $stok]);
        }

        // Menyimpan perubahan stok (AJAX)
        public function update_ajax(Request $request, $id)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'barang_id' => 'required|integer|exists:barang,barang_id',
                    'jumlah_stok' => 'required|integer|min:1'
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi gagal.',
                        'errors' => $validator->errors()
                    ]);
                }

                $stok = StokModel::find($id);
                if (!$stok) {
                    return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
                }

                $stok->update($request->only(['barang_id', 'jumlah_stok']));

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diperbarui'
                ]);
            }

            return redirect('/');
        }

        // Menampilkan konfirmasi hapus stok (AJAX)
        public function confirm_ajax($id)
        {
            $stok = StokModel::find($id);
            return view('stok.confirm_ajax', compact('stok'));
        }

        // Menghapus stok (AJAX)
        public function delete_ajax(Request $request, $id)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $stok = StokModel::find($id);
                if (!$stok) {
                    return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
                }
                $stok->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
                ]);
            }

            return redirect('/');
            }
    }