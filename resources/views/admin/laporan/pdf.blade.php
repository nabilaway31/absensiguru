<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Guru</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; word-wrap: break-word; }
        th { background-color: #1e293b; color: white; text-transform: uppercase; }
        
        /* Mengatur lebar kolom agar tidak berantakan */
        .col-no { width: 30px; }
        .col-nip { width: 100px; }
        .col-nama { width: 180px; text-align: left; }
        .col-tgl { width: 80px; }
        .col-status { width: 70px; }
        .col-jam { width: 80px; }

        .footer { margin-top: 30px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Absensi Guru</h2>
        @if(request('from') && request('to'))
        <p>Periode: {{ request('from') }} s/d {{ request('to') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nip">NIP</th>
                <th class="col-nama">Nama Guru</th>
                <th class="col-tgl">Tanggal</th>
                <th class="col-status">Status</th>
                <th class="col-jam">Jam Datang</th>
                <th class="col-jam">Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->guru->nip ?? '-' }}</td>
                <td style="text-align: left;">{{ $item->guru->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->jam_datang ?? '-' }}</td>
                <td>{{ $item->jam_pulang ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Absensi Guru
    </div>
</body>
</html>