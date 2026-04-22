@extends('layouts.app')

@section('content')

<div class="w-full">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Denda</h1>
        <div class="text-sm text-gray-500">Kelola denda keterlambatan pengembalian buku</div>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- SEARCH FORM --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <form method="GET" action="{{ route('fines.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama user atau judul buku..."
                   class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('fines.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="p-3 text-left">NO</th>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Buku</th>
                    <th class="p-3 text-left">Hari Telat</th>
                    <th class="p-3 text-left">Total Denda</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($fines as $fine)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ optional($fine->transaction->user)->name ?? '-' }}</td>
                    <td class="p-3">{{ optional($fine->transaction->book)->title ?? '-' }}</td>
                    <td class="p-3">{{ $fine->days_late }}</td>
                    <td class="p-3">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                    <td class="p-3">
                        @if($fine->status == 'belum_bayar')
                            <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">Belum Bayar</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">Sudah Bayar</span>
                        @endif
                    </td>
                    <td class="flex gap-2 justify-center p-2">
                        @if($fine->status == 'belum_bayar')
                        <form action="{{ route('fines.update', $fine->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button onclick="return confirm('Yakin denda sudah dibayar?')"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                                Bayar
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-gray-500">
                        Tidak ada data denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection