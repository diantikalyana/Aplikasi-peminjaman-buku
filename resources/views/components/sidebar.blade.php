<div class="w-64 bg-slate-800 text-white p-5">
<div class="mb-6 flex justify-center">
    <img src="{{ asset('logo.png') }}" 
         class="w-24 h-24 object-contain">
</div>

<nav class="space-y-2">

        <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-slate-700">
            Dashboard
        </a>

        <p class="text-sm text-gray-400 mt-4">DATA</p>

        <a href="/books" class="block px-3 py-2 rounded hover:bg-slate-700">
            Data Buku
        </a>

        <a href="/categories" class="block px-3 py-2 rounded hover:bg-slate-700">
            Kategori Buku
        </a>

        <a href="/users" class="block px-3 py-2 rounded hover:bg-slate-700">
            Data Anggota
        </a>

        <a href="/transactions" class="block px-3 py-2 rounded bg-slate-700">
            Transaksi
        </a>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <p class="text-sm text-gray-400 mt-4">LAPORAN & NOTIFIKASI</p>

            <div x-data="{ open:false }" class="">
                <button onclick="document.getElementById('laporanList').classList.toggle('hidden')" class="w-full text-left px-3 py-2 rounded hover:bg-slate-700">Laporan ▾</button>
                <div id="laporanList" class="hidden ml-2 mt-2">
                    <a href="{{ route('admin.reports.bookings') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Laporan Bookings</a>
                    <a href="{{ route('admin.reports.transactions') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Peminjaman & Pengembalian</a>
                    <a href="{{ route('admin.reports.late') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Keterlambatan</a>
                </div>
            </div>

            {{-- NOTIFICATION LINK --}}
            <a href="{{ route('admin.notifications.index') }}" class="flex items-center justify-between px-3 py-2 rounded hover:bg-slate-700">
                <span>🔔 Notifikasi</span>
                @php
                    $unreadCount = auth()->user()->unreadNotificationsCount() ?? 0;
                @endphp
                @if($unreadCount > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>
        @endif

        <form action="/logout" method="POST" class="mt-6">
            @csrf
            <button class="w-full text-left px-3 py-2 bg-red-500 rounded hover:bg-red-600">
                Logout
            </button>
        </form>

    </nav>
</div>