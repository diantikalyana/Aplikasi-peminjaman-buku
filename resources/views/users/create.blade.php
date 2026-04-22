<h2>Tambah User</h2>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Username"><br><br>
    <input type="text" name="full_name" placeholder="Nama Lengkap"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <select name="status">
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>