@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Buat Transaksi Peminjaman</h1>

@if(session('success'))
<div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="mb-4 bg-red-100 text-red-700 p-3 rounded">{{ session('error') }}</div>
@endif

{{-- FORM PINJAM --}}
<div class="bg-white p-6 rounded shadow mb-6 max-w-4xl">

<h2 class="text-lg font-semibold mb-4">Detail Booking</h2>

<div class="grid md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded">
    <div>
        <strong>User:</strong> {{ $booking->user->name }}
    </div>
    <div>
        <strong>Buku:</strong> {{ $booking->book->title }}
    </div>
    <div>
        <strong>Tanggal Booking:</strong> {{ $booking->booking_date->format('d M Y') }}
    </div>
    <div>
        <strong>Status:</strong> <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">{{ ucfirst($booking->status) }}</span>
    </div>
</div>

<form action="{{ route('transactions.store') }}" method="POST" class="grid md:grid-cols-4 gap-4">
@csrf

{{-- USER (sudah terisi dari booking) --}}
<div>
    <label class="text-sm font-medium">User</label>
    <input type="text" value="{{ $booking->user->name }}" class="border p-2 rounded w-full bg-gray-100" readonly>
    <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
</div>

{{-- BOOK (sudah terisi dari booking) --}}
<div>
    <label class="text-sm font-medium">Buku</label>
    <input type="text" value="{{ $booking->book->title }} (Stok: {{ $booking->book->stock }})" class="border p-2 rounded w-full bg-gray-100" readonly>
    <input type="hidden" name="book_id" value="{{ $booking->book_id }}">
</div>

{{-- DURATION --}}
<div>
    <label class="text-sm font-medium">Hari Pinjam</label>
    <input type="number" name="duration" min="1" max="7" placeholder="Lama pinjam" class="border p-2 rounded w-full" required>
</div>

<div class="flex items-end">
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full">
        Buat Transaksi Peminjaman
    </button>
</div>

</form>
</div>

<div class="text-center">
    <a href="{{ route('bookings.index') }}" class="text-sky-600 hover:text-sky-800">← Kembali ke Daftar Booking</a>
</div>

@endsection