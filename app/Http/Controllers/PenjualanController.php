<?php
 
 namespace App\Http\Controllers;
 
 use Illuminate\Http\Request;
 use App\Models\penjualanModel;
 use App\Models\UserModel;
 use Carbon\Carbon;
 use Yajra\DataTables\Facades\DataTables;
 
    // class penjualanController extends Controller{
    //     public function index(){
    //         $breadcrumb = (object) [
    //             'title' => 'Daftar Transaksi Penjualan',
    //             'list' => ['Home', 'Transaksi Penjualan']
    //         ];
    //         $page = (object) [
    //             'title' => 'Daftar transaksi penjualan '
    //         ];
    //         $activeMenu = 'penjualan'; 
    //         $user = UserModel::all();  
    //         return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'user' => $user, 'activeMenu' => $activeMenu]);
    //     }
    
    //     public function list(Request $request){
    //         $penjualan = penjualanModel::select('penjualan_id','pembeli','user_id','barang_id','harga','jumlah')->with('user');
    //         if ($request->user_id) {
    //             $penjualan->where('user_id', $request->user_id);
    //         }
    //         return DataTables::of($penjualan)
    //             ->addIndexColumn() 
    //             ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
    //                 $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //                 $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //                 $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">'
    //                     . csrf_field() . method_field('DELETE') .
    //                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['aksi'])
    //             ->make(true);
    //     }

    //     public function edit(string $id){
    //         $penjualan = penjualanModel::find($id);
    
    //         $breadcrumb = (object) [
    //             'title' => 'Edit stok',
    //             'list' => ['Home', 'penjualan', 'Edit']
    //         ];
    
    //         $page = (object) [
    //             'title' => 'Edit penjualan'
    //         ];
    
    //         $activeMenu = 'penjualan';
    
    //         return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    //     }
    
    //     public function store(Request $request){
    //         $request->merge([
    //             'penjualan_tanggal' => Carbon::createFromFormat('Y-m-d\TH:i', $request->penjualan_tanggal)->format('Y-m-d H:i:s')
    //         ]);
    //         $request->validate([
    //             'user_id' => 'required|integer',
    //             'pembeli' => 'required|string|max:50',
    //             'penjualan_kode' => 'required|string|max:20|unique:t_penjualan,penjualan_kode',
    //             'penjualan_tanggal' => 'required|date_format:Y-m-d H:i:s',
    //             'barang_id' => 'required|integer',
    //             'harga' => 'required|integer',
    //             'jumlah' => 'required|integer'
    //         ]);
    //         $transaksiPenjualan = penjualanModel::create([
    //             'user_id' => $request->user_id,
    //             'pembeli' => $request->pembeli,
    //             'penjualan_kode' => $request->penjualan_kode,
    //             'penjualan_tanggal' => $request->penjualan_tanggal
    //         ]);
    
    //         $penjualanId = $transaksiPenjualan->penjualan_id;
    //         PenjualanModel::create([
    //             'penjualan_id' => $penjualanId,
    //             'barang_id' => $request->barang_id,
    //             'harga' => $request->harga,
    //             'jumlah' => $request->jumlah,
    //         ]);
    //         return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    //     }
    
    //     public function show(String $id){
    //         $penjualan = penjualanModel::find($id);
    //         $detailTransaksi = PenjualanModel::where('penjualan_id', $id)->get();
    //         $breadcrumb = (object) [
    //             'title' => 'Detail Transaksi Penjualan',
    //             'list'  => ['Home', 'Transaksi Penjualan', 'Detail']
    //         ];
    
    //         $page = (object) [
    //             'title' => 'Detail Transaksi Penjualan'
    //         ];
    
    //         $activeMenu = 'penjualan';
    //         return view('penjualan.show', [
    //             'breadcrumb' => $breadcrumb,
    //             'page'       => $page,
    //             'penjualan' => $penjualan,
    //             'detailTransaksi' => $detailTransaksi,
    //             'activeMenu' => $activeMenu
    //         ]);
    //     }
    // }