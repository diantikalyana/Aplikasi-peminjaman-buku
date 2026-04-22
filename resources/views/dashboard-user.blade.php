 @extends('layouts.user')

@section('page_title','Perpustakaan SMK Ma\'arif Walisongo Kajoran')
@section('page_subtitle','Semua buku tersedia untuk dipinjam')

@section('content')

<div class="mb-6 flex items-center justify-between">
    @if($unreadCount > 0)
        <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
            🔔 {{ $unreadCount }} Notifikasi Baru
        </a>
    @endif
</div>

{{-- NOTIFIKASI TERBARU --}}
@if($unreadNotifications->count() > 0)
<div class="mb-6 space-y-2">
    @foreach($unreadNotifications as $notif)
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded flex justify-between items-start">
        <div class="flex-1">
            <h3 class="font-semibold text-blue-700">{{ $notif->title }}</h3>
            <p class="text-sm text-gray-600">{{ $notif->message }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
        </div>
        @if(!$notif->is_read && $notif->url)
            <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="inline ml-2">
                @csrf
                <button type="submit" class="px-3 py-1 bg-blue-500 text-white text-xs rounded">
                    Baca
                </button>
            </form>
        @endif
    </div>
    @endforeach
</div>
@endif

{{-- FILTER KATEGORI --}}
<div class="flex gap-2 mb-6 overflow-x-auto">

    <a href="/dashboard" class="px-4 py-2 rounded-full text-sm {{ request('category') ? 'bg-gray-200' : 'bg-blue-500 text-white' }}">Semua</a>

    @foreach($categories as $cat)
    <a href="/dashboard?category={{ $cat->id }}" class="px-4 py-2 rounded-full text-sm {{ request('category') == $cat->id ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">{{ $cat->name }}</a>
    @endforeach

</div>

{{-- GRID BUKU --}}
<div class="flex flex-wrap gap-4">

    @forelse($books as $book)
    <div class="book-card" tabindex="0" role="button" data-id="{{ $book->id }}" data-title="{{ htmlspecialchars($book->title, ENT_QUOTES) }}" data-author="{{ htmlspecialchars($book->author ?? '-', ENT_QUOTES) }}" data-category="{{ $book->category->name ?? '-' }}" data-stock="{{ $book->stock }}" data-desc="{{ htmlspecialchars($book->description ?? '-', ENT_QUOTES) }}" data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}">

        <div class="cover-thumb">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover">
            @else
                <div class="text-gray-400">No Image</div>
            @endif
        </div>

        <div class="info">
            <div class="title">{{ Str::limit($book->title, 40) }}</div>
            <div class="author">{{ $book->author }}</div>
            <div class="text-xs mt-2">Stok: <span class="font-medium">{{ $book->stock }}</span></div>
        </div>

    </div>

    @empty
    <p class="text-gray-500">Belum ada buku</p>
    @endforelse

</div>

<div id="modalOverlay" class="modal-overlay"></div>

<div id="bookModal"
    class="fixed inset-0 flex items-center justify-center z-50 hidden">

    <div class="bg-white rounded-xl shadow-2xl w-[520px] max-w-full p-5 flex gap-4">

        <div class="w-[180px] h-[240px] bg-gray-100 rounded overflow-hidden flex items-center justify-center">
            <img id="modalCover" class="w-full h-full object-cover" />
        </div>

        <div class="flex-1 flex flex-col">
            <h2 id="modalTitle" class="text-lg font-semibold"></h2>
            <div id="modalAuthor" class="text-sm text-sky-600"></div>
            <div id="modalCategory" class="text-xs text-sky-500 mt-1"></div>

            <p id="modalDesc" class="mt-3 text-sm text-gray-600"></p>

            <div class="mt-auto flex gap-2">
                <a id="bookAction" href="#" class="btn-primary">Booking</a>
                <button id="closeModal" class="px-3 py-1 border rounded text-sm bg-white">Close</button>
            </div>
        </div>

    </div>
</div>
</div>

    <script>
    (function(){
        const cards = Array.from(document.querySelectorAll('.book-card'));
        const overlay = document.getElementById('modalOverlay');
        const modal = document.getElementById('bookModal');
        const modalCover = document.getElementById('modalCover');
        const modalTitle = document.getElementById('modalTitle');
        const modalAuthor = document.getElementById('modalAuthor');
        const modalCategory = document.getElementById('modalCategory');
        const modalDesc = document.getElementById('modalDesc');
        const bookAction = document.getElementById('bookAction');
        const closeBtn = document.getElementById('closeModal');

        const searchInput = document.getElementById('userSearch');
        const suggestionsBox = document.getElementById('searchSuggestions');

        const bookingStoreUrl = "{{ route('bookings.store') }}";
        const bookingsIndexUrl = "{{ route('bookings.index') }}";

        function openModal(data){
    modalCover.src = data.cover || '';
    modalTitle.textContent = data.title;
    modalAuthor.textContent = data.author;
    modalCategory.textContent = data.category + ' • Stok: ' + data.stock;
    modalDesc.textContent = data.desc;

    bookAction.dataset.bookId = data.id;

    overlay.classList.add('show');
    modal.classList.remove('hidden'); // ✅ ini
}

function closeModal(){
    overlay.classList.remove('show');
    modal.classList.add('hidden'); // ✅ ini
}

        

        function cardData(card){
            return {
                id: card.dataset.id,
                title: card.dataset.title || '',
                author: card.dataset.author || '',
                category: card.dataset.category || '',
                stock: card.dataset.stock || '',
                desc: card.dataset.desc || '',
                cover: card.dataset.cover || ''
            };
        }

        // attach click on cards to open modal
        cards.forEach(c => {
            c.addEventListener('click', function(){
                openModal(cardData(this));
            });
        });

        overlay.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);

        // booking via fetch when clicking Booking
        bookAction.addEventListener('click', function(e){
            e.preventDefault();
            const id = this.dataset.bookId;
            if (!id) return;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const bookingDate = new Date().toISOString().slice(0,10);

            fetch(bookingStoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ book_id: id, booking_date: bookingDate })
            }).then(r => {
                if (r.ok) return r.json().catch(() => ({}));
                return r.json().then(err => Promise.reject(err));
            }).then(data => {
                // redirect to bookings list to show user's bookings
                window.location.href = bookingsIndexUrl;
            }).catch(err => {
                try { alert(err.message || 'Gagal membuat booking'); } catch(e){ console.error(err); }
            });
        });

        // search/filter logic
        if (searchInput) {
            function normalize(s){ return (s||'').toString().toLowerCase(); }

            function renderSuggestions(matches){
                if (!suggestionsBox) return;
                suggestionsBox.innerHTML = '';
                if (!matches.length) { suggestionsBox.classList.add('hidden'); return; }
                const list = document.createElement('div');
                list.className = 'search-suggestions-list';
                matches.slice(0,8).forEach(m => {
                    const el = document.createElement('div');
                    el.className = 'search-suggestion';
                    el.innerHTML = `<div class="meta">${m.title}</div><div class="sub">${m.author} • ${m.category}</div>`;
                    el.addEventListener('click', () => {
                        // find matching card
                        const card = cards.find(c => c.dataset.id == m.id);
                        if (card) {
                            card.scrollIntoView({behavior:'smooth', block:'center'});
                            openModal(cardData(card));
                        }
                        suggestionsBox.classList.add('hidden');
                    });
                    list.appendChild(el);
                });
                suggestionsBox.appendChild(list);
                suggestionsBox.classList.remove('hidden');
            }

            function updateFilter(q){
                const qn = normalize(q);
                if (!qn) {
                    cards.forEach(c => c.style.display = '');
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                const matches = [];
                cards.forEach(c => {
                    const d = cardData(c);
                    const hay = normalize(d.title+' '+d.author+' '+d.category);
                    const matched = hay.indexOf(qn) !== -1;
                    c.style.display = matched ? '' : 'none';
                    if (matched) matches.push(d);
                });

                // dedupe by id
                const uniq = [];
                const seen = new Set();
                for (const m of matches) {
                    if (!seen.has(m.id)) { seen.add(m.id); uniq.push(m); }
                }
                renderSuggestions(uniq);
            }

            let debounceTimer;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => updateFilter(e.target.value), 150);
            });

            // hide suggestions on outside click
            document.addEventListener('click', (e) => {
                if (!suggestionsBox) return;
                if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
                    suggestionsBox.classList.add('hidden');
                }
            });
        }
    })();
    </script>

    @push('scripts')
    <script>
        @if(session('notification_read'))
            alert("{{ session('notification_read') }}");
        @endif
    </script>
    @endpush

@endsection