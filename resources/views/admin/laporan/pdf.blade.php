<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        p {
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #1f2a44;
            color: white;
        }
    </style>
</head>
<body>

<h2>LAPORAN ABSENSI GURU</h2>
<p>Tanggal Cetak: {{ $tanggal }} | Jam: {{ $jam }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Guru</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Jam Datang</th>
            <th>Jam Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporan as $no => $l)
        <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $l->guru->nama }}</td>
            <td>{{ $l->tanggal }}</td>
            <td>{{ $l->status }}</td>
            <td>{{ $l->jam_datang ?? '-' }}</td>
            <td>{{ $l->jam_pulang ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
