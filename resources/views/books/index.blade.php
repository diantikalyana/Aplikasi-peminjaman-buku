@extends('layouts.app')

@section('content')

<div class="px-6 lg:px-10">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Data Buku</h1>
    <div class="text-sm text-gray-500">Kelola koleksi buku di perpustakaan</div>
    <div class="flex gap-2">
        <a href="{{ route('books.pdf') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 shadow">📥 Download PDF</a>
        <a href="{{ route('books.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 shadow">+ Tambah Buku</a>
    </div>
</div>

{{-- SEARCH FORM --}}
<div class="bg-white p-4 rounded shadow mb-6">
    <form method="GET" action="{{ route('books.index') }}" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari judul, penulis, atau kategori..."
               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('books.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-800 text-white">
            <tr>
                 <th class="p-3 text-left">NO</th>
                 <th class="p-3 text-left">Cover</th>
                <th class="p-3 text-left">Judul</th>
                <th class="p-3 text-left">Penulis</th>
                <th class="p-3 text-left">Kategori</th>
                <th class="p-3 text-left">Stok</th>
                <th class="p-3 text-left">Deskripsi</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>
@forelse($books as $book)
    <tr class="border-b hover:bg-gray-50">

        <!-- NOMOR -->
        <td class="p-3 font-medium">
            {{ $loop->iteration }}
        </td>

         <!-- COVER -->
        <td class="p-3">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="w-14 h-20 object-cover rounded shadow">
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>

        <!-- JUDUL -->
        <td class="p-3 font-medium">
            {{ $book->title }}
        </td>

        <!-- PENULIS -->
        <td class="p-3">
            {{ $book->author }}
        </td>

        <!-- KATEGORI -->
        <td class="p-3">
            {{ $book->category->name ?? '-' }}
        </td>

        <!-- STOK -->
        <td class="p-3">
            <span class="px-2 py-1 rounded text-xs 
                {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $book->stock }}
            </span>
        </td>

        <!-- DESKRIPSI -->
        <td class="p-3 text-gray-600">
            {{ \Illuminate\Support\Str::limit($book->description, 80) }}
        </td>

        <!-- AKSI -->
        <td class="p-3 flex gap-2">
            <a href="{{ route('books.edit', $book->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
                Edit
            </a>

            <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin hapus?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                    Hapus
                </button>
            </form>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center p-4 text-gray-500">
            Tidak ada data buku
        </td>
    </tr>
@endforelse
</tbody>

    </table>
</div>

@endsection