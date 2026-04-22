@extends('layouts.app')

@section('content')

<div class="px-6 lg:px-10">

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">{{ session('error') }}</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Laporan Bookings</h1>
    <div class="flex gap-2">
        <a href="{{ route('bookings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kelola Bookings</a>
        <a href="{{ route('admin.reports.bookings.pdf') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Download PDF</a>
    </div>
</div>

    <div class="bg-white rounded shadow overflow-x-auto mb-6">
        <table class="w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="p-3 text-left">Buku</th>
                    <th class="p-3 text-left">Jumlah Booking</th>
                </tr>
            </thead>
            <tbody>
                @foreach($counts as $c)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $c->book->title ?? '—' }}</td>
                    <td class="p-3">{{ $c->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Buku</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $b)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $b->user->name ?? '—' }}</td>
                    <td class="p-3">{{ $b->book->title ?? '—' }}</td>
                    <td class="p-3">{{ $b->booking_date ? $b->booking_date->format('Y-m-d') : $b->created_at->format('Y-m-d') }}</td>
                    <td class="p-3">
                        @if($b->status === 'pending')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                Menunggu
                            </span>
                        @elseif($b->status === 'approved')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                Disetujui
                            </span>
                        @elseif($b->status === 'rejected')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                Ditolak
                            </span>
                        @elseif($b->status === 'completed')
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                Selesai
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                {{ ucfirst($b->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="p-3">
                        @if($b->status === 'pending')
                            <form method="POST" action="{{ route('bookings.approve', $b) }}" class="inline mr-2">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600" onclick="return confirm('Setujui booking ini?')">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('bookings.reject', $b) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600" onclick="return confirm('Tolak booking ini?')">Tolak</button>
                            </form>
                        @elseif($b->status === 'approved')
                            <a href="{{ route('bookings.create-transaction', $b) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 inline-block">Buat Transaksi</a>
                        @else
                            <span class="text-gray-500 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
