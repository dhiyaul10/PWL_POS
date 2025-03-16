<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\stokController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});
Route::group(['prefix'=>'level'],function(){
    Route::get('/',[LevelController::class,'index'])->name('level.index');
    Route::post('/list',[LevelController::class,'list'])->name('level.list');
    Route::get('/create',[LevelController::class,'create'])->name('level.create');
    Route::get('/{id}',[LevelController::class,'show']);
    Route::post('/',[LevelController::class,'store']);
    Route::get('/{id}/edit', [LevelController::class,'edit'])->name('level.edit');
    Route::put('/{id}', [LevelController::class,'update']);
    Route::delete('/{id}',[LevelController::class,'destroy']);
});
Route::group(['prefix'=>'kategori'],function(){
    Route::get('/',[kategoriController::class,'index'])->name('kategori.index');
    Route::post('/list',[kategoriController::class,'list'])->name('kategori.list');
    Route::get('/create',[kategoriController::class,'create'])->name('kategori.create');
    Route::post('/',[kategoriController::class,'store']);
    Route::get('/{id}/edit', [kategoriController::class,'edit'])->name('kategori.edit');
    Route::put('/{id}', [kategoriController::class,'update']);
    Route::delete('/{id}',[kategoriController::class,'destroy']);
});
Route::group(['prefix'=>'barang'],function(){
    Route::get('/',[barangController::class,'index']);
    Route::post('/list',[barangController::class,'list']);
    Route::get('/create',[barangController::class,'create']);
    Route::post('/',[barangController::class,'store']);
    Route::get('/{id}/edit', [barangController::class,'edit']);
    Route::put('/{id}', [barangController::class,'update']);
    Route::delete('/{id}',[barangController::class,'destroy']);
});
Route::group(['prefix'=>'stok'],function(){
    Route::get('/',[StokController::class,'index']);
    Route::post('/list',[StokController::class,'list']);
    Route::get('/create',[stokController::class,'create']);
    Route::post('/',[StokController::class,'store']);
    Route::get('/{id}',[stokController::class,'show']);
    Route::get('/{id}/edit', [StokController::class,'edit']);
    Route::put('/{id}', [StokController::class,'update']);
    Route::delete('/{id}',[StokController::class,'destroy']);
});
Route::group(['prefix'=>'penjualan'],function(){
    Route::get('/',[penjualanController::class,'index']);
    Route::post('/list',[penjualanController::class,'list']);
    Route::post('/',[penjualanController::class,'store']);
    Route::get('/{id}',[penjualanController::class,'show']);
    Route::delete('/{id}',[penjualanController::class,'destroy']);
    Route::get('/{id}/edit', [penjualanController::class,'edit']);
});