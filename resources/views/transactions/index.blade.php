@extends('layouts.app')

@section('content')

{{-- ERROR --}}
@if($errors->any())
<div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="px-6 lg:px-10">
    <h1 class="text-2xl font-bold mb-6">Transaksi Peminjaman</h1>
{{-- FORM PINJAM --}}
<div class="bg-white p-6 rounded shadow mb-6 max-w-4xl">

<form action="/transactions" method="POST" class="grid md:grid-cols-4 gap-4">
@csrf

{{-- USER SEARCH --}}
<div x-data="userSearch()" class="relative">
    <label class="text-sm">User</label>

    <input type="text" x-model="search"
        @input="filter"
        placeholder="Cari user..."
        class="border p-2 rounded w-full">

    <input type="hidden" name="user_id" :value="selectedId">

    <div x-show="results.length"
        class="absolute bg-white border w-full mt-1 rounded shadow z-10 max-h-40 overflow-y-auto">

        <template x-for="item in results" :key="item.id">
            <div @click="select(item)"
                class="p-2 hover:bg-gray-100 cursor-pointer">
                <span x-text="item.name"></span>
            </div>
        </template>
    </div>
</div>

{{-- BOOK SEARCH --}}
<div x-data="bookSearch()" class="relative">
    <label class="text-sm">Buku</label>

    <input type="text" x-model="search"
        @input="filter"
        placeholder="Cari buku..."
        class="border p-2 rounded w-full">

    <input type="hidden" name="book_id" :value="selectedId">

    <div x-show="results.length"
        class="absolute bg-white border w-full mt-1 rounded shadow z-10 max-h-40 overflow-y-auto">

        <template x-for="item in results" :key="item.id">
            <div @click="select(item)"
                class="p-2 hover:bg-gray-100 cursor-pointer">
                <span x-text="item.title + ' (stok: ' + item.stock + ')'"></span>
            </div>
        </template>
    </div>
</div>

{{-- DURATION --}}
<div>
    <label class="text-sm">Hari</label>
    <input type="number" name="duration"
        min="1" max="7"
        placeholder="Lama pinjam"
        class="border p-2 rounded w-full">
</div>

<div class="flex items-end">
    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full">
        Pinjam
    </button>
</div>

</form>
</div>

{{-- SEARCH FORM --}}
<div class="bg-white p-4 rounded shadow mb-6">
    <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama user atau judul buku..."
               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">

    <thead class="bg-slate-800 text-white text-sm">
        <tr>
            <th class="p-3 w-12 text-left">NO</th>
            <th class="p-3 text-left">User</th>
            <th class="p-3 text-left">Buku</th>
            <th class="p-3 text-left">Tgl Pinjam</th>
            <th class="p-3 text-left">Jatuh Tempo</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Denda</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody class="bg-white">
    @forelse($transactions as $t)
        <tr class="border-b last:border-b-0">
            <td class="p-3 align-top">{{ $loop->iteration }}</td>
            <td class="p-3 align-top">{{ $t->user->name ?? '-' }}</td>
            <td class="p-3 align-top">{{ $t->book->title ?? '-' }}<div class="text-xs text-gray-500">{{ $t->book->author ?? '' }}</div></td>
            <td class="p-3 align-top">{{ $t->borrow_date }}</td>
            <td class="p-3 align-top">{{ $t->due_date }}</td>
            <td class="p-3 align-top">
                <span class="inline-block px-2 py-1 text-xs rounded {{ $t->status == 'dipinjam' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">{{ $t->status }}</span>
            </td>
            <td class="p-3 align-top">
                @if($t->fine)
                    @if($t->fine->status == 'belum_bayar')
                        <div class="flex items-center gap-3">
                            <div class="text-sky-700">Rp {{ number_format($t->fine->amount, 0, ',', '.') }}</div>
                            <form action="/fines/{{ $t->fine->id }}/pay" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn-primary" type="submit">Bayar</button>
                            </form>
                        </div>
                    @else
                        <small class="text-green-600">Lunas</small>
                    @endif
                @else
                    -
                @endif
            </td>
            <td class="p-3 align-top">
                <div class="flex gap-2 items-center">
                    <a href="/transactions/{{ $t->id }}/edit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</a>
                    <form action="/transactions/{{ $t->id }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600">Kembali</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center p-4 text-gray-500">Tidak ada data</td>
        </tr>
    @endforelse
    </tbody>

</table>
</div>

{{-- PAGINATION --}}
@if(method_exists($transactions, 'links'))
<div class="mt-4">
    {{ $transactions->links() }}
</div>
@endif

@endsection


{{-- SCRIPT --}}
<script src="//unpkg.com/alpinejs" defer></script>

<script>
function userSearch() {
    return {
        search: '',
        selectedId: null,
        users: @json($users),
        results: [],

        filter() {
            this.results = this.users
                .filter(u => u.name.toLowerCase().includes(this.search.toLowerCase()))
                .slice(0,5)
        },

        select(item) {
            this.search = item.name
            this.selectedId = item.id
            this.results = []
        }
    }
}

function bookSearch() {
    return {
        search: '',
        selectedId: null,
        books: @json($books),
        results: [],

        filter() {
            this.results = this.books
                .filter(b => b.title.toLowerCase().includes(this.search.toLowerCase()))
                .slice(0,5)
        },

        select(item) {
            this.search = item.title
            this.selectedId = item.id
            this.results = []
        }
    }
}
</script>