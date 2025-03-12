<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\StokModel;
 use App\Models\BarangModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\Facades\DataTables;
 
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
                    $btn = '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
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
    }