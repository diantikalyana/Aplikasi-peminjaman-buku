@extends('layouts.app')

@section('content')

<div class="w-full px-6 py-6">

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        @if($unreadCount > 0)
            <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                🔔 {{ $unreadCount }} Notifikasi Baru
            </a>
        @endif
    </div>

    <!-- STATISTICS CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">

        <!-- BOOKS -->
        <a href="{{ route('books.index') }}"
           class="bg-blue-500 text-white p-6 rounded shadow hover:bg-blue-600">
            <h3 class="text-lg">Data Buku</h3>
            <p class="text-3xl font-bold">{{ $totalBooks }}</p>
        </a>

        <!-- USERS -->
        <a href="{{ route('users.index') }}"
           class="bg-green-500 text-white p-6 rounded shadow hover:bg-green-600">
            <h3 class="text-lg">Data Anggota</h3>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </a>

        <!-- CATEGORIES -->
        <a href="{{ route('categories.index') }}"
           class="bg-yellow-500 text-white p-6 rounded shadow hover:bg-yellow-600">
            <h3 class="text-lg">Kategori Buku</h3>
            <p class="text-3xl font-bold">{{ $totalCategories }}</p>
        </a>

    </div>

    <!-- ACTIVITY CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">

        <!-- PENDING BOOKINGS -->
        <a href="{{ route('bookings.index') }}"
           class="bg-purple-500 text-white p-6 rounded shadow hover:bg-purple-600">
            <h3 class="text-lg">📋 Booking Tertunda</h3>
            <p class="text-3xl font-bold">{{ $pendingBookings }}</p>
        </a>

        <!-- ACTIVE TRANSACTIONS -->
        <a href="{{ route('transactions.index') }}"
           class="bg-indigo-500 text-white p-6 rounded shadow hover:bg-indigo-600">
            <h3 class="text-lg">📚 Peminjaman Aktif</h3>
            <p class="text-3xl font-bold">{{ $activeTransactions }}</p>
        </a>

        <!-- UNPAID FINES -->
        <a href="{{ route('fines.index') }}"
           class="bg-red-500 text-white p-6 rounded shadow hover:bg-red-600">
            <h3 class="text-lg">💰 Denda Belum Bayar</h3>
            <p class="text-3xl font-bold">{{ $unpaidFines }}</p>
        </a>

    </div>

    <!-- RECENT NOTIFICATIONS -->
    @if($unreadNotifications->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">🔔 Notifikasi Terbaru</h2>
            <a href="{{ route('admin.notifications.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                Lihat Semua →
            </a>
        </div>

        <div class="space-y-3">
            @foreach($unreadNotifications as $notif)
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <div class="flex justify-between">
                    <div>
                        <h3 class="font-semibold text-blue-700">{{ $notif->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="inline-block px-2 py-1 text-xs rounded-full
                        @if($notif->type == 'booking') bg-blue-100 text-blue-700
                        @elseif($notif->type == 'fine') bg-red-100 text-red-700
                        @elseif($notif->type == 'new_book') bg-green-100 text-green-700
                        @elseif($notif->type == 'return_reminder') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700
                        @endif
                    ">
                        @if($notif->type == 'booking') Booking
                        @elseif($notif->type == 'fine') Denda
                        @elseif($notif->type == 'new_book') Buku Baru
                        @elseif($notif->type == 'return_reminder') Pengingat
                        @else Umum
                        @endif
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection