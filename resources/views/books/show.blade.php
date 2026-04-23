@extends('layouts.app')

@section('content')

<div class="px-6 lg:px-10">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detail Buku</h1>
    <a href="{{ route('books.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 shadow">← Kembali</a>
</div>

<div class="bg-white rounded shadow p-6">
    <div class="flex gap-6">
        <!-- Cover -->
        <div class="flex-shrink-0">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="w-48 h-64 object-cover rounded shadow">
            @else
                <div class="w-48 h-64 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                    No Cover
                </div>
            @endif
        </div>

        <!-- Details -->
        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-2">{{ $book->title }}</h2>
            <p class="text-lg text-gray-600 mb-4">Oleh {{ $book->author }}</p>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <strong>Kategori:</strong> {{ $book->category->name ?? '-' }}
                </div>
                <div>
                    <strong>Stok:</strong>
                    <span class="px-2 py-1 rounded text-sm
                        {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $book->stock }}
                    </span>
                </div>
            </div>

            @if($book->description)
                <div class="mb-6">
                    <strong>Deskripsi:</strong>
                    <p class="mt-2 text-gray-700">{{ $book->description }}</p>
                </div>
            @endif

            <div class="flex gap-2">
                <a href="{{ route('books.edit', $book->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Edit Buku
                </a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus buku ini?')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection