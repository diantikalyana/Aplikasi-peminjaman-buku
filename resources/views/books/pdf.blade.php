<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Buku</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 { 
            text-align: center;
            color: #333;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 10px;
        }
        p {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: -10px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left;
            font-size: 11px;
        }
        th { 
            background-color: #1e3a8a; 
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .stock-available {
            background-color: #dcfce7;
            color: #15803d;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .stock-unavailable {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>📚 Data Buku Perpustakaan</h1>
    <p>Laporan lengkap koleksi buku yang tersedia di perpustakaan</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 20%;">Judul</th>
                <th style="width: 15%;">Penulis</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 8%;">Stok</th>
                <th style="width: 37%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $book->title }}</strong></td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name ?? '-' }}</td>
                <td>
                    @if($book->stock > 0)
                        <span class="stock-available">{{ $book->stock }}</span>
                    @else
                        <span class="stock-unavailable">{{ $book->stock }}</span>
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($book->description, 100) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999;">Tidak ada data buku</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Buku: <strong>{{ $books->count() }}</strong> | Dicetak pada: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
    </div>
</body>
</html>
