@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Tambah Buku</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <input type="text" name="title" placeholder="Judul"
            class="border p-2 w-full rounded">

        <input type="text" name="author" placeholder="Penulis"
            class="border p-2 w-full rounded">

        <input type="number" name="stock" placeholder="Stok"
            class="border p-2 w-full rounded">

        <select name="category_id" class="border p-2 w-full rounded">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <textarea name="description"
            placeholder="Deskripsi"
            class="border p-2 w-full rounded"></textarea>

        <input type="file" name="cover"
            class="border p-2 w-full rounded">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection