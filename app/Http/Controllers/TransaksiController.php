<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $data = PenjualanModel::orderBy('penjualan_tanggal', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($transaksi) {
                    $btn  = '<button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                    //$btn .= ' <button onclick="modalAction(\''.url('/transaksi/'.$transaksi->penjualan_id.'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>';
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