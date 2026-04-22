@extends('layouts.user')

@section('page_title','Denda Saya')
@section('page_subtitle','Daftar denda yang belum dibayar')

@section('content')

@if(session('success'))
    <div class="p-3 bg-green-50 text-green-700 rounded mb-4">{{ session('success') }}</div>
@endif

@if($fines->count() > 0)
    <div class="space-y-4">
        @foreach($fines as $fine)
        <div class="bg-white shadow rounded p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $fine->transaction->book->title ?? 'Buku tidak ditemukan' }}</h3>
                    <p class="text-sm text-gray-600">Penulis: {{ $fine->transaction->book->author ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-red-600">Rp {{ number_format($fine->amount, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-500">{{ $fine->days_late }} hari terlambat</div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Tanggal Pinjam:</span>
                    <div class="text-gray-600">{{ $fine->transaction->borrow_date ? $fine->transaction->borrow_date->format('d/m/Y') : $fine->transaction->created_at->format('d/m/Y') }}</div>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Jatuh Tempo:</span>
                    <div class="text-gray-600">{{ $fine->transaction->due_date ? $fine->transaction->due_date->format('d/m/Y') : '-' }}</div>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Tanggal Kembali:</span>
                    <div class="text-gray-600">{{ $fine->transaction->return_date ? $fine->transaction->return_date->format('d/m/Y') : 'Belum dikembalikan' }}</div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Status: <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Belum Dibayar</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        Denda dibuat: {{ $fine->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded p-4">
        <div class="flex items-center">
            <div class="text-yellow-600 mr-3">⚠️</div>
            <div>
                <h4 class="font-medium text-yellow-800">Pembayaran Denda</h4>
                <p class="text-sm text-yellow-700 mt-1">Silakan hubungi petugas perpustakaan untuk melakukan pembayaran denda.</p>
            </div>
        </div>
    </div>
@else
    <div class="bg-white shadow rounded p-8 text-center">
        <div class="text-6xl mb-4">✅</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Denda</h3>
        <p class="text-gray-600">Selamat! Anda tidak memiliki denda yang belum dibayar.</p>
    </div>
@endif

@endsection