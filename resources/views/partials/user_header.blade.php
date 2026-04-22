<header class="bg-white border-b border-sky-100 pl-72 pr-6 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex items-center justify-between relative">
        <div>
            <h1 class="text-xl font-semibold text-sky-700">@yield('page_title', 'Dashboard')</h1>
            <p class="text-sm text-sky-500">@yield('page_subtitle')</p>
        </div>

        <div class="flex items-center gap-6">
            <div class="relative">
                <input id="userSearch" type="search" placeholder="Cari judul, penulis, kategori..." class="px-3 py-2 border rounded-md w-64 focus:outline-none focus:ring-2 focus:ring-sky-200" autocomplete="off" />
                <div id="searchSuggestions" class="absolute mt-1 left-0 right-0 bg-white border rounded-md shadow-lg hidden z-40"></div>
            </div>

            {{-- NOTIFICATION BELL (USER) --}}
            <div class="relative">
                @php
                    $unreadCount = auth()->user()->unreadNotificationsCount() ?? 0;
                @endphp
                <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center text-gray-600 hover:text-sky-700 transition" title="Notifikasi">
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

            <div class="text-sm text-sky-700">{{ Auth::user()->name }}</div>
        </div>
    </div>
</header>
