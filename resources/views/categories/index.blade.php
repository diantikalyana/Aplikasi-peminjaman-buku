@extends('layouts.app')

@section('content')

<div class="w-full px-8 lg:px-16 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center gap-3">
        <div>
            <h1 class="text-2xl font-bold">Data Kategori</h1>
            <p class="text-sm text-gray-500">Kelola kategori buku</p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 shadow">
            + Tambah Kategori
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- SEARCH --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama kategori..."
                   class="flex-1 min-w-[250px] border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto mt-6">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="p-4 text-left w-16">NO</th>
                    <th class="p-4 text-left">Nama Kategori</th>
                    <th class="p-4 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td class="p-4">{{ $category->name }}</td>

                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
                    <td colspan="3" class="text-center p-6 text-gray-500">
                        Tidak ada data kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection