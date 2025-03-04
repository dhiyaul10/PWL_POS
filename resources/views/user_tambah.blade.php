<!DOCTYPE html>
<html>
<body>
    <h1>Form Tambah Data User</h1>
    <form method="POST" action="/user/tambah_simpan">
        @csrf
        <label>Username</label>
        <input type="text" name="username" required>
        <br>
    
        <label>Nama</label>
        <input type="text" name="nama" required>
        <br>
    
        <label>Password</label>
        <input type="password" name="password" required>
        <br>
    
        <label>Level ID</label>
        <input type="number" name="level_id" required>
        <br><br>
    
        <button type="submit">Simpan</button>
    </form>
</body>
</html>