<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\stokController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});


Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user', 'middleware' => 'authorize:ADM,MNG'], function() {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});
Route::group(['prefix' => 'level', 'middleware' =>'authorize:ADM'], function() {
    Route::get('/',[LevelController::class,'index'])->name('level.index');
    Route::post('/list',[LevelController::class,'list'])->name('level.list');
    Route::get('/create',[LevelController::class,'create'])->name('level.create');
    Route::get('/{id}',[LevelController::class,'show']);
    Route::post('/',[LevelController::class,'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::get('/{id}/edit', [LevelController::class,'edit'])->name('level.edit');
    Route::put('/{id}', [LevelController::class,'update']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}',[LevelController::class,'destroy']);
});
Route::group(['prefix' => 'kategori', 'middleware' => 'authorize:ADM,MNG'], function() {
    Route::get('/',[kategoriController::class,'index'])->name('kategori.index');
    Route::post('/list',[kategoriController::class,'list'])->name('kategori.list');
    Route::get('/create',[kategoriController::class,'create'])->name('kategori.create');
    Route::post('/',[kategoriController::class,'store']);
    Route::get('/create_ajax', [kategoriController::class, 'create_ajax']);
    Route::post('/ajax', [kategoriController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [kategoriController::class, 'show_ajax']);
    Route::get('/{id}/edit', [kategoriController::class,'edit'])->name('kategori.edit');
    Route::put('/{id}', [kategoriController::class,'update']);
    Route::get('/{id}/edit_ajax', [kategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [kategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [kategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [kategoriController::class, 'delete_ajax']);
    Route::delete('/{id}',[kategoriController::class,'destroy']);
});
Route::group(['prefix' => 'supplier', 'middleware' => 'authorize:ADM,MNG'], function() {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
    Route::post('/{id}', [SupplierController::class, 'destroy']);
});
// artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
Route::group(['prefix' => 'barang', 'middleware' => 'authorize:ADM,MNG'], function () {
    Route::get('/',[barangController::class,'index']);
    Route::post('/list',[barangController::class,'list']);
    Route::get('/create',[barangController::class,'create']);
    Route::post('/',[barangController::class,'store']);
    Route::get('/create_ajax', [barangController::class, 'create_ajax']);
    Route::post('/ajax', [barangController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [barangController::class, 'show_ajax']);
    Route::get('/{id}/edit', [barangController::class,'edit']);
    Route::put('/{id}', [barangController::class,'update']);
    Route::get('/{id}/edit_ajax', [barangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [barangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [barangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [barangController::class, 'delete_ajax']);
    Route::get('import', [BarangController::class, 'import']); // ajax form upload excel
    Route::post('import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    Route::get('export_excel', [BarangController::class, 'export_excel']); // export excel
    Route::delete('/{id}',[barangController::class,'destroy']);
});
Route::group(['prefix'=>'stok'],function(){
    Route::get('/',[StokController::class,'index']);
    Route::post('/list',[StokController::class,'list']);
    Route::get('/create',[stokController::class,'create']);
    Route::post('/',[StokController::class,'store']);
    Route::get('/{id}',[stokController::class,'show']);
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);
    Route::post('/ajax', [StokController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::get('/{id}/edit', [StokController::class,'edit']);
    Route::put('/{id}', [StokController::class,'update']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    Route::delete('/{id}',[StokController::class,'destroy']);
});
Route::group(['prefix'=>'penjualan'],function(){
    Route::get('/',[penjualanController::class,'index']);
    Route::post('/list',[penjualanController::class,'list']);
    Route::post('/',[penjualanController::class,'store']);
    Route::post('/ajax', [penjualanController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [penjualanController::class, 'show_ajax']);
    Route::get('/{id}',[penjualanController::class,'show']);
    Route::get('/{id}/edit', [penjualanController::class,'edit']);
    Route::get('/{id}/edit_ajax', [penjualanController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [penjualanController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [penjualanController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [penjualanController::class, 'delete_ajax']);
    Route::delete('/{id}',[penjualanController::class,'destroy']);
});
Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini
});