<!DOCTYPE html>
<html>
<body>
    <h1>Form Tambah Data User</h1>
    <form method="POST" action="/user/ubah_simpan/{{ $data->user_id }}">
        @csrf
        @method('PUT')
    
        <label>Username</label>
        <input type="text" name="username" value="{{ $data->username }}" required>
        <br>
    
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $data->nama }}" required>
        <br>
    
        <label>Password (biarkan kosong jika tidak ingin mengubah)</label>
        <input type="password" name="password">
        <br>
    
        <label>Level ID</label>
        <input type="number" name="level_id" value="{{ $data->level_id }}" required>
        <br><br>
    
        <button type="submit">Update</button>
    </form>    
</body>
</html>