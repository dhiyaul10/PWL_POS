<?php
 
 namespace App\Http\Controllers;
 
 use Illuminate\Http\RedirectResponse;
 use Illuminate\Http\Request;
 use Illuminate\Contracts\View\View;
 use App\Models\LevelModel;
 use Yajra\DataTables\Facades\DataTables;

    class LevelController extends Controller{
        public function index(): View {
        $breadcrumb = (object)[
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object)[
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';
        $level = LevelModel::all();
        return view('level.index', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $level = LevelModel::select('level_id','level_kode','level_nama');
        
        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function($level) {
                $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'
                    . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" 
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    } 

    public function show(string $id){
         $level = LevelModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Detail level',
             'list' => ['Home', 'level', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail level'
         ];
 
         $activeMenu = 'level';
 
         return view('level.show', ['breadcrumb' => $breadcrumb, 'level'=>$level,'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create(): View{
        $breadcrumb = (object)[
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object)[
            'title' => 'Tambah level baru'
        ];

        $activeMenu = 'level';
        $level = LevelModel::all();

        return view('level.create', compact('breadcrumb', 'page', 'activeMenu', 'level'));
    }

    public function store(Request $request): RedirectResponse{
        $validatedData = $request->validate([
            'level_id' => 'required|int',
            'level_nama' => 'required|string',
            'level_kode' => 'required|string',
        ], [
            'level_id.required' => 'ID Level harus diisi.',
            'level_nama.required' => 'Nama Level harus diisi.',
            'level_kode.required' => 'Kode Level harus diisi.',
        ]);

        return back()->withErrors($validatedData)->withInput();
    }

    public function edit($id): View{
        $level = LevelModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit level'
        ];

        $activeMenu = 'level';

        return view('level.edit', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function update(Request $request, $id): RedirectResponse{
        $validated = $request->validate([
            'level_id' => 'required',
                'level_nama' => 'required|string',
                'level_kode' => 'required',
            ]);
    
            $level = LevelModel::findOrFail($id);
    
            $level->update([
                'level_id' => $request->level_id,
                'level_nama' => $request->level_nama,
                'level_kode' => $request->level_kode,
            ]);
    
            return redirect('/level')->with('success', 'Data Level berhasil diperbarui');
        }

        public function destroy($id): RedirectResponse {
            $level = LevelModel::findOrFail($id);
    
            $level->delete();
    
            return redirect('/level')->with('success', 'Data Level berhasil dihapus');
        }
    }
