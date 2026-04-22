@extends('layouts.user')

@section('page_title', 'Notifikasi')
@section('page_subtitle', 'Kelola notifikasi Anda')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-sky-700">Semua Notifikasi</h2>
    </div>
    <div class="flex gap-2">
        @if($notifications->total() > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                    Tandai Semua Dibaca
                </button>
            </form>
            <form action="{{ route('notifications.destroyAll') }}" method="POST" class="inline" onsubmit="return confirm('Hapus semua notifikasi?');">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                    Hapus Semua
                </button>
            </form>
        @endif
    </div>
</div>

@if($notifications->total() > 0)
    <div class="space-y-3">
        @foreach($notifications as $notif)
            <div class="bg-white border-l-4 {{ $notif->is_read ? 'border-gray-300' : 'border-blue-500' }} p-4 rounded shadow hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold {{ $notif->is_read ? 'text-gray-700' : 'text-blue-700' }}">
                                {{ $notif->title }}
                            </h3>
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
                        <p class="text-sm text-gray-600 mt-2">{{ $notif->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        @if(!$notif->is_read && $notif->url)
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                    Baca
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
@else
    <div class="bg-gray-100 rounded-lg p-8 text-center">
        <p class="text-gray-600">Tidak ada notifikasi</p>
    </div>
@endif

@endsection

@push('scripts')
<script>
    @if(session('notification_read'))
        alert("{{ session('notification_read') }}");
    @endif
</script>
@endpush
