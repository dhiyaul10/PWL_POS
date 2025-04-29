<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PenjualanDetailModel;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan']
        ];

        $page = (object) [
            'title' => 'Transaksi Penjualan'
        ];

        $activeMenu = 'transaksi';
        return view('transaksi.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function getPenjualan(Request $request)
{
    if ($request->ajax()) {
        $data = PenjualanModel::with(['user', 'details'])->orderBy('penjualan_tanggal', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($row) {
                // Hitung total harga berdasarkan detail transaksi
                return $row->details->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah;
                });
            })
            ->addColumn('aksi', function ($transaksi) {
                $btn  = '<button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= ' <button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}

    public function create_ajax()
    {
        $page = (object)[
            'title' => 'Tambah Transaksi Baru'
        ];

        // Ambil data barang untuk dropdown
        $barang = \App\Models\BarangModel::all();

        return view('transaksi.create_ajax', compact('page', 'barang'));
    }

    
public function store_ajax(Request $request)
{
    $rules = [
        'penjualan_kode' => 'required|unique:t_penjualan,penjualan_kode',
        'pembeli' => 'required|string|max:255',
        'penjualan_tanggal' => 'required|date',
        'items.*.barang_id' => 'required|exists:m_barang,barang_id',
        'items.*.jumlah' => 'required|numeric|min:1',
        'items.*.harga' => 'required|numeric|min:0', // Validasi untuk harga
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi Gagal',
            'errors' => $validator->errors()
        ]);
    }

    try {
        DB::beginTransaction();

        // Simpan data transaksi
        $transaksi = PenjualanModel::create([
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => auth()->id(), // Sesuaikan dengan sistem login Anda
        ]);

        // Simpan detail barang
        foreach ($request->items as $item) {
            PenjualanDetailModel::create([
                'penjualan_id' => $transaksi->penjualan_id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'], // Simpan harga dari form
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Data transaksi berhasil disimpan'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
        ]);
    }
}

    public function show_ajax($id)
    {
        $transaksi = PenjualanModel::with(['user', 'details.barang'])->findOrFail($id);

        $page = (object)[
            'title' => 'Detail Transaksi'
        ];

        return view('transaksi.show_ajax', compact('transaksi', 'page'));
    }

    // public function edit_ajax($id)
    // {
    //     $transaksi = PenjualanModel::findOrFail($id);

    //     $page = (object)[
    //         'title' => 'Edit Transaksi'
    //     ];

    //     return view('transaksi.edit_ajax', compact('transaksi', 'page'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $transaksi = PenjualanModel::findOrFail($id);

    //     // Validasi data; tambahkan field lain jika perlu
    //     $validatedData = $request->validate([
    //         'penjualan_tanggal' => 'required|date',
    //         // tambahkan validasi field lain sesuai kebutuhan
    //     ]);

    //     $transaksi->update($validatedData);

    //     return redirect()->back()->with('success', 'Transaksi berhasil diupdate');
    // }

    // Menampilkan view konfirmasi delete via AJAX
    public function delete_ajax($id)
    {
        $transaksi = PenjualanModel::findOrFail($id);

        $page = (object)[
            'title' => 'Hapus Transaksi'
        ];

        return view('transaksi.delete_ajax', compact('transaksi', 'page'));
    }

    // Proses penghapusan data
    public function destroy(Request $request, $id)
    {
        $transaksi = PenjualanModel::findOrFail($id);
        $transaksi->delete();

        // Jika menggunakan AJAX, kirim response berupa JSON
        if ($request->ajax()) {
            return response()->json(['success' => 'Transaksi berhasil dihapus']);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }

    public function list(Request $request)
    {
        $transactions = PenjualanModel::query();
        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('aksi', function($row) {
                // Action buttons dapat ditambahkan di sini jika diperlukan
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function export_excel()
    {
        $transaksi = PenjualanModel::with(['user'])->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Kode');
        $sheet->setCellValue('D1', 'Pembeli');
        $sheet->setCellValue('E1', 'Tanggal');

        // Isi data
        $row = 2;
        foreach ($transaksi as $index => $t) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $t->user_id);
            $sheet->setCellValue('C' . $row, $t->penjualan_kode);
            $sheet->setCellValue('D' . $row, $t->pembeli);
            $sheet->setCellValue('E' . $row, $t->penjualan_tanggal);
            $row++;
        }

        // Atur lebar kolom otomatis
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Simpan file Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Transaksi_' . now()->format('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $transaksi = PenjualanModel::with(['user'])->get();

        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksi'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Data_Transaksi_' . now()->format('Y-m-d_His') . '.pdf');
    }
}