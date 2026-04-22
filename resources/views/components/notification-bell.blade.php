<!-- Notification Bell for User Dashboard -->
<div x-data="notificationBell()" class="relative">
    <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center text-gray-600 hover:text-sky-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

    <!-- Dropdown Menu -->
    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 hidden" x-show="open" @click.outside="open = false">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold">Notifikasi</h3>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST" class="inline" style="margin: 0;">
                    @csrf
                    <button type="submit" class="text-xs text-blue-500 hover:text-blue-700">Tandai Semua Dibaca</button>
                </form>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @if($notifications->count() > 0)
                @foreach($notifications as $notif)
                    <div class="px-4 py-3 border-b hover:bg-gray-50 {{ !$notif->is_read ? 'bg-blue-50' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold {{ !$notif->is_read ? 'text-blue-700' : 'text-gray-700' }}">
                                    {{ $notif->title }}
                                </h4>
                                <p class="text-xs text-gray-600 mt-1">{{ Str::limit($notif->message, 100) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if(!$notif->is_read && $notif->url)
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="text-xs text-blue-500 hover:text-blue-700">
                                    Baca selengkapnya →
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="p-4 text-center text-gray-500 text-sm">
                    Tidak ada notifikasi baru
                </div>
            @endif
        </div>

        <div class="p-3 border-t">
            <a href="{{ route('notifications.index') }}" class="block w-full text-center px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                Lihat Semua Notifikasi
            </a>
        </div>
    </div>
</div>

<script>
function notificationBell() {
    return {
        open: false,
        unreadCount: {{ $unreadCount ?? 0 }},
        notifications: {{ json_encode($notifications ?? []) }},
    }
}
</script>
