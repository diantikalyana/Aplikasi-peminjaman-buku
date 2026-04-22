@extends('layouts.user')

@section('page_title','Bookings')
@section('page_subtitle','Daftar booking kamu')

@section('content')

<div class="mb-4">
    <h3 class="text-lg font-semibold text-sky-700">
    <p class="text-sm text-sky-500">
</div>

@if(session('success'))
    <div class="p-3 bg-green-50 text-green-700 rounded mb-4">{{ session('success') }}</div>
@endif

{{-- SEARCH FORM --}}
<div class="bg-white shadow rounded p-4 mb-4">
    <form method="GET" action="{{ route('bookings.index') }}" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama user atau judul buku..."
               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('bookings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white shadow rounded p-4">
    @if($bookings->count())
    <table class="w-full table-soft">
        <thead>
            <tr>
                <th>Buku</th>
                <th>Tanggal Booking</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td>{{ $b->book->title ?? '—' }}<div class="text-xs text-sky-500">{{ $b->book->author ?? '' }}</div></td>
                <td>{{ $b->booking_date ? $b->booking_date->format('Y-m-d') : $b->created_at->format('Y-m-d') }}</td>
                <td>
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
                <td>
                    @if(auth()->user() && auth()->user()->role === 'admin')
                        @if($b->status === 'pending')
                            <form method="POST" action="{{ route('bookings.approve', $b) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 mr-2" onclick="return confirm('Setujui booking ini?')">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('bookings.reject', $b) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 mr-2" onclick="return confirm('Tolak booking ini?')">Tolak</button>
                            </form>
                        @elseif($b->status === 'approved')
                            <a href="{{ route('bookings.create-transaction', $b) }}" class="text-blue-600 hover:text-blue-800 mr-2">Buat Transaksi</a>
                        @endif
                        <a href="{{ route('bookings.show', $b) }}" class="text-sky-600 hover:text-sky-800">Lihat</a>
                    @else
                        @if($b->status === 'pending')
                            <form method="POST" action="{{ route('bookings.destroy', $b) }}" class="inline">@csrf @method('DELETE')<button class="text-red-600 hover:text-red-800" onclick="return confirm('Batalkan booking?')">Batal</button></form>
                        @else
                            <span class="text-gray-500">{{ ucfirst($b->status) }}</span>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $bookings->links() }}</div>

    @else
    <div class="text-gray-500">Belum ada booking.</div>
    @endif
</div>

@endsection
