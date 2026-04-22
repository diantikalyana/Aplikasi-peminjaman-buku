@extends('layouts.app')

@section('content')

<div class="px-6 lg:px-10">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Laporan Keterlambatan</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.late.pdf') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Download PDF</a>
        <div class="text-sm text-gray-500">Daftar transaksi yang terlambat dikembalikan</div>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-800 text-white">
            <tr>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Buku</th>
                <th class="p-3 text-left">Jatuh Tempo</th>
                <th class="p-3 text-left">Kembali</th>
                <th class="p-3 text-left">Hari Terlambat</th>
                <th class="p-3 text-left">Denda</th>
                <th class="p-3 text-left">Status Denda</th>
        </thead>
        <tbody>
            @foreach($lates as $l)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $l->user->name ?? '—' }}</td>
                <td class="p-3">{{ $l->book->title ?? '—' }}</td>
                <td class="p-3">{{ $l->due_date }}</td>
                <td class="p-3">{{ $l->return_date }}</td>
                <td class="p-3">
                    @if($l->return_date && $l->due_date)
                        {{ max(0, (strtotime($l->return_date) - strtotime($l->due_date)) / 86400) }} hari
                    @else
                        -
                    @endif
                </td>
                <td class="p-3">
                    @if($l->fine)
                        Rp {{ number_format($l->fine->amount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="p-3">
                    @if($l->fine)
                        @if($l->fine->status == 'belum_bayar')
                            <span class="text-red-600">Belum Bayar</span>
                        @else
                            <span class="text-green-600">Sudah Bayar</span>
                        @endif
                    @else
                        -
                    @endif
                </td>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
