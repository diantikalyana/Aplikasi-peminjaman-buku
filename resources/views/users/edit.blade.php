<h2>Edit User</h2>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $user->name }}"><br><br>
    <input type="text" name="full_name" value="{{ $user->full_name }}"><br><br>
    <input type="email" name="email" value="{{ $user->email }}"><br><br>
    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"><br><br>

    <select name="role">
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select><br><br>

    <select name="status">
        <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>