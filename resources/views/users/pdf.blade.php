<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Anggota</title>
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
        .role-admin {
            background-color: #fef3c7;
            color: #92400e;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .role-user {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .status-active {
            background-color: #dcfce7;
            color: #15803d;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .status-inactive {
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
    <h1>👥 Data Anggota Perpustakaan</h1>
    <p>Laporan lengkap anggota yang terdaftar di perpustakaan</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 15%;">Username</th>
                <th style="width: 20%;">Nama Lengkap</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 10%;">Role</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 20%;">Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->full_name ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="role-admin">{{ ucfirst($user->role) }}</span>
                    @else
                        <span class="role-user">{{ ucfirst($user->role) }}</span>
                    @endif
                </td>
                <td>
                    @if($user->status === 'active')
                        <span class="status-active">{{ ucfirst($user->status) }}</span>
                    @else
                        <span class="status-inactive">{{ ucfirst($user->status) }}</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #999;">Tidak ada data anggota</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Anggota: <strong>{{ $users->count() }}</strong> | Dicetak pada: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
    </div>
</body>
</html>