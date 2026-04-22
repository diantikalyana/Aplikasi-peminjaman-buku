<aside class="w-64 fixed left-0 top-0 h-full bg-white shadow-md border-r border-sky-50 p-4">
   <div class="mb-6 flex items-center gap-3">
    
    {{-- LOGO --}}
    <img src="{{ asset('logo.png') }}" 
         class="w-10 h-10 object-contain">

    <div>
        <div class="text-sm font-semibold text-sky-700">LB SMKMW9</div>
        <div class="text-xs text-sky-500">Member Area</div>
    </div>

</div>
</a>
    </div>

    <nav class="flex flex-col gap-1">
        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sky-700 hover:bg-sky-50 {{ request()->routeIs('dashboard') ? 'bg-sky-100 font-semibold' : '' }}">Buku</a>
        <a href="{{ route('bookings.index') }}" class="px-3 py-2 rounded-md text-sky-700 hover:bg-sky-50 {{ request()->routeIs('bookings.*') ? 'bg-sky-100 font-semibold' : '' }}">Bookings</a>
        <a href="{{ route('user.history') }}" class="px-3 py-2 rounded-md text-sky-700 hover:bg-sky-50 {{ request()->routeIs('user.history') ? 'bg-sky-100 font-semibold' : '' }}">Riwayat</a>
        
        {{-- NOTIFICATION LINK --}}
        <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-sky-700 hover:bg-sky-50 {{ request()->routeIs('notifications.*') ? 'bg-sky-100 font-semibold' : '' }}">
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

        {{-- FINES LINK --}}
        <a href="{{ route('user.fines') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-sky-700 hover:bg-sky-50 {{ request()->routeIs('user.fines') ? 'bg-sky-100 font-semibold' : '' }}">
            <span>💰 Denda</span>
            @php
                $unpaidFinesCount = \App\Models\Fine::whereHas('transaction', function ($query) {
                    $query->where('user_id', auth()->id());
                })->where('status', 'belum_bayar')->count();
            @endphp
            @if($unpaidFinesCount > 0)
                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                    {{ $unpaidFinesCount > 99 ? '99+' : $unpaidFinesCount }}
                </span>
            @endif
        </a>
    </nav>

    <div class="mt-auto pt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-red-50">Log out</button>
        </form>
    </div>
</aside>
