<div class="bg-white shadow px-6 py-4 flex justify-between items-center">

   <h1 class="text-lg md:text-xl font-bold text-gray-800">
    PERPUSTAKAAN SMK MA'ARIF WALISONGO KAJORAN
</h1>

    {{-- RIGHT --}}
    <div class="flex items-center gap-6">

        {{-- NOTIFICATION BELL (ADMIN) --}}
        <div class="relative">
            @php
                $unreadCount = auth()->user()->unreadNotificationsCount() ?? 0;
            @endphp
            <a href="{{ route('admin.notifications.index') }}" class="relative inline-flex items-center text-gray-600 hover:text-blue-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                @if($unreadCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>
        </div>

        {{-- PROFILE --}}
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            <span>{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>

    </div>

</div>