<?php
 
 namespace App\Http\Controllers;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Http\Request;
 use App\Models\SupplierModel;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;
 use PhpOffice\PhpSpreadsheet\IOFactory;
 use Barryvdh\DomPDF\Facade\Pdf;
 
 class SupplierController extends Controller
 {
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];
    
        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'supplier';
    
        // Ambil data supplier untuk filter
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
    
        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu', 'supplier'));
    }
     public function list(Request $request)
     {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

         return DataTables::of($supplier)
             ->addIndexColumn()
             ->addColumn('aksi', function ($supplier) { 
                // $btn  = '<a href="'.url('/supplier/' . $supplier->supplier_id).'" class="btn btn-info btn-sm">Detail</a> ';  
                // $btn .= '<a href="'.url('/supplier/' . $supplier->supplier_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/supplier/' . $supplier->supplier_id).'">'  
                //         . csrf_field() . method_field('DELETE') .   
                //         '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;
                $btn  = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn;
             })
             ->rawColumns(['aksi']) 
             ->make(true);
     }
     public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah supplier',
             'list' => ['Home', 'Supplier', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah supplier baru'
         ];

         $activeMenu = 'supplier'; 
 
         return view('supplier.create', [
             'breadcrumb' => $breadcrumb, 
             'page' => $page,  
             'activeMenu' => $activeMenu]);
     }
     public function store(Request $request)
     {
         $request->validate([
             'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
             'supplier_nama' => 'required|string|max:255'
         ]);
         SupplierModel::create([
             'supplier_kode' => $request->supplier_kode,
             'supplier_nama' => $request->supplier_nama
         ]);
         return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
     }
     
     public function show(int $supplier_id)
     {
        $supplier = SupplierModel::find($supplier_id);
 
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
             'title' => 'Detail Supplier',
             'list'  => ['Home', 'Supplier', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail supplier'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }
 
     // Menampilkan halaman form edit supplier
     public function edit(int $supplier_id)
     {
        $supplier = SupplierModel::find($supplier_id);
 
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
             'title' => 'Edit Supplier',
             'list'  => ['Home', 'Supplier', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit supplier'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }
 
     // Menyimpan perubahan data supplier
     public function update(Request $request, int $supplier_id)
     {
         $request->validate([
             'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,' . $supplier_id . ',supplier_id',
             'supplier_nama' => 'required|string|max:255'
         ]);
 
         $supplier = SupplierModel::find($supplier_id);
 
         if (!$supplier) {
             return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
         }
 
         $supplier->update([
             'supplier_kode' => $request->supplier_kode,
             'supplier_nama' => $request->supplier_nama
         ]);
 
         return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
     }
     
    
     public function destroy(int $supplier_id)
     {
        $supplier = SupplierModel::find($supplier_id);
 
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            $supplier->delete();
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena terkait dengan data lain');
        }
    }

    // Menampilkan halaman form tambah supplier ajax
    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    // Menyimpan data supplier menggunakan AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            SupplierModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan',
            ]);
        }

        return redirect('/');
    }

    // Menampilkan halaman form edit supplier ajax
    public function edit_ajax($id)
    {
        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    // Memperbarui data supplier menggunakan AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    // Menampilkan konfirmasi hapus supplier ajax
    public function confirm_ajax($id)
    {
        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier tidak ditemukan.'
            ]);
        }

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    // Menghapus data supplier menggunakan AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);

            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }

    public function import()
    {
        return view('supplier.import'); // Pastikan file ini ada di folder views/supplier
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_supplier');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $index => $row) {
                    if ($index > 1) { // Skip header
                        if (!empty($row['A']) && !empty($row['B']) && !empty($row['C'])) {
                            $insert[] = [
                                'supplier_kode' => $row['A'],
                                'supplier_nama' => $row['B'],
                                'supplier_alamat' => $row['C'],
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                }
                if (!empty($insert)) {
                    SupplierModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil diimport'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->orderBy('supplier_id')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'ID Supplier');
        $sheet->setCellValue('B1', 'Kode Supplier');
        $sheet->setCellValue('C1', 'Nama Supplier');
        $sheet->setCellValue('D1', 'Alamat Supplier');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Isi data
        $baris = 2;
        foreach ($supplier as $item) {
            $sheet->setCellValue('A' . $baris, $item->supplier_id);
            $sheet->setCellValue('B' . $baris, $item->supplier_kode);
            $sheet->setCellValue('C' . $baris, $item->supplier_nama);
            $sheet->setCellValue('D' . $baris, $item->supplier_alamat);
            $baris++;
        }

        // Auto size kolom
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Supplier');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier ' . date('Y-m-d H-i-s') . '.xlsx';

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function export_pdf()
    {
        $supplier = SupplierModel::orderBy('supplier_id')->get();

        $pdf = Pdf::loadView('supplier.export_pdf', ['supplier' => $supplier]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Data Supplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}