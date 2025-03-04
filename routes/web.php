<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/tambah', [UserController::class, 'tambah']);
    Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan']);
    Route::get('/ubah/{id}', [UserController::class, 'ubah']);
    Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    Route::delete('/hapus/{id}', [UserController::class, 'hapus']);
});