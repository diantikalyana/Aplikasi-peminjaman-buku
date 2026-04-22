<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keterlambatan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Keterlambatan</h1>
    <p>Daftar transaksi yang terlambat dikembalikan</p>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Jatuh Tempo</th>
                <th>Kembali</th>
                <th>Hari Terlambat</th>
                <th>Denda</th>
                <th>Status Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lates as $l)
            <tr>
                <td>{{ $l->user->name ?? '—' }}</td>
                <td>{{ $l->book->title ?? '—' }}</td>
                <td>{{ $l->due_date }}</td>
                <td>{{ $l->return_date }}</td>
                <td>
                    @if($l->return_date && $l->due_date)
                        {{ max(0, (strtotime($l->return_date) - strtotime($l->due_date)) / 86400) }} hari
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($l->fine)
                        Rp {{ number_format($l->fine->amount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($l->fine)
                        @if($l->fine->status == 'belum_bayar')
                            Belum Bayar
                        @else
                            Sudah Bayar
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>