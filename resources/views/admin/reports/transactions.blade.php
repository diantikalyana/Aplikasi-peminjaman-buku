@extends('layouts.app')

@section('content')

<div class="px-6 lg:px-10">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Laporan Peminjaman & Pengembalian</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.transactions.pdf') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Download PDF</a>
        <div class="text-sm text-gray-500">Semua transaksi peminjaman dan pengembalian</div>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-800 text-white">
            <tr>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Buku</th>
                <th class="p-3 text-left">Pinjam</th>
                <th class="p-3 text-left">Jatuh Tempo</th>
                <th class="p-3 text-left">Kembali</th>
                <th class="p-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $t->user->name ?? '—' }}</td>
                <td class="p-3">{{ $t->book->title ?? '—' }}</td>
                <td class="p-3">{{ $t->borrow_date }}</td>
                <td class="p-3">{{ $t->due_date }}</td>
                <td class="p-3">{{ $t->return_date }}</td>
                <td class="p-3">{{ $t->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
