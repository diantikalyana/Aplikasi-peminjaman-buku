@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit Kategori</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}"
                class="border p-2 w-full rounded" required>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update
        </button>

    </form>

</div>

@endsection