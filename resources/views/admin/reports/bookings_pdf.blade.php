<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Bookings</h1>
    <p>Ringkasan siapa yang booking dan berapa kali per buku</p>

    <h2>Ringkasan per Buku</h2>
    <table>
        <thead>
            <tr>
                <th>Buku</th>
                <th>Jumlah Booking</th>
            </tr>
        </thead>
        <tbody>
            @foreach($counts as $c)
            <tr>
                <td>{{ $c->book->title ?? '—' }}</td>
                <td>{{ $c->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Daftar Booking</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $b)
            <tr>
                <td>{{ $b->user->name ?? '—' }}</td>
                <td>{{ $b->book->title ?? '—' }}</td>
                <td>{{ $b->booking_date ? $b->booking_date->format('Y-m-d') : $b->created_at->format('Y-m-d') }}</td>
                <td>{{ $b->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>