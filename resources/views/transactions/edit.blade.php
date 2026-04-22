<h1>Pengembalian Buku</h1>

<p>Nama: {{ $transaction->user->name }}</p>
<p>Buku: {{ $transaction->book->title }}</p>
<p>Tgl Pinjam: {{ $transaction->borrow_date }}</p>
<p>Jatuh Tempo: {{ $transaction->due_date }}</p>

<form action="/transactions/{{ $transaction->id }}" method="POST">
@csrf
@method('PUT')

<button type="submit">Konfirmasi Kembali</button>
</form>

<a href="/transactions">Kembali</a>