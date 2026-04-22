@extends('layouts.app')

@section('content')

<div class="w-full px-6 py-6">

    <h1 class="text-2xl font-bold mb-6">
        PERPUSTALKAAN SMK MA'ARIF WALISONGO KAJORAN
    </h1>

    <div class="grid md:grid-cols-2 gap-6">

        <a href="/transactions/create"
           class="bg-blue-500 text-white p-6 rounded shadow hover:bg-blue-600">
            <h3 class="text-lg">Pinjam Buku</h3>
        </a>

        <a href="/transactions"
           class="bg-green-500 text-white p-6 rounded shadow hover:bg-green-600">
            <h3 class="text-lg">Riwayat Peminjaman</h3>
        </a>

    </div>

</div>

@endsection