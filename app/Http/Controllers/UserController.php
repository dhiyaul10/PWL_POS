<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:m_user,username',
            'nama' => 'required|string',
            'password' => 'required|min:6',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'User berhasil ditambahkan!');
    }

    public function ubah($id)
    {
        $user = UserModel::findOrFail($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string',
            'password' => 'nullable|min:6',
            'level_id' => 'required|integer'
        ]);

        $user->username = $request->username;
        $user->nama = $request->nama;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->level_id = $request->level_id;
        $user->save();

        return redirect('/user')->with('success', 'User berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'User berhasil dihapus!');
    }
}

