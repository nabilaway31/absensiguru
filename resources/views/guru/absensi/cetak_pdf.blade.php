<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi - {{ $guru->nama }}</title>
    <style>
        /* Menggunakan font formal untuk dokumen resmi */
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; line-height: 1.5; }
        
        /* Header dengan garis bawah tegas (Border-bottom) */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }

        /* Desain Ringkasan Statistik Tanpa Card (Hanya Baris Tabel) */
        .summary-row { width: 100%; margin-bottom: 20px; border: 1px solid #000; }
        .summary-row td { padding: 8px; text-align: center; border-right: 1px solid #000; }
        .summary-row td:last-child { border-right: none; }
        .label { display: block; font-size: 10px; font-weight: bold; color: #555; text-transform: uppercase; }
        .value { display: block; font-size: 14px; font-weight: bold; }

        /* Tabel Utama dengan garis hitam solid */
        table.main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main-table th, table.main-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.main-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; }
        
        /* Footer Tanda Tangan */
        .footer { margin-top: 40px; width: 100%; }
        .signature { float: right; width: 220px; text-align: center; }
        .space { height: 70px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAPITULASI ABSENSI GURU</h2>
        <p><strong>{{ $guru->nama }}</strong> | NIP: {{ $guru->nip ?? '-' }}</p>
        <p style="font-size: 10px;">Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i') }}</p>
    </div>

    {{-- REKAP TOTAL DALAM BENTUK BARIS TEGAS (BUKAN CARD) --}}
    <table class="summary-row">
        <tr>
            <td>
                <span class="label">Hadir</span>
                <span class="value">{{ $guru->total_hadir }}</span>
            </td>
            <td>
                <span class="label">Izin</span>
                <span class="value">{{ $guru->total_izin }}</span>
            </td>
            <td>
                <span class="label">Sakit</span>
                <span class="value">{{ $guru->total_sakit }}</span>
            </td>
            <td>
                <span class="label">Telat</span>
                <span class="value">{{ $guru->total_telat }}</span>
            </td>
            <td>
                <span class="label">Alfa</span>
                <span class="value" style="color: red;">{{ $guru->total_alfa }}</span>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 140px;">Tanggal</th>
                <th style="text-align: center;">Jam Masuk</th>
                <th style="text-align: center;">Jam Pulang</th>
                <th style="width: 90px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru->absensi as $key => $item)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                <td style="text-align: center;">{{ $item->jam_datang ?? '--:--:--' }}</td>
                <td style="text-align: center;">{{ $item->jam_pulang ?? '--:--:--' }}</td>
                <td style="text-align: center;">
                    <strong>{{ $item->status }}</strong>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN ADMIN --}}
    <div class="footer">
        <div class="signature">
            <p>Mojokerto, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrator,</p>
            <div class="space"></div>
            <p><strong><u>ADMIN SISTEM</u></strong></p>
            <p style="font-size: 10px; color: #555;">Sistem Manajemen Absensi</p>
        </div>
    </div>
</body>
</html>