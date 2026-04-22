<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman & Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Peminjaman & Pengembalian</h1>
    <p>Semua transaksi peminjaman dan pengembalian</p>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->user->name ?? '—' }}</td>
                <td>{{ $t->book->title ?? '—' }}</td>
                <td>{{ $t->borrow_date }}</td>
                <td>{{ $t->due_date }}</td>
                <td>{{ $t->return_date }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>