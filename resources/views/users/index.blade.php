@extends('layouts.app')

@section('content')

<div class="w-full px-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Users</h1>

        <a href="{{ route('users.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           + Tambah User
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- SEARCH FORM --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <form method="GET" action="{{ route('users.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, username, atau email..."
                   class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto">
       <table class="w-full text-sm">

    <thead class="bg-slate-800 text-white">
        <tr>
            <th class="p-3 text-left">NO</th>
            <th class="p-3 text-left">Username</th>
            <th class="p-3 text-left">Nama Lengkap</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Role</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $user->name }}</td>
            <td class="p-3">{{ $user->full_name }}</td>
            <td class="p-3">{{ $user->email }}</td>

            {{-- ROLE --}}
           <td class="p-3">
    <span class="px-2 py-1 text-xs rounded
        @if($user->role == 'admin')
            bg-blue-200 text-blue-800
        @elseif($user->role == 'user')
            bg-purple-200 text-purple-800
        @else
            bg-gray-200 text-gray-800
        @endif
    ">
        {{ $user->role ?? 'tidak ada' }}
    </span>
</td>
            {{-- STATUS --}}
            <td class="p-3">
                <span class="px-2 py-1 text-xs rounded
                    {{ $user->status == 'aktif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ $user->status }}
                </span>
            </td>

            {{-- AKSI --}}
            <td class="p-3">
                <div class="flex gap-2 justify-center">
                    <a href="{{ route('users.edit', $user->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
                       Edit
                    </a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center p-4 text-gray-500">
                Tidak ada data user
            </td>
        </tr>
        @endforelse
    </tbody>

</table>
    </div>

</div>

@endsection