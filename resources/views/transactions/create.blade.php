@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pinjam Buku</h1>

        <a href="/transactions"
           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
           Kembali
        </a>
    </div>

    {{-- ERROR --}}
    @if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white p-6 rounded shadow">
        <form action="/transactions" method="POST" class="grid gap-4">
        @csrf

        {{-- USER --}}
        <div x-data="userSearch()" class="relative">
            <label class="text-sm font-medium">User</label>

            <input type="text" x-model="search"
                @input="filter"
                placeholder="Cari user..."
                class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400">

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

        {{-- BUKU --}}
        <div x-data="bookSearch()" class="relative">
            <label class="text-sm font-medium">Buku</label>

            <input type="text" x-model="search"
                @input="filter"
                placeholder="Cari buku..."
                class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400">

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
            <label class="text-sm font-medium">Lama Pinjam (hari)</label>
            <input type="number" name="duration"
                min="1" max="7"
                placeholder="Maksimal 7 hari"
                class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400">
        </div>

        {{-- BUTTON --}}
        <button
            class="bg-green-500 text-white py-2 rounded hover:bg-green-600 transition">
            Pinjam Buku
        </button>

        </form>
    </div>

</div>

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