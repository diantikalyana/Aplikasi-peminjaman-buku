@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit Buku</h1>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ $book->title }}" placeholder="Judul" class="border p-2 w-full rounded">

        <input type="text" name="author" value="{{ $book->author }}" placeholder="Penulis" class="border p-2 w-full rounded">

        <input type="number" name="stock" value="{{ $book->stock }}" placeholder="Stok" class="border p-2 w-full rounded">

        <select name="category_id" class="border p-2 w-full rounded">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <textarea name="description" placeholder="Deskripsi" class="border p-2 w-full rounded">{{ $book->description }}</textarea>

        @if($book->cover)
            <div class="flex items-center gap-4">
                <div>
                    <div class="text-sm text-gray-500">Cover Saat Ini</div>
                    <img src="{{ asset('storage/'.$book->cover) }}" class="w-24 h-32 object-cover rounded shadow">
                </div>
                <div class="flex-1">
                    <label class="text-sm text-gray-600">Ganti Cover (opsional)</label>
                    <input type="file" name="cover" class="border p-2 w-full rounded">
                </div>
            </div>
        @else
            <input type="file" name="cover" class="border p-2 w-full rounded">
        @endif

        <div class="flex gap-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            <a href="{{ route('books.index') }}" class="px-4 py-2 rounded border text-sm">Batal</a>
        </div>

    </form>

</div>

@endsection