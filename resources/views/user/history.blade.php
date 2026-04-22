@extends('layouts.user')

@section('page_title','Riwayat Peminjaman')
@section('page_subtitle','Lihat riwayat peminjaman dan pengembalian buku Anda')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-sky-700"></h2>
            <p class="text-sm text-sky-500"></p>
        </div>
    </div>
</div>

{{-- TABLE RIWAYAT --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-sky-700 text-white">
                    <tr>
                        <th class="p-4 text-left font-semibold">#</th>
                        <th class="p-4 text-left font-semibold">Judul Buku</th>
                        <th class="p-4 text-left font-semibold">Tanggal Pinjam</th>
                        <th class="p-4 text-left font-semibold">Jatuh Tempo</th>
                        <th class="p-4 text-left font-semibold">Tanggal Kembali</th>
                        <th class="p-4 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions as $index => $trans)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium text-gray-800">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                            <td class="p-4">
                                <div class="font-medium text-gray-900">{{ $trans->book->title }}</div>
                                <div class="text-xs text-gray-500">{{ $trans->book->author ?? '-' }}</div>
                            </td>
                            <td class="p-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($trans->borrow_date)->format('d M Y') }}
                            </td>
                            <td class="p-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($trans->due_date)->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                @if($trans->return_date)
                                    <span class="text-gray-700">{{ \Carbon\Carbon::parse($trans->return_date)->format('d M Y') }}</span>
                                @else
                                    <span class="text-orange-600 font-medium">Belum dikembalikan</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($trans->status == 'dipinjam')
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        Sedang Dipinjam
                                    </span>
                                @elseif($trans->status == 'kembali')
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                        Dikembalikan
                                    </span>
                                @elseif($trans->status == 'telat')
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                        Telat
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                        {{ ucfirst($trans->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                    <p class="font-medium">Belum ada riwayat peminjaman</p>
                                    <p class="text-sm mt-1">Mulai dengan meminjam buku dari halaman Buku</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($transactions->hasPages())
            <div class="p-4 border-t border-gray-200 flex justify-center">
                {{ $transactions->links() }}
            </div>
        @endif
    @else
        <div class="p-12 text-center">
            <div class="text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                <p class="text-lg font-semibold mb-2">Belum ada riwayat peminjaman</p>
                <p class="text-sm text-gray-400 mb-6">Anda belum pernah meminjam buku. Mulai dengan mengunjungi halaman Buku dan pilih buku yang ingin Anda pinjam.</p>
                <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition font-medium">
                    Jelajahi Buku
                </a>
            </div>
        </div>
    @endif
</div>

{{-- INFO SUMMARY --}}
@if($transactions->count() > 0)
    <div class="mt-8 grid grid-cols-3 gap-4">
        <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Sedang Dipinjam</div>
            <div class="text-2xl font-bold text-blue-700 mt-2">
                {{ $transactions->where('status', 'dipinjam')->count() }}
            </div>
        </div>
        <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
            <div class="text-xs text-green-600 font-semibold uppercase tracking-wider">Sudah Dikembalikan</div>
            <div class="text-2xl font-bold text-green-700 mt-2">
                {{ $transactions->where('status', 'kembali')->count() }}
            </div>
        </div>
        <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
            <div class="text-xs text-red-600 font-semibold uppercase tracking-wider">Telat</div>
            <div class="text-2xl font-bold text-red-700 mt-2">
                {{ $transactions->where('status', 'telat')->count() }}
            </div>
        </div>
    </div>
@endif

@endsection
