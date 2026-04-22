@extends('layouts.app')

@section('content')

<div class="w-full px-6 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Notifikasi Admin</h1>
            <p class="text-gray-600">Kelola semua notifikasi</p>
        </div>
        <div class="flex gap-2">
            @if($notes->total() > 0)
                <form action="{{ route('admin.notifications.markAllRead') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Tandai Semua Dibaca
                    </button>
                </form>
                <form action="{{ route('admin.notifications.destroyAll') }}" method="POST" class="inline" onsubmit="return confirm('Hapus semua notifikasi?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Hapus Semua
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if($notes->total() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Pengguna</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Judul</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Pesan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tipe</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Waktu</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($notes as $note)
                        <tr class="hover:bg-gray-50 {{ !$note->is_read ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4 text-sm">
                                <span class="font-medium">{{ $note->user->name ?? 'System' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $note->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="truncate block max-w-xs">{{ $note->message }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    @if($note->type == 'booking') bg-blue-100 text-blue-700
                                    @elseif($note->type == 'fine') bg-red-100 text-red-700
                                    @elseif($note->type == 'new_book') bg-green-100 text-green-700
                                    @elseif($note->type == 'return_reminder') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    @if($note->type == 'booking') Booking
                                    @elseif($note->type == 'fine') Denda
                                    @elseif($note->type == 'new_book') Buku Baru
                                    @elseif($note->type == 'return_reminder') Pengingat
                                    @else Umum
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($note->is_read)
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">Dibaca</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Belum Dibaca</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $note->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm">
                                <div class="flex justify-center gap-2">
                                    @if(!$note->is_read)
                                        <form action="{{ route('admin.notifications.read', $note->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-500 hover:text-blue-700 text-xs">Baca</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.notifications.destroy', $note->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    @else
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <p class="text-gray-600">Tidak ada notifikasi</p>
        </div>
    @endif
</div>

@endsection
